<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Job;
use Carbon\Carbon;
use DB;
use GuzzleHttp\Client;
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
        if(!Input::get('page') || Input::get('page') < 1){
            $askedPage = 1;
        } else{
            $askedPage = Input::get('page');
        }

        // hämta våra jobb
        if (!is_null($keyword)) {
            $customResults = $this->searchCustomJobs($keyword, $request, $askedPage);
        } else {
            // om vi inte har ett sökord i requesten
            $customResults = $this->getNewestJobs(); // get the newest custom jobs
        }

        // calculate at which page AF-jobs will start to paginate
        $totalCustomJobs = $customResults['searchMeta'];
//        var_dump($totalCustomJobs);
        $offset = $totalCustomJobs % $this->numPerPage;

        if($offset == 0 && $totalCustomJobs > 0){
            $firstPageWithAFJobs = ceil($totalCustomJobs / $this->numPerPage) + 1;
        } else{
            $firstPageWithAFJobs = ceil($totalCustomJobs / $this->numPerPage);
        }

//
//
//        var_dump("offset: " . $offset);
////        if($offset){
//            var_dump("första sida med resultat: " . $firstPageWithAFJobs);
//            var_dump("antal af-jobb att hämta på den sidan: " . (10 - $offset));
////        }



        $offsetPage = (int)($askedPage - $firstPageWithAFJobs);
        $numToGetFromAF = (10-$offset);
//        dd($numToGetFromAF);

        // calculate which pages to get from AF API
        if($offsetPage == 0){ // om vi är på första sidan där det ska fyllas ut med AF-jobb
            $pageToGetFromAF = 1;
//            var_dump("hämta " . $numToGetFromAF . " jobb från sida " . $pageToGetFromAF . " api");
//            var_dump('hämta sida 1 från api');

            $results = $this->search($keyword, $numToGetFromAF, $pageToGetFromAF); // get jobs from Arbetsförmedlingen
            $afJobs = $results['jobMatches'];
            $afSearchMeta = $results['searchMeta'];

        } elseif($offsetPage > 0){ // om vi behöver slå ihop två sidor för att bilda vår egen

            $pageToGetFromAF = $offsetPage;
            $secondPageToGetFromAF = $pageToGetFromAF + 1;
//            var_dump($pageToGetFromAF);
//            var_dump($secondPageToGetFromAF);
//            var_dump('hämta 2 sidor á ' . $this->numPerPage . ' från api med start på sida: ' . $pageToGetFromAF);

            // om vi har ett sökord, utför sökning med sökord
//            if(Input::get('q')){
//                $keyword = Input::get('q');
//                dd($keyword);
//                $resultsFirst = $this->search($keyword, $this->numPerPage, $pageToGetFromAF); // get jobs from Arbetsförmedlingen
//                $resultsSecond = $this->search($keyword, $this->numPerPage, $secondPageToGetFromAF); // get jobs from Arbetsförmedlingen
//            } else{
//                // om vi inte har ett sökord, hämta bara jobb
//                $resultsFirst = $this->search(null, $this->numPerPage, $pageToGetFromAF); // get jobs from Arbetsförmedlingen
//                $resultsSecond = $this->search(null, $this->numPerPage, $secondPageToGetFromAF); // get jobs from Arbetsförmedlingen
//            }
            $results = $this->search($keyword, $this->numPerPage, $pageToGetFromAF); // get jobs from Arbetsförmedlingen
            $resultsSecond = $this->search($keyword, $this->numPerPage, $secondPageToGetFromAF); // get jobs from Arbetsförmedlingen

            if($results && $resultsSecond){
                // ta bort jobben vi redan visat på förra sidan (ta bort från toppen)
                $results['jobMatches'] = $results['jobMatches']->slice($numToGetFromAF);

                // ta bort jobben vi inte vill visa (ta bort från botten)
                $resultsSecond['jobMatches']->splice($numToGetFromAF);

                // slå ihop de två sidorna till en Collection med $numPerPage jobb
                $results['jobMatches'] = $results['jobMatches']->merge($resultsSecond['jobMatches']);
                $results['searchMeta'] = $resultsSecond['searchMeta'];

                $afJobs = $results['jobMatches'];
                $afSearchMeta = $results['searchMeta'];
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


        if(isset($afSearchMeta)){
            $allMeta = collect($customResults['searchMeta'])->merge($afSearchMeta);
        } else{
            $allMeta = collect($customResults['searchMeta']);
        }

//        dd($allJobs);


        if ($request->ajax()) {
            return (json_encode($afSearchMeta));
        }

        $request->flash();
        return view('pages.search', ['jobs' => $allJobs, 'searchMeta' => $allMeta, 'currentPage' => $askedPage, 'request' => $request]);
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
            ->having('relevance', '>', 20);

        $numTotalMatches = count($allMatches->get());

        $pageResults = $allMatches
            ->skip($rowsToSkip)
            ->take($this->numPerPage)
            ->get();

        // Gör sökningen, returnera resultat för rätt sida
//        $jobMatches = Searchy::search('jobs')
//            ->fields('title', 'description')
//            ->query($searchQuery)
//            ->getQuery()
//            ->having('relevance', '>', 10)
//            ->skip($rowsToSkip)
//            ->take($this->numPerPage)
//            ->get();

        // Perform the query using Query Builder
//        $jobMatches = Job::where('title', 'like', $searchQuery)
//            ->orWhere('description', 'like', $searchQuery)
//            ->paginate($this->numPerPage)
//            ->sortByDesc('published_at')
//            ->all();

//        dd($jobMatches);

        $request->flash(); // sätt tillbaka sökparametrarna på sidan för användaren
        $results = [
            'jobMatches'   => $pageResults,
            'searchMeta'    => $numTotalMatches
        ];
        return $results;
    }

    public function getNewestJobs()
    {
        $pageResults = DB::table('jobs')
            ->where('latest_application_date', '>', Carbon::now())
            ->paginate($this->numPerPage)
            ->sortByDesc('published_at')
            ->all();

        $numTotalMatches = Job::numActiveJobs();
        $results = [
            'jobMatches'   => $pageResults,
            'searchMeta'    => $numTotalMatches
        ];

        return $results;
    }
}