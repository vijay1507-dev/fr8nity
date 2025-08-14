<?php

namespace App\Http\Controllers;

use App\Models\Shipment;
use App\Models\Country;
use App\Models\City;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Services\ShipmentService;

class ShipmentController extends Controller
{
    public function __construct(private readonly ShipmentService $shipmentService)
    {
    }
    /**
     * Display a listing of the shipments.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Shipment::query()->with(['pickupCountry', 'pickupCity', 'destinationCountry', 'destinationCity']);

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('pickup_location', function($row) {
                    return $row->pickupCity->name . ', ' . $row->pickupCountry->name;
                })
                ->addColumn('destination_location', function($row) {
                    return $row->destinationCity->name . ', ' . $row->destinationCountry->name;
                })
                ->addColumn('shipment_types', function($row) {
                    // Handle both JSON string and array formats
                    $types = $row->shipment_type;
                    if (is_string($types)) {
                        $types = json_decode($types, true);
                    }
                    return is_array($types) ? implode(', ', $types) : $types;
                })
                ->editColumn('cargo_ready_date', function ($row) {
                    return \Carbon\Carbon::parse($row->cargo_ready_date)->format('F j, Y');
                })
                ->addColumn('created_at', function($row) {
                    return $row->created_at->format('d M Y H:i');
                })
                ->addColumn('action', function($row) {
                    $viewBtn = '<a href="' . route('shipments.show', $row) . '" class="btn btn-sm btn-outline-primary">View</a>';
                    $editBtn = '<a href="' . route('shipments.edit', $row) . '" class="btn btn-sm btn-outline-success">Edit</a>';
                    $deleteBtn = '<form action="' . route('shipments.destroy', $row) . '" method="POST" style="display:inline-block;">
                                    ' . csrf_field() . '
                                    ' . method_field('DELETE') . '
                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm(\'Are you sure you want to delete this shipment enquiry?\')">Delete</button>
                                  </form>';
                    return $viewBtn . ' ' . $editBtn . ' ' . $deleteBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('dashboard.shipments.index');
    }

    /**
     * Show the specified shipment.
     */
    public function show(Shipment $shipment)
    {
        $shipment->load(['pickupCountry', 'pickupCity', 'destinationCountry', 'destinationCity']);
        return view('dashboard.shipments.show', compact('shipment'));
    }

    /**
     * Show the form for creating a new shipment.
     */
    public function create()
    {
        $countries = Country::all();
        $cities = City::all();
        return view('dashboard.shipments.create', compact('countries', 'cities'));
    }

    /**
     * Store a newly created shipment in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|min:2|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required',
            'company_name' => 'required|string|min:2|max:255',
            'shipment_type' => 'required|array|min:1',
            'mode_of_transport' => 'required|string',
            'goods_description' => 'required|string|min:3',
            'estimated_volume' => 'required|string',
            'cargo_ready_date' => 'required|date',
            'documents' => 'nullable|file|max:10240', // 10MB max
            'pickup_country_id' => 'required|exists:countries,id',
            'pickup_city_id' => 'required|exists:cities,id',
            'destination_country_id' => 'required|exists:countries,id',
            'destination_city_id' => 'required|exists:cities,id',
            'special_notes' => 'nullable|string',
            'delivery_remark' => 'nullable|string',
            'consent' => 'required|accepted'
        ]);

        $shipment = $this->shipmentService->createShipment($validated, $request->file('documents'));

        return redirect()->route('thank-you')->with('message', 'Your shipment enquiry has been submitted successfully. Our team will review your request and provide quotations shortly.');
    }

    /**
     * Show the form for editing the specified shipment.
     */
    public function edit(Shipment $shipment)
    {
        $countries = Country::all();
        $cities = City::all();
        return view('dashboard.shipments.edit', compact('shipment', 'countries', 'cities'));
    }

    /**
     * Update the specified shipment in storage.
     */
    public function update(Request $request, Shipment $shipment)
    {
        $validated = $request->validate([
            'name' => 'required|string|min:2|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required',
            'company_name' => 'required|string|min:2|max:255',
            'shipment_type' => 'required|array|min:1',
            'mode_of_transport' => 'required|string',
            'goods_description' => 'required|string|min:3',
            'estimated_volume' => 'required|string',
            'cargo_ready_date' => 'required|date',
            'documents' => 'nullable|file|max:10240', // 10MB max
            'pickup_country_id' => 'required|exists:countries,id',
            'pickup_city_id' => 'required|exists:cities,id',
            'destination_country_id' => 'required|exists:countries,id',
            'destination_city_id' => 'required|exists:cities,id',
            'special_notes' => 'nullable|string',
            'delivery_remark' => 'nullable|string',
        ]);
        $this->shipmentService->updateShipment($shipment, $validated, $request->file('documents'));

        return redirect()->route('shipments.show', $shipment)
            ->with('success', 'Shipment enquiry updated successfully!');
    }

    /**
     * Remove the specified shipment from storage.
     */
    public function destroy(Shipment $shipment)
    {
        $shipment->delete();

        return redirect()->route('shipments.index')
            ->with('success', 'Shipment enquiry deleted successfully.');
    }
} 