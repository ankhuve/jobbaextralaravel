<?php namespace App\Http\Controllers;

use App\Job;
use App\User;
use Carbon\Carbon;
use DB;
use GuzzleHttp\Client;
use Illuminate\Pagination\LengthAwarePaginator;
use Input;
use Illuminate\Http\Request;
use TomLingham\Searchy\Facades\Searchy;


class SearchController extends Controller
{

    protected $numPerPage = 20;

    public function index(Request $request)
    {
        $request->flash();
        return view('pages.search', ['request' => $request]);

    }

    public function getJobs(Request $request)
    {
        if(Input::get('q')){
            $keyword = Input::get('q');
        } else{
            $keyword = null;
        }

        // om inte Input::get('sida') finns, defaulta till 1
        if(is_null(Input::get('sida')) || Input::get('sida') <= 1){
            $askedPage = 1;
        } else{
            $askedPage = (int)Input::get('sida');
        }

        // hämta våra jobb
        if (!is_null($keyword) || Input::get('lan') != "" || Input::get(config('app.af_type_name_minor')) != "") {
            // om vi har ett sökord eller parametrar
            $customResults = $this->searchCustomJobs($keyword, $request, $askedPage);
        } else {
            // om vi inte har några filter eller sökord
            $customResults = $this->getNewestCustomJobs(); // get the newest custom jobs
        }

        // calculate at which page AF-jobs will start to paginate
        $totalCustomJobs = $customResults['searchMeta'];
        $offset = $totalCustomJobs % $this->numPerPage;
        $numToGetFromAF = ($this->numPerPage - $offset);

        // firstPageWithAfJobs is the first page where only AF-jobs will be displayed
        if($offset === 0 && $totalCustomJobs > 0){
            $firstPageWithAFJobs = (int)ceil($totalCustomJobs / $this->numPerPage) + 1;
        } else{
            // if we have custom job matches and are on a page with only
            // AF jobs, or if we don't have any custom job matches
            $firstPageWithAFJobs = (int)ceil($totalCustomJobs / $this->numPerPage);
        }

        $firstPageToGetFromAF = ($askedPage - $firstPageWithAFJobs) + 1;
        if($totalCustomJobs === 0){
            // om vi inte har några custom jobs
            $firstPageToGetFromAF = $askedPage;
        }
        elseif($offset != 0 && ($firstPageWithAFJobs + 1) === $askedPage){
            $firstPageToGetFromAF = $askedPage - 1;
        }
        elseif($offset != 0 && $askedPage > $firstPageWithAFJobs) {
            $firstPageToGetFromAF--;
        }
        elseif($totalCustomJobs > 0 && $offset === 0){
            ($askedPage - $firstPageWithAFJobs) > 0 ? $firstPageToGetFromAF = $askedPage - $firstPageWithAFJobs + 1 : $firstPageToGetFromAF = 1;
        }
        else{
            $firstPageToGetFromAF = 1;
        }


//        dd('page: ' . $askedPage, 'firstPageToGetFromAF: ' . $firstPageToGetFromAF, 'firstPageWithAfJobs: ' . $firstPageWithAFJobs, 'offset: ' . $offset, 'numToGetFromAf: ' . $numToGetFromAF);

        $askedPage >= $firstPageWithAFJobs ? $shouldGetAFJobs = true : $shouldGetAFJobs = false;

        // calculate which pages to get from AF API and then get the jobs
        if($firstPageWithAFJobs > $askedPage){
            // om vi inte ska hämta några jobb, men vill ha stats ändå (sida med bara custom jobs)
            $afSearchMeta['antal_platsannonser'] = $this->getNumberOfAfJobs($keyword);
        }
        elseif(($totalCustomJobs % $this->numPerPage) === 0 && $shouldGetAFJobs){
            // om vi inte har offset och är på en sida där af-jobb ska hämtas
            $results = $this->search($keyword, $numToGetFromAF, $firstPageToGetFromAF); // get jobs from Arbetsförmedlingen
            if ($results) {
                $afJobs = $results['jobMatches'];
                $afSearchMeta = $results['searchMeta'];
            }

        }
        elseif($offset != 0 && $askedPage === $firstPageWithAFJobs){
            // om vi är på första sidan med AF-jobb och har custom jobs
            $results = $this->search($keyword, $this->numPerPage, $firstPageToGetFromAF); // get jobs from Arbetsförmedlingen
            if($results){
                // ta bort överflödiga jobb som kommer visas på nästa sida (ta bort från botten)
                $results['jobMatches']->splice($numToGetFromAF);

                $afJobs = $results['jobMatches'];
                $afSearchMeta = $results['searchMeta'];
            }
        }
        elseif($offset != 0 && $askedPage > $firstPageWithAFJobs){
            // om vi behöver slå ihop två sidor för att bilda vår egen
            $secondPageToGetFromAF = $firstPageToGetFromAF + 1;

            $results = $this->search($keyword, $this->numPerPage, $firstPageToGetFromAF); // get jobs from Arbetsförmedlingen
            $resultsSecond = $this->search($keyword, $this->numPerPage, $secondPageToGetFromAF); // get jobs from Arbetsförmedlingen


            if($results && $resultsSecond){
                // ta bort jobben vi redan visat på förra sidan (ta bort från toppen)
                $results['jobMatches'] = $results['jobMatches']->slice($numToGetFromAF);

                // ta bort jobben vi inte vill visa (ta bort från botten)
                $resultsSecond['jobMatches']->splice($numToGetFromAF);

                // slå ihop de två sidorna till en array med $numPerPage jobb
                $results['jobMatches'] = $results['jobMatches']->merge($resultsSecond['jobMatches']);
                $results['searchMeta'] = $resultsSecond['searchMeta'];

                $afJobs = $results['jobMatches'];
                $afSearchMeta = $results['searchMeta'];
            }
            elseif($results && is_null($resultsSecond)){

                $afJobs = $results['jobMatches'];
                $afSearchMeta = $results['searchMeta'];
            }
            else {
                // om vi är på sista sidan
                $results = $this->search($keyword, $this->numPerPage, $firstPageToGetFromAF); // get jobs from Arbetsförmedlingen
                if($results){
                    $results['jobMatches'] = $results['jobMatches']->slice($numToGetFromAF);
                    $afJobs = $results['jobMatches'];
                    $afSearchMeta = $results['searchMeta'];
                }

            }
        }
        else{
            // om vi är på sista sidan med AF-jobb
            $results = $this->search($keyword, $this->numPerPage, $firstPageToGetFromAF); // get jobs from Arbetsförmedlingen

            if($results){
                // ta bort överflödiga jobb som kommer visas på nästa sida (ta bort från botten)
                $results['jobMatches']->splice($numToGetFromAF);

                $afJobs = $results['jobMatches'];
                $afSearchMeta = $results['searchMeta'];
            }
            else{
                // om det är slut på resultat
                $request->flash();
                return view('pages.search', ['jobs' => [], 'searchMeta' => [], 'currentPage' => $askedPage]);
            }
        }

        if(isset($afJobs)){
            // merga de två källorna med träffar till en Collection
            $allJobs = collect($customResults['jobMatches'])->merge($afJobs);
        }
        else{
            $allJobs = collect($customResults['jobMatches']);
        }

        $searchMeta = [];
        $searchMeta['customJobs'] = $customResults['searchMeta'];
        $searchMeta['all'] = $searchMeta['customJobs'];
        if(isset($afSearchMeta)){
            $searchMeta['afJobs'] = $afSearchMeta['antal_platsannonser'];
            $searchMeta['all'] += isset($searchMeta['afJobs']) ? $searchMeta['afJobs'] : 0;
        }
        else{
            $numberOfAfJobs = $this->getNumberOfAfJobs($keyword);
            $searchMeta['afJobs'] = $numberOfAfJobs;
            $searchMeta['all'] += $numberOfAfJobs;
        }
        $searchMeta['numPages'] = ceil($searchMeta['all'] / $this->numPerPage);


        // Make a paginator to paginate the search results
        $currPage = Input::get('sida') ?: null;
        $paginator = new LengthAwarePaginator($allJobs, $searchMeta['all'], $this->numPerPage, $currPage,
            [
                'path' => 'hitta',
                'query' => $request->except('sida')
            ]);

        $paginator->setPageName('sida');
        $paginatorMarkup = $paginator->render();

        if ($request->ajax()) {
            return response()->json([
                'searchMeta' => $searchMeta,
                'allJobs' => $allJobs,
                'paginatorMarkup' => $paginatorMarkup,
                'paginator' => $paginator->toArray(),
                'currentPage' => $askedPage,
                'request' => $request
            ]);
        }
        else{
            return ['jobs' => $allJobs, 'searchMeta' => $searchMeta, 'currentPage' => $askedPage, 'request' => $request, 'paginator' => $paginator];
        }
    }

