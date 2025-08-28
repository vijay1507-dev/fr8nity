<?php

namespace App\Http\Controllers;

use App\Models\Spotlight;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class EventPulseAdminController extends Controller
{
    /**
     * Display a listing of the event pulse items.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $eventPulseItems = Spotlight::with('creator')->eventPulse()->ordered();
            
            return DataTables::of($eventPulseItems)
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
                    $buttons .= '<a href="' . route('admin.event-pulse.edit', $row->id) . '" class="btn btn-sm btn-outline-success">Edit</a>';
                    $buttons .= '<form action="' . route('admin.event-pulse.destroy', $row->id) . '" method="POST" class="d-inline m-0 p-0">'
                                  . csrf_field()
                                  . method_field('DELETE') .
                                  '<button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm(\'Are you sure you want to delete this event pulse item?\')">Delete</button>' .
                                  '</form>';
                    $buttons .= '</div>';
                    return $buttons;
                })
                ->rawColumns(['status_badge', 'feature_image_thumb', 'action'])
                ->make(true);
        }

        return view('dashboard.event-pulse.index');
    }

    /**
     * Show the form for creating a new event pulse item.
     */
    public function create()
    {
        return view('dashboard.event-pulse.create');
    }

    /**
     * Store a newly created event pulse item in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'feature_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'gallery.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'boolean',
            'order' => 'integer|min:0'
        ]);

        $data = $request->all();
        $data['type'] = Spotlight::TYPE_EVENT_PULSE;
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

        return redirect()->route('admin.event-pulse.index')
                        ->with('success', 'Event Pulse item created successfully.');
    }

    /**
     * Show the form for editing the specified event pulse item.
     */
    public function edit(Spotlight $eventPulse)
    {
        // Ensure it's an event pulse type
        if ($eventPulse->type !== Spotlight::TYPE_EVENT_PULSE) {
            abort(404);
        }
        
        return view('dashboard.event-pulse.edit', compact('eventPulse'));
    }

    /**
     * Update the specified event pulse item in storage.
     */
    public function update(Request $request, Spotlight $eventPulse)
    {
        // Ensure it's an event pulse type
        if ($eventPulse->type !== Spotlight::TYPE_EVENT_PULSE) {
            abort(404);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'feature_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'gallery.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'boolean',
            'order' => 'integer|min:0'
        ]);

        $data = $request->all();
        $data['status'] = $request->has('status') ? 1 : 0;
        $data['order'] = $request->order ?? 0;

        // Handle feature image upload
        if ($request->hasFile('feature_image')) {
            // Delete old image
            if ($eventPulse->feature_image) {
                Storage::disk('public')->delete($eventPulse->feature_image);
            }
            $data['feature_image'] = $request->file('feature_image')->store('spotlight/features', 'public');
        }

        // Handle gallery images upload
        if ($request->hasFile('gallery')) {
            // Delete old gallery images
            if ($eventPulse->gallery) {
                foreach ($eventPulse->gallery as $oldImage) {
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

        $eventPulse->update($data);

        return redirect()->route('admin.event-pulse.index')
                        ->with('success', 'Event Pulse item updated successfully.');
    }

    /**
     * Remove the specified event pulse item from storage.
     */
    public function destroy(Spotlight $eventPulse)
    {
        // Ensure it's an event pulse type
        if ($eventPulse->type !== Spotlight::TYPE_EVENT_PULSE) {
            abort(404);
        }

        // Delete associated images
        if ($eventPulse->feature_image) {
            Storage::disk('public')->delete($eventPulse->feature_image);
        }

        if ($eventPulse->gallery) {
            foreach ($eventPulse->gallery as $image) {
                Storage::disk('public')->delete($image);
            }
        }

        $eventPulse->delete();

        return response()->json([
            'success' => true,
            'message' => 'Event Pulse item deleted successfully.'
        ]);
    }

    /**
     * Toggle the status of the specified event pulse item.
     */
    public function toggleStatus(Spotlight $eventPulse)
    {
        // Ensure it's an event pulse type
        if ($eventPulse->type !== Spotlight::TYPE_EVENT_PULSE) {
            abort(404);
        }

        $eventPulse->status = !$eventPulse->status;
        $eventPulse->save();

        return response()->json([
            'success' => true,
            'message' => 'Event Pulse status updated successfully.',
            'status' => $eventPulse->status
        ]);
    }
}