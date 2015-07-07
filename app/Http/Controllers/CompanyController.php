<?php

namespace App\Http\Controllers;

use App\Http\Requests\ValidateNewJob;
use App\Job;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{

    protected $auth;

    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
        $this->middleware('usertype');
    }

    public function index()
    {
        $user = $this->auth->user();
        return view('company.home', compact('user'));
    }

    /**
     * Create a new job ad.
     *
     * @param  array  $data
     * @return Job
     */
    public function create(array $data = null)
    {
        if($data){
            return Job::create([
                'title' => $data['jobtitle'],
                'work_place' => $data['work_place'],
                'type' => $data['type'],
                'county' => $data['county'],
                'municipality' => $data['municipality'],
                'description' => nl2br($data['description']),
                'latest_application_date' => $data['latest_application_date'],
                'contact_email' => $data['contact_email'],
                'published_at' => Carbon::now()
            ]);
        }
        return $this->show();

    }

    /**
     * @return \Illuminate\View\View
     */
    public function show()
    {
        $user = $this->auth->user();
        return view('company.create', compact('user'));
    }

    /**
     * @param ValidateNewJob $request
     * @return \Illuminate\View\View
     */
    public function confirm(ValidateNewJob $request)
    {
        $data = $request->all();
        session()->flash('newjob', $data);
        return view('company.confirm', compact('data'));
    }

    /**
     * Persists a new job.
     *
     * @param ValidateNewJob $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(ValidateNewJob $request)
    {
        $newJob = $this->createJob($request);

        \Auth::user()->jobs()->save($newJob);

        return redirect('company');
    }


    /**
     * Creates a new job.
     *
     * @param ValidateNewJob $request
     * @return static
     */
    public function createJob(ValidateNewJob $request)
    {
        $data = $request->all();

        $newJob = Job::open($data);

        return $newJob;
    }
}