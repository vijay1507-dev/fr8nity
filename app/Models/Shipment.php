<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    use HasFactory;

    protected $fillable = [
        'shipment_type',
        'mode_of_transport',
        'goods_description',
        'estimated_volume',
        'cargo_ready_date',
        'documents',
        'pickup_country_id',
        'pickup_city_id',
        'destination_country_id',
        'destination_city_id',
        'special_notes',
        'delivery_remark',
        'consent'
    ];

    protected $casts = [
        'shipment_type' => 'array',
        'cargo_ready_date' => 'date',
        'consent' => 'boolean'
    ];

    // Relationships
    public function pickupCountry()
    {
        return $this->belongsTo(Country::class, 'pickup_country_id');
    }

    public function pickupCity()
    {
        return $this->belongsTo(City::class, 'pickup_city_id');
    }

    public function destinationCountry()
    {
        return $this->belongsTo(Country::class, 'destination_country_id');
    }

    public function destinationCity()
    {
        return $this->belongsTo(City::class, 'destination_city_id');
    }
} 