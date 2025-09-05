<?php

namespace App\Http\Controllers;

use App\Models\Spotlight;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class PartnerShowcaseAdminController extends Controller
{
    /**
     * Display a listing of the partner showcase items.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $partnerShowcaseItems = Spotlight::with('creator')->partnerShowcase()->ordered();
            
            return DataTables::of($partnerShowcaseItems)
                ->addIndexColumn()
                ->addColumn('status_badge', function ($row) {
                    $badgeClass = $row->status ? 'success' : 'danger';
                    $statusText = $row->status ? 'Active' : 'Inactive';
                    return '<span class="badge bg-' . $badgeClass . '">' . $statusText . '</span>';
                })
                ->addColumn('created_at', function($row) {
                    return $row->created_at->format('d M Y H:i');
                })
                ->addColumn('feature_image_thumb', function ($row) {
                    if ($row->feature_image) {
                        return '<img src="' . asset('storage/' . $row->feature_image) . '" alt="Feature Image" style="width: 50px; height: 30px; object-fit: cover;">';
                    }
                    return '<span class="text-muted">No image</span>';
                })
                ->addColumn('action', function ($row) {
                    $buttons = '<div class="d-inline-flex align-items-center gap-2 flex-nowrap">';
                    $buttons .= '<a href="' . route('admin.partner-showcase.edit', $row->id) . '" class="btn btn-sm btn-outline-success">Edit</a>';
                    $buttons .= '<form action="' . route('admin.partner-showcase.destroy', $row->id) . '" method="POST" class="d-inline m-0 p-0">'
                                  . csrf_field()
                                  . method_field('DELETE') .
                                  '<button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm(\'Are you sure you want to delete this partner showcase item?\');">Delete</button>' .
                                  '</form>';
                    $buttons .= '</div>';
                    return $buttons;
                })
                ->rawColumns(['status_badge', 'feature_image_thumb', 'action'])
                ->make(true);
        }

        return view('dashboard.partner-showcase.index');
    }

    /**
     * Show the form for creating a new partner showcase item.
     */
    public function create()
    {
        return view('dashboard.partner-showcase.create');
    }

    /**
     * Store a newly created partner showcase item in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'feature_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:10240',
            'gallery.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
            'status' => 'boolean',
            'order' => 'integer|min:0'
        ]);

        $data = $request->all();
        $data['type'] = Spotlight::TYPE_PARTNER_SHOWCASE;
        $data['created_by'] = Auth::id();
        $data['status'] = $request->has('status') ? 1 : 0;
        $data['order'] = $request->order ?? 0;

        // Handle feature image upload
        if ($request->hasFile('feature_image')) {
            $data['feature_image'] = $request->file('feature_image')->store('spotlight/features', 'public');
        }

        // Handle gallery images upload
        $galleryImages = [];
        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $galleryImage) {
                $path = $galleryImage->store('spotlight/gallery', 'public');
                $galleryImages[] = $path;
            }
        }
        $data['gallery'] = $galleryImages;

        Spotlight::create($data);

        return redirect()->route('admin.partner-showcase.index')
                        ->with('success', 'Partner Showcase item created successfully.');
    }

    /**
     * Show the form for editing the specified partner showcase item.
     */
    public function edit(Spotlight $partnerShowcase)
    {
        // Ensure it's a partner showcase type
        if ($partnerShowcase->type !== Spotlight::TYPE_PARTNER_SHOWCASE) {
            abort(404);
        }
        
        return view('dashboard.partner-showcase.edit', compact('partnerShowcase'));
    }

    /**
     * Update the specified partner showcase item in storage.
     */
    public function update(Request $request, Spotlight $partnerShowcase)
    {
        // Ensure it's a partner showcase type
        if ($partnerShowcase->type !== Spotlight::TYPE_PARTNER_SHOWCASE) {
            abort(404);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'feature_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
            'gallery.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
            'status' => 'boolean',
            'order' => 'integer|min:0'
        ]);

        $data = $request->all();
        $data['status'] = $request->has('status') ? 1 : 0;
        $data['order'] = $request->order ?? 0;

        // Handle feature image upload
        if ($request->hasFile('feature_image')) {
            // Delete old image
            if ($partnerShowcase->feature_image) {
                Storage::disk('public')->delete($partnerShowcase->feature_image);
            }
            $data['feature_image'] = $request->file('feature_image')->store('spotlight/features', 'public');
        }

        // Handle gallery images upload
        if ($request->hasFile('gallery')) {
            // Delete old gallery images
            if ($partnerShowcase->gallery) {
                foreach ($partnerShowcase->gallery as $oldImage) {
                    Storage::disk('public')->delete($oldImage);
                }
            }
            
            $galleryImages = [];
            foreach ($request->file('gallery') as $galleryImage) {
                $path = $galleryImage->store('spotlight/gallery', 'public');
                $galleryImages[] = $path;
            }
            $data['gallery'] = $galleryImages;
        }

        $partnerShowcase->update($data);

        return redirect()->route('admin.partner-showcase.index')
                        ->with('success', 'Partner Showcase item updated successfully.');
    }

    /**
     * Remove the specified partner showcase item from storage.
     */
    public function destroy(Spotlight $partnerShowcase)
    {
        // Ensure it's a partner showcase type
        if ($partnerShowcase->type !== Spotlight::TYPE_PARTNER_SHOWCASE) {
            abort(404);
        }

        // Delete associated images
        if ($partnerShowcase->feature_image) {
            Storage::disk('public')->delete($partnerShowcase->feature_image);
        }

        if ($partnerShowcase->gallery) {
            foreach ($partnerShowcase->gallery as $image) {
                Storage::disk('public')->delete($image);
            }
        }

        $partnerShowcase->delete();
        return redirect()->route('admin.partner-showcase.index')
                        ->with('success', 'Partner Showcase item deleted successfully.');
    }


}