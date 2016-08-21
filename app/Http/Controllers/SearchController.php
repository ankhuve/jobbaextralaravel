<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Job;
use Carbon\Carbon;
use DB;
use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Input;
use Illuminate\Http\Request;
use TomLingham\Searchy\Facades\Searchy;


class SearchController extends Controller
{

    protected $numPerPage = 10;

    public function index(Request $request)
    {
        // om vi inte har några parametrar för sökning
//        if(empty($request->all())){
//
//        }

        if(Input::get('q')){
            $keyword = Input::get('q');
        } else{
            $keyword = null;
        }

        // om inte Input::get('page') finns, defaulta till 1
        if(is_null(Input::get('page')) || Input::get('page') <= 1){
            $askedPage = 1;
        } else{
            $askedPage = (int)Input::get('page');
        }

        // hämta våra jobb
        if (!is_null($keyword)) {
            // om vi har ett sökord
            $customResults = $this->searchCustomJobs($keyword, $request, $askedPage);
        } else {
            // om vi inte har ett sökord i requesten
            $customResults = $this->getNewestCustomJobs(); // get the newest custom jobs
        }


        // calculate at which page AF-jobs will start to paginate
        $totalCustomJobs = $customResults['searchMeta'];
//        var_dump($totalCustomJobs);
        $offset = $totalCustomJobs % $this->numPerPage;
        $numToGetFromAF = (10-$offset);

        if($offset == 0 && $totalCustomJobs > 0){
            $firstPageWithAFJobs = (int)ceil($totalCustomJobs / $this->numPerPage) + 1;
        } else{
            $firstPageWithAFJobs = (int)ceil($totalCustomJobs / $this->numPerPage);
        }

        $firstPageToGetFromAF = ($askedPage - $firstPageWithAFJobs) + 1;
        if($offset != 0 && ($firstPageWithAFJobs + 1) === $askedPage){
            $firstPageToGetFromAF = $askedPage - 1;
        } elseif($offset != 0 && $askedPage > $firstPageWithAFJobs){
            $firstPageToGetFromAF--;
        }
//        if($firstPageToGetFromAF === 0){
//            $firstPageToGetFromAF = 1; // annars visas inga AF-jobb på första sidan om det finns custom-träffar
//        } elseif($firstPageWithAFJobs === 1 && $askedPage === 2){
//            $firstPageToGetFromAF = 2;
//        }


//        dd('page: ' . $askedPage, 'firstPageToGetFromAF: ' . $firstPageToGetFromAF, 'firstPageWithAfJobs: ' . $firstPageWithAFJobs, 'offset: ' . $offset);
        $askedPage >= $firstPageWithAFJobs ? $shouldGetAFJobs = true : $shouldGetAFJobs = false;

        // calculate which pages to get from AF API and then get the jobs
        if($offset === 0 && $askedPage >= $firstPageWithAFJobs){
            // om vi inte har offset och ska är på en sida där af-jobb ska hämtas
            $results = $this->search($keyword, $numToGetFromAF, $firstPageToGetFromAF); // get jobs from Arbetsförmedlingen
            $afJobs = $results['jobMatches'];
            $afSearchMeta = $results['searchMeta'];

        } elseif($offset != 0 && $askedPage === $firstPageWithAFJobs){
            // om vi är på första sidan med AF-jobb och behöver slicea bort eftersom vi har custom jobs

//            dd('page: ' . $askedPage, 'firstPageToGetFromAF: ' . $firstPageToGetFromAF, 'firstPageWithAfJobs: ' . $firstPageWithAFJobs, 'offset: ' . $offset, 'numToGetFromAF: '. $numToGetFromAF);


            $results = $this->search($keyword, $this->numPerPage, $firstPageToGetFromAF); // get jobs from Arbetsförmedlingen

            if($results){
                // ta bort överflödiga jobb som kommer visas på nästa sida (ta bort från botten)
                $results['jobMatches']->splice($numToGetFromAF);

                $afJobs = $results['jobMatches'];
                $afSearchMeta = $results['searchMeta'];
//                dd($afJobs);
            } else{
                // om det är slut på resultat
                $request->flash();
                return view('pages.search', ['jobs' => [], 'searchMeta' => [], 'currentPage' => $askedPage]);
            }

        } elseif($offset != 0 && $askedPage > $firstPageWithAFJobs){
            // om vi behöver slå ihop två sidor för att bilda vår egen

//            dd('page: ' . $askedPage, 'firstPageToGetFromAF: ' . $firstPageToGetFromAF, 'firstPageWithAfJobs: ' . $firstPageWithAFJobs, 'offset: ' . $offset, 'numToGetFromAF: '. $numToGetFromAF);


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
            } elseif($results && is_null($resultsSecond)){

                $afJobs = $results['jobMatches'];
                $afSearchMeta = $results['searchMeta'];
            } else {
                // om vi är på sista sidan
                $results = $this->search($keyword, $this->numPerPage, $firstPageToGetFromAF); // get jobs from Arbetsförmedlingen
                $results['jobMatches'] = $results['jobMatches']->slice($numToGetFromAF);
                $afJobs = $results['jobMatches'];
                $afSearchMeta = $results['searchMeta'];
            }
        } else{
            // om vi är på sista sidan med AF-jobb

            dd('page: ' . $askedPage, 'firstPageToGetFromAF: ' . $firstPageToGetFromAF, 'firstPageWithAfJobs: ' . $firstPageWithAFJobs, 'offset: ' . $offset, 'numToGetFromAF: '. $numToGetFromAF);


            $results = $this->search($keyword, $this->numPerPage, $firstPageToGetFromAF); // get jobs from Arbetsförmedlingen

            if($results){
                // ta bort överflödiga jobb som kommer visas på nästa sida (ta bort från botten)
                $results['jobMatches']->splice($numToGetFromAF);

                $afJobs = $results['jobMatches'];
                $afSearchMeta = $results['searchMeta'];
//                dd($afJobs);
            } else{
                // om det är slut på resultat
                $request->flash();
                return view('pages.search', ['jobs' => [], 'searchMeta' => [], 'currentPage' => $askedPage]);
            }

        }


