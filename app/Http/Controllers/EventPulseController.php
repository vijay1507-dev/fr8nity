<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EventPulseController extends Controller
{
    /**
     * Display the Event Pulse detailed view
     *
     * @return \Illuminate\View\View
     */
    public function show()
    {
        // You can add logic here to fetch event data from database if needed
        // For now, we'll just return the view
        
        return view('website.spotlight.event-pulse-detail');
    }

    /**
     * Display the Event Pulse listing page
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // You can add logic here to fetch events list from database if needed
        // For now, we'll just return the existing view
        
        return view('website.spotlight.event-pulse');
    }
}
