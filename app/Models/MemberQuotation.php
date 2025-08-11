<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MemberQuotation extends Model
{
    protected $fillable = [
        'member_id',
        'name',
        'phone',
        'email',
        'alternate_email',
        'uploaded_document',
        'port_of_loading_id',
        'port_of_discharge_id',
        'specifications',
        'message',
    ];

    protected $casts = [
        'specifications' => 'array',
    ];

    public function member(): BelongsTo
    {
        return $this->belongsTo(User::class, 'member_id');
    }
    public function portOfLoading(): BelongsTo
    {
        return $this->belongsTo(Port::class, 'port_of_loading_id');
    }
    public function portOfDischarge(): BelongsTo
    {
        return $this->belongsTo(Port::class, 'port_of_discharge_id');
    }
}
