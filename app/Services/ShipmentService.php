<?php

namespace App\Services;

use App\Models\Shipment;
use App\Models\User;
use App\Notifications\ShipmentEnquiryNotification;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Notification;

class ShipmentService
{
    public function createShipment(array $validatedData, ?UploadedFile $documentsFile): Shipment
    {
        if ($documentsFile) {
            $path = $documentsFile->store('shipment-documents', 'public');
            $validatedData['documents'] = $path;
        }

        $shipment = Shipment::create($validatedData);

        Notification::route('mail', $shipment->email)
            ->notify(new ShipmentEnquiryNotification($shipment));

        $admins = User::where('role', User::SUPER_ADMIN)->get();
        Notification::send($admins, new ShipmentEnquiryNotification($shipment, true));

        return $shipment;
    }

    public function updateShipment(Shipment $shipment, array $validatedData, ?UploadedFile $documentsFile): Shipment
    {
        if ($documentsFile) {
            $path = $documentsFile->store('shipment-documents', 'public');
            $validatedData['documents'] = $path;
        }

        $shipment->update($validatedData);

        return $shipment;
    }
}