        if(isset($afJobs)){
            // merga de två källorna med träffar till en Collection
            $allJobs = collect($customResults['jobMatches'])->merge($afJobs);
        } else{
            $allJobs = collect($customResults['jobMatches']);
        }


        $searchMeta = [];
        $searchMeta['customJobs'] = $customResults['searchMeta'];
        $searchMeta['all'] = $searchMeta['customJobs'];
        if(isset($afSearchMeta)){
            $searchMeta['afJobs'] = $afSearchMeta['antal_platsannonser'];
            $searchMeta['all'] += isset($searchMeta['afJobs']) ? $searchMeta['afJobs'] : 0;
        } else{
            $numberOfAfJobs = $this->getNumberOfAfJobs($keyword);
            $searchMeta['afJobs'] = $numberOfAfJobs;
            $searchMeta['all'] += $numberOfAfJobs;
        }
        $searchMeta['numPages'] = ceil($searchMeta['all'] / $this->numPerPage);

//        dd($searchMeta);
//        dd($allJobs);

        // Make a paginator to paginate the search results
        $currPage = Input::get('page') ?: null;
        $paginator = new LengthAwarePaginator($allJobs, $searchMeta['all'], $this->numPerPage, $currPage,
            [
                'path' => 'search',
                'query' => $request->query()
            ]);

//        dd($allJobs, $paginator, $searchMeta);

        if ($request->ajax()) {
            return (json_encode($afSearchMeta));
        }

        $request->flash();
        return view('pages.search', ['jobs' => $allJobs, 'searchMeta' => $searchMeta, 'currentPage' => $askedPage, 'request' => $request, 'paginator' => $paginator]);
    }

    public function getNumberOfAfJobs($keyword)
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
            $searchParams['lanid'] = Input::get('lan');
        }

        if(Input::get('yrkesomraden')){
            $searchParams['yrkesomraden'] = Input::get('yrkesomraden');
        }

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
//            'nyckelord' => $keyword,
//            'lanid' => Input::get('lan') ?: null,
            'yrkesomradeid' => Input::get('yrkesomraden') ?: null,
            'sida' => $pageToGet
        ];

        if(isset($keyword)){
            $searchParams['nyckelord'] = $keyword;
        }

        if(Input::get('lan')){
            $searchParams['lanid'] = Input::get('lan');
        }

//        $searchParams['nyckelord'] = Input::get('q') ?: null;
//        $searchParams['lanid'] = Input::get('lan') ?: null;
//        $searchParams['yrkesomradeid'] = Input::get('yrkesomraden') ?: null;
////        if (Input::get('sida') != 'null') {
//        $searchParams['sida'] = $pageToGet;
//        }
//        var_dump($searchParams);

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
//        $jobMatches = collect($response->get('matchningslista')->matchningdata); // the queried jobs

        return compact(['jobMatches', 'searchMeta']);
    }

    public function searchCustomJobs($keyword = null, Request $request, $askedPage = 1)
    {
        $askedPage = $askedPage - 1;
        $rowsToSkip = (int)($askedPage * $this->numPerPage);

        // Sets the parameters from the get request to the variables.
        $searchQuery = $keyword;

        // Hämta antal träffar för sökmeta
        $allMatches = Searchy::search('jobs')
            ->fields('title', 'description')
            ->query($searchQuery)
            ->getQuery()
            ->having('relevance', '>', 20)
            ->orderBy('published_at', 'desc');

        $numTotalMatches = count($allMatches->get());

        // Hämta träffarna för sidan
        $pageResults = $allMatches
            ->skip($rowsToSkip)
            ->take($this->numPerPage)
            ->get();

//        $request->flash(); // sätt tillbaka sökparametrarna på sidan för användaren
        $results = [
            'jobMatches'   => $pageResults,
            'searchMeta'    => $numTotalMatches
        ];
        return $results;
    }

    public function getNewestCustomJobs()
    {
        $pageResults = DB::table('jobs')
            ->where('latest_application_date', '>', Carbon::now())
            ->orderBy('published_at', 'desc')
            ->paginate($this->numPerPage)
            ->all();

        $numTotalMatches = Job::numActiveJobs();
        $results = [
            'jobMatches'   => $pageResults,
            'searchMeta'    => $numTotalMatches
        ];

        return $results;
    }
}