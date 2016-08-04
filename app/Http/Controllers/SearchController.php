<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Job;
use DB;
use GuzzleHttp\Client;
use Input;
use Illuminate\Http\Request;



class SearchController extends Controller
{

    public function index(Request $request, $keyword = false)
    {
        if (Input::has('q')) {
            $keyword = Input::get('q');
            $customJobs = $this->searchCustomJobs($keyword, $request);
        } else{
            // om vi inte har ett sökord i requesten
            $customJobs = $this->getNewestJobs($request); // get the newest custom jobs
            $numCustomJobs = count($customJobs);
            $numToGetFromAF = 10 - $numCustomJobs;
        }



        if($numToGetFromAF != 0){
            $results = $this->search($keyword, $numToGetFromAF, $request); // get jobs from Arbetsförmedlingen
            $afJobs = $results['jobMatches'];
            $afSearchMeta = $results['searchMeta'];
            $allJobs = collect($customJobs)->merge($afJobs);
//            $allJobs = array_merge($customJobs->toArray(), $afJobs->toArray());

        } else{
            $allJobs = $customJobs;
        }

//        dd($allJobs);


//        if numtoget == 0:
//            return customJobs
//        else:
//            get numtoget afJobs
//            merge afJobs, customJobs
//
//            calculate how many hits in total
//            calc numPages
//
//            return merged, totalHits



        if($request->ajax()){
            return(json_encode($afSearchMeta));
        }

        $request->flash();
        return view('pages.search', ['jobs' => $allJobs, 'searchMeta' => isset($afSearchMeta) ? $afSearchMeta : $customJobs]);
    }


    /**
     *
     * Get jobs from the Arbetsförmedlingen API.
     *
     * @param null $keyword
     * @param Request $request
     * @param int $numRows
     * @return mixed
     */
    public function search($keyword = null, $numRows = 0, Request $request)
    {
        $client = new Client(['base_uri' => 'http://api.arbetsformedlingen.se/af/v0/']);

        $searchParams = [
            'antalrader' => $numRows,
            'anstallningstyp' => 1,
            'nyckelord' => $keyword,
        ];

            $searchParams['nyckelord'] = Input::get('q') ? : null;
            $searchParams['lanid'] = Input::get('lan') ? : null;
            $searchParams['yrkesomradeid'] = Input::get('yrkesomraden') ? : null;
//        if (Input::get('sida') != 'null') {
            $searchParams['sida'] = Input::get('sida') ? : 1;
//        }

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


        $jobMatches = collect($response->get('matchningslista')->matchningdata); // the queried jobs

        return compact(['jobMatches', $jobMatches, 'searchMeta', $searchMeta]);
    }

    public function searchCustomJobs($keyword = null, Request $request)
    {
        // Sets the parameters from the get request to the variables.
        $searchQuery = Input::get('q') ? : '';
        $searchParams['lanid'] = Input::get('lan') ? : '';

        // Perform the query using Query Builder
        $jobMatches = DB::table('jobs')
            ->where('title', 'like', $searchQuery)
            ->orWhere('description', 'like', $searchQuery)
            ->get();

        $request->flash();
        return $jobMatches;
    }

    public function getNewestJobs(Request $request)
    {
//        dd($request->all());
        $jobs = Job::paginate(8)->sortByDesc('published_at');
        return $jobs;
    }
}