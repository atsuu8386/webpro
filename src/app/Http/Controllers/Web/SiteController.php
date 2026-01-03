<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class SiteController extends Controller
{
    /**
     * Display the homepage.
     */
    public function index(): View
    {
        return view('web.index');
    }
}
