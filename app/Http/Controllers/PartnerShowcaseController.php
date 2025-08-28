<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PartnerShowcaseController extends Controller
{
    /**
     * Display the Partner Showcase listing page
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // You can add logic here to fetch partner data from database if needed
        // For now, we'll just return the existing view
        
        return view('website.spotlight.partner-showcase');
    }

    /**
     * Display the Partner Showcase detailed view
     *
     * @return \Illuminate\View\View
     */
    public function show()
    {
        // You can add logic here to fetch partner data from database if needed
        // For now, we'll just return the view
        
        return view('website.spotlight.partner-showcase-detail');
    }
}
