<?php

namespace App\Http\Controllers;

use App\FeaturedCompany;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class FeaturedController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $companies = FeaturedCompany::paginate(1);
        return view('pages.featured', compact('companies', 'companies'));
    }
}
