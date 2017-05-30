<?php namespace App\Http\Controllers;

use App\Job;
use App\Page;
use App\ProfiledJob;
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
        $profiledJobs = $this->getProfiledJobs();

        if($page = Page::find(3)){
            $pageContent = $page->content;

            return view('home', [
                    'numJobs' => $numJobs,
                    'page' => $page,
                    'content' => $pageContent,
                    'profiledJobs' => $profiledJobs]
            );
        }
        else{
            return view('home', [
                    'numJobs' => $numJobs,
                    'page' => null,
                    'content' => null,
                    'profiledJobs' => $profiledJobs]
            );
        }
    }

    public function getNewestJobs()
    {
        $data = Job::all()->sortByDesc('published_at')->take(2);
        return $data;
    }

    public function getProfiledJobs()
    {
        $data = ProfiledJob::where('end_date', '>', Carbon::now())->get()->sortByDesc('start_date');
        return $data;
    }

    public function getTotalNumberOfJobs()
    {
        $numOfAFJobs = SearchController::getNumberOfAfJobs();
        $numCustomJobs = Job::where('latest_application_date', '>', Carbon::now())->count();
        return $numOfAFJobs + $numCustomJobs;
    }
}
