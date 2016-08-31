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
        $companies = FeaturedCompany::where('end_date', '>', \Carbon\Carbon::now())->get();
        return view('pages.featured', compact('companies', 'companies'));
    }

    /**
     * Display a featured company's presentation.
     *
     * @return Response
     */
    public function featured($id)
    {
        $featured = FeaturedCompany::find($id);
        return view('pages.featured.singlefeatured', compact('featured'));
    }
}
