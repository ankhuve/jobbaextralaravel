<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\JobApplicationRequest;
use App\Job;
use App\User;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Mail;
use Storage;

class JobController extends Controller
{

    protected $user;

    public function __construct(){
        $this->user = \Auth::user();
    }


    /**
     *
     * Display a single job from AF with all of its details.
     *
     * @param $jobid
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index($jobid)
    {
        $jobMatch = $this->getJob($jobid);
        $now = time();
        $date = strtotime($jobMatch->annons->publiceraddatum);
        $datediff = (int)(floor(($now - $date)/(60*60*24)));
        return view('pages.job', ['jobMatch' => $jobMatch, 'daysSincePublished' => $datediff]);
    }


    /**
     *
     * Display a single custom job with all of its details.
     *
     * @param $jobid
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function customJob($jobid, $slug)
    {
        $jobMatch = Job::find($jobid);
        $now = time();
        $date = strtotime($jobMatch->published_at);
        $datediff = (int)(floor(($now - $date)/(60*60*24)));
        return view('pages.customjob', ['jobMatch' => $jobMatch, 'daysSincePublished' => $datediff]);

    }


    /**
     *
     * Get the detailed information for a specified AF job ID.
     *
     * @param $jobid
     * @param Request|null $request
     * @return mixed
     */
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


    /**
     *
     * Handle a job contact application using the contact form
     * on the job ad.
     *
     * @param JobApplicationRequest|Request $request
     * @param $id
     * @return array
     */
    public function apply(JobApplicationRequest $request, $id, $slug = null)
    {
        $jobUrl = URL::previous();

        // kolla om det är en AF-annons eller en egen
        if($slug && $job = Job::find($id)){
            // eget jobb
        } else{
            $job = null;
            // AF-jobb
        }

        // ladda upp CV om vi har något
        if ($request->hasFile('cv')) {
            $fileData = $this->handleCVUpload($request);
        } else{
            $fileData = null;
        }

        // skicka mail
        $mailSent = $this->sendApplicationMail($request, $fileData ?: null, $job ?: null);



        if($mailSent){
            return \Redirect::to($jobUrl)
                ->with('message', 'Tack för din ansökan!');
        } else{
            return \Redirect::to($jobUrl)
                ->with('contactError', 'Hoppsan! Något gick snett när din ansökan skulle skickas. <br><br>Försök igen!')
                ->withInput();
        }
    }


    public function sendApplicationMail(JobApplicationRequest $request, $attachmentData = null, Job $job = null)
    {
        Mail::send('emails.application',
            array(
                'jobTitle' => $request->get('jobTitle'),
                'jobUrl' => $request->header('referer'),
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'user_message' => $request->get('message')
            ), function($message) use ($attachmentData, $request, $job)
            {
                $message->from('postmaster@jobbrek.se', 'Jobbrek.se');

                // lägg till annonsens kontaktemail som mottagare
                $message->to($job ? $job->contact_email : 'info@jobbrek.se', 'Jobbrek.se')->subject('Jobbansökan: ' . $request->get('jobTitle') . ', via Jobbrek.se');
                $message->bcc('info@jobbrek.se', 'Jobbrek.se');
                if(!is_null($attachmentData)){
                    $message->attach($attachmentData['path'],
                        [
                            'as' => $attachmentData['originalName'],
                            'mime' => $attachmentData['mimetype']
                        ]);
                }
            });

        return true;
    }

    /**
     *
     * Handle a CV upload request.
     *
     * @param Request $request
     * @return bool
     */
    public function handleCVUpload(Request $request)
    {
        if ($request->file('cv')->isValid()) {

            $pathToCVFolder = 'user-cvs/';

            // store CV on server
            $file = $request->file('cv');
            $userName = str_slug($request->get('name'));

            // prepare for upload
            $disk = Storage::disk('s3');
            $ext = $file->guessExtension();
            $fileName = $userName . '-' . time() . '-CV.' . $ext;

            // spara användarens CV-namn i databasen
            if($this->user){

                if($this->user->hasCV())
                {
                    // delete old CV if user has one uploaded already
                    $old = $this->user->cv_path;
                    if($disk->exists($pathToCVFolder . $old)){
                        $disk->delete($pathToCVFolder . $old);
                    };
                }

            } else{
                // processa CV på något annat sätt om ingen användare är inloggad?
            }

            // Ladda upp filen
            $disk->put($pathToCVFolder . $fileName, file_get_contents($file->getRealPath()));

            // Spara nya filnamnet för användaren
            if($this->user){
                $this->user->cv_path = $fileName;
                $this->user->save();
            }

            // allt gick bra!
            $fileData = [
                'path' => $file->getPath() . '/' . $file->getFilename(),
                'originalName' => $file->getClientOriginalName(),
                'mimetype' => $file->getMimeType()
            ];
            return $fileData;

        } else{
            // failed to validate upload, broken file?
            return false;
        }
    }
}