<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Job;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class JobController extends Controller
{
    public function index($jobid)
    {
        $jobMatch = $this->getJob($jobid);
        $now = time();
        $date = strtotime($jobMatch->annons->publiceraddatum);
        $datediff = (int)(floor(($now - $date)/(60*60*24)));
        return view('pages.job', ['jobMatch' => $jobMatch, 'daysSincePublished' => $datediff]);
    }

    public function customJob($jobid, $slug)
    {
        $jobMatch = Job::find($jobid);
        $now = time();
        $date = strtotime($jobMatch->published_at);
        $datediff = (int)(floor(($now - $date)/(60*60*24)));
        return view('pages.customjob', ['jobMatch' => $jobMatch, 'daysSincePublished' => $datediff]);

    }

    public function getJob($jobid, Request $request = null){

        $client = new Client(['base_uri' => 'http://api.arbetsformedlingen.se/af/v0/']);

        $jobMatch = $client->get('platsannonser/'.$jobid, [
            'headers' => [
                'Accept' => 'application/json',
                'Accept-Language' => 'sv-se,sv'
            ]
        ]);

        // TODO: Catch error when request does not work

        $jobMatch = json_decode($jobMatch->getBody()->getContents());
        if(!is_null($request)){
            return($jobMatch->platsannons->annons->annonstext);
        }
        return $jobMatch->platsannons;
    }
}