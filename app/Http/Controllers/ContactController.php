<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactFormRequest;
use App\Page;
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
    }
}
