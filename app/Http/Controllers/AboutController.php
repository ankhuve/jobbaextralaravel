<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Page;
use Illuminate\Http\Request;

class AboutController extends Controller {

	public function index()
    {
        $page = Page::find(4);
        $pageContent = $page->content;
        return view("pages.about", ['page' => $page, 'content' => $pageContent]);
    }

}