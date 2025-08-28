<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Spotlight extends Model
{
    use HasFactory;

    const TYPE_EVENT_PULSE = 'event_pulse';
    const TYPE_PARTNER_SHOWCASE = 'partner_showcase';

    protected $fillable = [
        'title',
        'description',
        'feature_image',
        'gallery',
        'type',
        'status',
        'created_by',
        'order'
    ];

    protected $casts = [
        'gallery' => 'array',
        'status' => 'boolean'
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function getGalleryImagesAttribute()
    {
        return $this->gallery ? array_filter($this->gallery) : [];
    }

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function scopeEventPulse($query)
    {
        return $query->where('type', self::TYPE_EVENT_PULSE);
    }

    public function scopePartnerShowcase($query)
    {
        return $query->where('type', self::TYPE_PARTNER_SHOWCASE);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc')->orderBy('created_at', 'desc');
    }

    public static function getTypes()
    {
        return [
            self::TYPE_EVENT_PULSE => 'Event Pulse',
            self::TYPE_PARTNER_SHOWCASE => 'Partner Showcase'
        ];
    }
}
