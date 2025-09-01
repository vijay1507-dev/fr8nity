<?php

namespace App\Http\Controllers;

use App\Models\Spotlight;
use Illuminate\Http\Request;

class PartnerShowcaseController extends Controller
{
    /**
     * Display the Partner Showcase listing page
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $page = $request->get('page', 1);
            $perPage = 8; 
            
            $partnerShowcaseItems = Spotlight::active()
                ->partnerShowcase()
                ->ordered()
                ->paginate($perPage, ['*'], 'page', $page);
            
            return response()->json([
                'html' => view('website.spotlight.partials.partner-showcase-items', compact('partnerShowcaseItems'))->render(),
                'hasMore' => $partnerShowcaseItems->hasMorePages(),
                'nextPage' => $partnerShowcaseItems->currentPage() + 1
            ]);
        }
        
        $partnerShowcaseItems = Spotlight::active()->partnerShowcase()->ordered()->paginate(8);
        
        return view('website.spotlight.partner-showcase', compact('partnerShowcaseItems'));
    }

    /**
     * Display the Partner Showcase detailed view
     *
     * @return \Illuminate\View\View
     */
    public function show($id = null)
    {
        if ($id) {
            $partnerShowcase = Spotlight::active()->partnerShowcase()->findOrFail($id);
        } else {
            // Get the first active partner showcase item
            $partnerShowcase = Spotlight::active()->partnerShowcase()->ordered()->first();
            
            if (!$partnerShowcase) {
                abort(404, 'No partner showcase items found');
            }
        }
        
        return view('website.spotlight.partner-showcase-detail', compact('partnerShowcase'));
    }
}