    public static function getNumberOfAfJobs($keyword = null)
    {
        $client = new Client(['base_uri' => 'http://api.arbetsformedlingen.se/af/v0/']);

        $searchParams = [
            'anstallningstyp' => 1,
            'antalrader' => 1,
        ];

        if(isset($keyword)){
            $searchParams['nyckelord'] = $keyword;
        }

        if(Input::get('lan')){
            // om sökningen är typ 'norge'
            if(Input::get('lan') > 120){
                $searchParams['landid'] = Input::get('lan');
            }
            else{
                $searchParams['lanid'] = Input::get('lan');
            }
        }

        if(Input::get(config('app.af_type_name_minor'))){
            if (Input::get(config('app.af_type_name_minor')) < 9000) {
                $searchParams[config('app.af_type_name_minor')] = Input::get(config('app.af_type_name_minor'));
            }
            else {
                return 0;
            }
        }

        try{
            $searchResults = $client->get('platsannonser/matchning', [
                'query' => $searchParams,
                'headers' => [
                    'Accept' => 'application/json',
                    'Accept-Language' => 'sv-se,sv'
                ]
            ]);

            $response = json_decode($searchResults->getBody()->getContents());
            $numHits = $response->matchningslista->antal_platsannonser;

            return $numHits;
        } catch(\Exception $e){
            return 0;
        }
    }


