<?php namespace App\Http\Controllers;

use App\Job;
use Carbon\Carbon;

class HomeController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders your application's "dashboard" for users that
	| are authenticated. Of course, you are free to change or remove the
	| controller as you wish. It is just here to get your app started!
	|
	*/

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
        $newJobs = $this->getNewestJobs();
//        dd($newJobs->all());
		return view('home', ['newJobs' => $newJobs->all()]);
	}

    public function getNewestJobs()
    {
        $data = Job::all()->sortByDesc('created_at')->take(2);
//        dd($data);
        return $data;
    }

}
