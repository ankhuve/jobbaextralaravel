<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Input;
use Illuminate\Http\Request;



class SearchController extends Controller
{

    public function index(Request $request, $keyword = false)
    {
        if (Input::has('q')) {
            $keyword = Input::get('q');
        }

        $results = $this->search($keyword, $request);

        return view('pages.search', ['jobs' => $results]);
    }

    public function search($keyword = null, $request)
    {

        $client = new Client(['base_uri' => 'http://api.arbetsformedlingen.se/af/v0/']);

        $searchParams = [
            'antalrader' => 10,
            'sida' => 1,
            'anstallningstyp' => 2,
            'nyckelord' => $keyword,
        ];

            $searchParams['nyckelord'] = Input::get('q') ? : null;
            $searchParams['lanid'] = Input::get('lan') ? : null;
            $searchParams['yrkesomradeid'] = Input::get('yrkesomraden') ? : null;
//        if (Input::get('sida') != 'null') {
//            $searchParams['sida'] = Input::get('sida') ? : "";
//        }

        $searchResults = $client->get('platsannonser/matchning', [
            'query' => $searchParams,
            'headers' => [
                'Accept' => 'application/json',
                'Accept-Language' => 'sv-se,sv'
            ]
        ]);
        $jobMatches = json_decode($searchResults->getBody()->getContents());
        $request->flash();
        return $jobMatches;
    }
}