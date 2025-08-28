<?php

namespace App\Http\Controllers;

use App\Models\Spotlight;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class SpotlightController extends Controller
{
    /**
     * Display a listing of the spotlight items.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $spotlights = Spotlight::with('creator')->ordered();
            
            return DataTables::of($spotlights)
                ->addIndexColumn()
                ->addColumn('type_label', function ($row) {
                    $types = Spotlight::getTypes();
                    return $types[$row->type] ?? $row->type;
                })
                ->addColumn('status_badge', function ($row) {
                    $badgeClass = $row->status ? 'success' : 'danger';
                    $statusText = $row->status ? 'Active' : 'Inactive';
                    return '<span class="badge bg-' . $badgeClass . '">' . $statusText . '</span>';
                })
                ->addColumn('created_by_name', function ($row) {
                    return $row->creator ? $row->creator->name : 'N/A';
                })
                ->addColumn('feature_image_thumb', function ($row) {
                    if ($row->feature_image) {
                        return '<img src="' . asset('storage/' . $row->feature_image) . '" alt="Feature Image" style="width: 50px; height: 30px; object-fit: cover;">';
                    }
                    return '<span class="text-muted">No image</span>';
                })
                ->addColumn('action', function ($row) {
                    $editUrl = route('spotlight.edit', $row->id);
                    $deleteUrl = route('spotlight.destroy', $row->id);
                    
                    return '
                        <div class="btn-group" role="group">
                            <a href="' . $editUrl . '" class="btn btn-sm btn-primary">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button type="button" class="btn btn-sm btn-danger" onclick="deleteSpotlight(' . $row->id . ')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    ';
                })
                ->rawColumns(['status_badge', 'feature_image_thumb', 'action'])
                ->make(true);
        }

        return view('dashboard.spotlight.index');
    }

    /**
     * Show the form for creating a new spotlight item.
     */
    public function create()
    {
        $types = Spotlight::getTypes();
        return view('dashboard.spotlight.create', compact('types'));
    }

    /**
     * Store a newly created spotlight item in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|in:event_pulse,partner_showcase',
            'feature_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'gallery.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'boolean',
            'order' => 'integer|min:0'
        ]);

        $data = $request->all();
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
            foreach ($request->file('gallery') as $file) {
                $galleryImages[] = $file->store('spotlight/gallery', 'public');
            }
        }
        $data['gallery'] = $galleryImages;

        Spotlight::create($data);

        return redirect()->route('spotlight.index')->with('success', 'Spotlight item created successfully.');
    }

    /**
     * Display the specified spotlight item.
     */
    public function show(Spotlight $spotlight)
    {
        return view('dashboard.spotlight.show', compact('spotlight'));
    }

    /**
     * Show the form for editing the specified spotlight item.
     */
    public function edit(Spotlight $spotlight)
    {
        $types = Spotlight::getTypes();
        return view('dashboard.spotlight.edit', compact('spotlight', 'types'));
    }

    /**
     * Update the specified spotlight item in storage.
     */
    public function update(Request $request, Spotlight $spotlight)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|in:event_pulse,partner_showcase',
            'feature_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'gallery.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'boolean',
            'order' => 'integer|min:0'
        ]);

        $data = $request->except(['feature_image', 'gallery']);
        $data['status'] = $request->has('status') ? 1 : 0;
        $data['order'] = $request->order ?? 0;

        // Handle feature image upload
        if ($request->hasFile('feature_image')) {
            // Delete old feature image
            if ($spotlight->feature_image) {
                Storage::disk('public')->delete($spotlight->feature_image);
            }
            $data['feature_image'] = $request->file('feature_image')->store('spotlight/features', 'public');
        }

        // Handle gallery images upload
        if ($request->hasFile('gallery')) {
            // Delete old gallery images
            if ($spotlight->gallery) {
                foreach ($spotlight->gallery as $image) {
                    Storage::disk('public')->delete($image);
                }
            }
            
            $galleryImages = [];
            foreach ($request->file('gallery') as $file) {
                $galleryImages[] = $file->store('spotlight/gallery', 'public');
            }
            $data['gallery'] = $galleryImages;
        }

        $spotlight->update($data);

        return redirect()->route('spotlight.index')->with('success', 'Spotlight item updated successfully.');
    }

    /**
     * Remove the specified spotlight item from storage.
     */
    public function destroy(Spotlight $spotlight)
    {
        // Delete associated images
        if ($spotlight->feature_image) {
            Storage::disk('public')->delete($spotlight->feature_image);
        }
        
        if ($spotlight->gallery) {
            foreach ($spotlight->gallery as $image) {
                Storage::disk('public')->delete($image);
            }
        }

        $spotlight->delete();

        return response()->json(['success' => true, 'message' => 'Spotlight item deleted successfully.']);
    }

    /**
     * Toggle the status of the specified spotlight item.
     */
    public function toggleStatus(Spotlight $spotlight)
    {
        $spotlight->update(['status' => !$spotlight->status]);
        
        $status = $spotlight->status ? 'activated' : 'deactivated';
        return response()->json(['success' => true, 'message' => "Spotlight item {$status} successfully."]);
    }
}
