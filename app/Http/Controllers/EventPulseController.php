<?php

namespace App\Http\Controllers;

use App\Models\Spotlight;
use Illuminate\Http\Request;

class EventPulseController extends Controller
{
    /**
     * Display the Event Pulse detailed view
     *
     * @return \Illuminate\View\View
     */
    public function show($id = null)
    {
        if ($id) {
            $eventPulse = Spotlight::active()->eventPulse()->findOrFail($id);
        } else {
            // Get the first active event pulse item
            $eventPulse = Spotlight::active()->eventPulse()->ordered()->first();
            
            if (!$eventPulse) {
                abort(404, 'No event pulse items found');
            }
        }
        
        return view('website.spotlight.event-pulse-detail', compact('eventPulse'));
    }

    /**
     * Display the Event Pulse listing page
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $page = $request->get('page', 1);
            $perPage = 6; // 6 items per page
            
            $eventPulseItems = Spotlight::active()
                ->eventPulse()
                ->ordered()
                ->paginate($perPage, ['*'], 'page', $page);
            
            return response()->json([
                'html' => view('website.spotlight.partials.event-pulse-items', compact('eventPulseItems'))->render(),
                'hasMore' => $eventPulseItems->hasMorePages(),
                'nextPage' => $eventPulseItems->currentPage() + 1
            ]);
        }
        
        $eventPulseItems = Spotlight::active()->eventPulse()->ordered()->paginate(6);
        
        return view('website.spotlight.event-pulse', compact('eventPulseItems'));
    }
}