    /**
     *
     * Get jobs from the Arbetsförmedlingen API.
     *
     * @param null $keyword
     * @param int $numRows
     * @param int $pageToGet
     * @return mixed
     * @internal param Request $request
     */
    public function search($keyword = null, $numRows = 0, $pageToGet = 1)
    {
        // möjliga parametrar:
        //    yrkesid
        //    Kommunid
        //    Lanid
        //    Nyckelord
        //    antalrader
        //    Sida
        //    landId
        //    omradeId
        //    yrkesgruppId
        //    anstallningsTyp
        //    yrkesomradeId
        //    Sokdatum
        //    Organisationsnummer
        $client = new Client(['base_uri' => 'http://api.arbetsformedlingen.se/af/v0/']);

        $searchParams = [
            'antalrader' => $numRows,
            'anstallningstyp' => 1,
            'sida' => $pageToGet
        ];

        if(isset($keyword)){
            $searchParams['nyckelord'] = $keyword;
        }

        if(Input::get('lan')){
            // om sökningen är typ 'norge'
            if(Input::get('lan') > 120){
                $searchParams['landid'] = Input::get('lan');
            } else{
                $searchParams['lanid'] = Input::get('lan');
            }
        }

        if(Input::get(config('app.af_type_name_minor'))){
            if (Input::get(config('app.af_type_name_minor')) < 9000) {
                $searchParams[config('app.af_type_name_minor')] = Input::get(config('app.af_type_name_minor'));
            }
            else {
                return false;
            }
        }

        try{
            $searchResults = $client->get('platsannonser/matchning', [
                'query' => $searchParams,
                'headers' => [
                    'Accept' => 'application/json',
                    'Accept-Language' => 'sv-se,sv'
                ]
            ]);
            // Create a Collection of the results
            $response = collect(json_decode($searchResults->getBody()->getContents()));
            $searchMeta = collect($response->get('matchningslista'));
            $searchMeta->pop(); // remove the job ads from the Collection


            if(array_key_exists('matchningdata', $response->get('matchningslista'))){
                $jobMatches = collect($response->get('matchningslista')->matchningdata); // the queried jobs
            } else{
                return false;
            }

            foreach ($jobMatches as $job){
                $job->url = action('JobController@index', $job->annonsid);
                $job->time_since_published = (Carbon::createFromFormat('Y-m-d\TH:i:se', $job->publiceraddatum)->isSameDay(Carbon::today())) ? 'Publicerad idag' : ((Carbon::createFromFormat('Y-m-d\TH:i:se', $job->publiceraddatum)->isSameDay(Carbon::yesterday())) ? 'Publicerades igår' : Carbon::createFromFormat('Y-m-d\TH:i:se', $job->publiceraddatum)->startOfDay()->diffInDays(Carbon::now()) . ' dagar sedan');
            }

            return compact(['jobMatches', 'searchMeta']);

        } catch(\Exception $e){
            return compact(['jobMatches' => [], 'searchMeta' => []]);
        }
    }

