<?php namespace App\Http\Controllers;

use App\Job;
use App\Page;
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
		$numJobs = $this->getTotalNumberOfJobs();
        $newJobs = $this->getNewestJobs();

		$page = Page::find(3);
		$pageContent = $page->content;
//        dd($newJobs->all());
		return view('home', ['newJobs' => $newJobs->all(), 'numJobs' => $numJobs, 'page' => $page, 'content' => $pageContent]);
	}

    public function getNewestJobs()
    {
        $data = Job::all()->sortByDesc('published_at')->take(2);
//        dd($data);
        return $data;
    }

	public function getTotalNumberOfJobs()
	{
		$numOfAFJobs = SearchController::getNumberOfAfJobs();
		$numCustomJobs = Job::where('latest_application_date', '>', Carbon::now())->count();
		return $numOfAFJobs + $numCustomJobs;
	}

}
