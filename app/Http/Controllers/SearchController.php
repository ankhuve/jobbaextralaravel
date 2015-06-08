<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Client;
use Psy\Util\Json;
use Illuminate\Http\Request as LaravelRequest;

class SearchController extends Controller {

    public function index()
    {
        return view('pages.search');
    }

    public function search($keyword, LaravelRequest $request){
        $client = new Client(['base_uri' => 'http://api.arbetsformedlingen.se/af/v0/']);

        $response = $client->get('platsannonser/matchning', [
            'query' => [
                'antalrader'      => 10,
                'sida'            => 1,
                'nyckelord'       => $keyword,
                'anstallningstyp' => 2
            ],
            'headers' => [
                'Accept'          => 'application/json',
                'Accept-Language' => 'sv-se,sv'
            ]
        ]);
        $content = json_decode($response->getBody()->getContents());

        dd($content->matchningslista);
//
//        if ($request->ajax()) {
//            return $content->matchningslista;
//        } else{
//            return $content->matchningslista;
//        }
    }


}