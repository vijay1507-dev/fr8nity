<?php

namespace App\Services;

use App\Models\TradeMember;
use App\Models\User;
use App\Notifications\TradeMembershipNotification;
use Illuminate\Support\Facades\Notification;

class TradeMemberService
{
    public function createAndNotify(array $validatedData): TradeMember
    {
        $tradeMember = TradeMember::create([
            'company_name' => $validatedData['company_name'],
            'product_industry_category' => $validatedData['product_industry_category'],
            'shipping_frequency' => $validatedData['shipping_frequency'],
            'mode_of_shipment' => $validatedData['mode_of_shipment'],
            'origin_country' => $validatedData['origin_country'],
            'destination_country' => $validatedData['destination_country'],
            'estimated_shipment_volume' => $validatedData['estimated_shipment_volume'],
            'looking_for' => $validatedData['looking_for'],
            'name' => $validatedData['name'],
            'designation' => $validatedData['designation'],
            'email' => $validatedData['email'],
            'whatsapp_phone' => $validatedData['whatsapp_phone'],
            'additional_details' => $validatedData['additional_details'] ?? null,
            'consent' => true,
        ]);

        Notification::route('mail', $tradeMember->email)
            ->notify(new TradeMembershipNotification($tradeMember));

        $admins = User::where('role', User::SUPER_ADMIN)->get();
        Notification::send($admins, new TradeMembershipNotification($tradeMember, true));

        return $tradeMember;
    }
}


