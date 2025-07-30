<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TradeMember extends Model
{
    use HasFactory;

    protected $table = 'trade_members';

    protected $fillable = [
        'company_name',
        'product_industry_category',
        'shipping_frequency',
        'mode_of_shipment',
        'origin_country',
        'destination_country',
        'estimated_shipment_volume',
        'looking_for',
        'name',
        'designation',
        'email',
        'whatsapp_phone',
        'additional_details',
        'consent',
    ];
    protected $casts = [
        'shipping_frequency' => 'array',
        'mode_of_shipment' => 'array',
        'looking_for' => 'array',
    ];
}