    public function searchCustomJobs($keyword = null, Request $request, $askedPage = 1)
    {
        $askedPage = $askedPage - 1;
        $rowsToSkip = (int)($askedPage * $this->numPerPage);

        // Sets the parameters from the get request to the variables.
        $searchQuery = $keyword;

        if($searchQuery){
            // Hämta antal träffar för sökmeta
            $allMatches = Searchy::search('jobs')
                ->fields('title', 'work_place')
                ->query($searchQuery)
                ->getQuery()
                ->having('relevance', '>', 30)
                ->orderBy('relevance', 'desc')
                ->where('latest_application_date', '>=', Carbon::today()->toDateString());
        } else{
            $allMatches = Job::query()->where('latest_application_date', '>=', Carbon::today()->toDateString())->orderBy('published_at', 'desc');
        };

        $searchParams = [];

        // filtrera resultaten
        if (Input::get('lan') != ""){
            $searchParams['lanid'] = Input::get('lan');
            // Filtrera på län
            if (isset($searchParams['lanid'])){
                $allMatches = $allMatches->where('county', $searchParams['lanid']);
            }
        }

        $resultsAreCollection = false;
        if (Input::get(config('app.af_type_name_minor'))){
            $searchParams[config('app.af_type_name_minor')] = Input::get(config('app.af_type_name_minor'));

            // Get all matches so we can go through the type column
            $matchesCollection = $allMatches->get();

            // filter out the matches which have the requested type
            $allMatches = $matchesCollection->filter(
                function ($match) use ($searchParams) {
                $types = collect(json_decode($match->type));
                return ($types->contains($searchParams[config('app.af_type_name_minor')]));
            });

            $resultsAreCollection = true;
        }

        if (!$resultsAreCollection) {
            // Hämta träffarna för sidan
            $allMatches = collect($allMatches->get());
        }

        $numTotalMatches = $allMatches->count();
        $pageResults = $allMatches->splice($rowsToSkip, $this->numPerPage);

        $pageResults = $this->prepareJobAttributes($pageResults);

        $results = [
            'jobMatches'   => $pageResults,
            'searchMeta'    => $numTotalMatches
        ];
        return $results;
    }

    public function getNewestCustomJobs()
    {
        $pageResults = DB::table('jobs')
            ->where('latest_application_date', '>=', Carbon::today()->toDateString())
            ->orderBy('published_at', 'desc')
            ->paginate($this->numPerPage, ['*'], $pageName = 'sida')
            ->all();

        $pageResults = $this->prepareJobAttributes($pageResults);

        $numTotalMatches = Job::numActiveJobs();
        $results = [
            'jobMatches'   => $pageResults,
            'searchMeta'    => $numTotalMatches
        ];

        return $results;
    }

    private function prepareJobAttributes($pageResults)
    {
        foreach ($pageResults as $job){
            $url = action('JobController@customJob', [$job->id, str_slug($job->title)]);
            $job->url = $url;

            $logo_path = User::find($job->user_id)->logo_path;
            $job->logo_path = $logo_path ? env("UPLOADS_URL") . '/' . $logo_path : null;
            $job->time_since_published = Carbon::parse($job->published_at)->isSameDay(Carbon::today()) ? 'Publicerad idag' : (Carbon::parse($job->published_at)->isSameDay(Carbon::yesterday()) ? 'Publicerades igår' : (Carbon::parse($job->published_at)->startOfDay()->diffInDays(Carbon::now()) . ' dagar sedan'));
            $job->description = (strlen(strip_tags($job->description)) < 200) ? strip_tags($job->description) : substr(strip_tags($job->description), 0, 200)." ...";
        }

        return $pageResults;
    }
}