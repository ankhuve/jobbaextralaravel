<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class AboutController extends Controller {

	public function index()
    {
        $data = [];
        $data['first'] = "Jobba";
        $data['last'] = "Extra";
        return view("pages.about", $data);
    }

}