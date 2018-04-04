<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactFormRequest;
use App\Page;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Mail;

class ContactController extends Controller
{
    public function create()
    {
        if($page = Page::find(5)){
            $pageContent = $page->content;
            return view("pages.contact", ['page' => $page, 'content' => $pageContent]);
        }
        else{
            return view("pages.contact", ['page' => null, 'content' => null]);
        }
    }

    public function store(ContactFormRequest $request)
    {
        $isValid = $this->validateCaptcha([
            'secret' => env('CAPTCHA_SECRET'),
            'response' => $request->get('g-recaptcha-response'),
            'remoteip' => $request->ip()
        ]);

        if ($isValid) {
            Mail::send('emails.contact',
                array(
                    'name' => $request->get('name'),
                    'email' => $request->get('email'),
                    'user_message' => $request->get('message')
                ), function($message)
                {
                    $message->from(env('MAIL_USERNAME'));
                    $message->to('info@jobbrek.se', 'Jobbrek.se')->subject('Kontakt via Jobbrek.se');
                });

            return \Redirect::action('ContactController@create')
                ->with('message', 'Tack för att du kontaktade oss! Vi hör av oss så fort vi kan.');
        } else {
            return \Redirect::action('ContactController@create')->withErrors(['recaptcha' => 'reCAPTCHA felaktig.']);
        }
    }

    private function validateCaptcha($params)
    {
        $client = new Client();
        try{
            $searchResults = $client->get('https://www.google.com/recaptcha/api/siteverify', [
                'query' => $params,
                'headers' => [
                    'Accept' => 'application/json',
                    'Accept-Language' => 'sv-se,sv'
                ]
            ]);

            $response = json_decode($searchResults->getBody()->getContents());

            return $response->success;
        } catch(\Exception $e){
            return false;
        }
    }
}
