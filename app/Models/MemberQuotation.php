<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MemberQuotation extends Model
{
    /**
     * Status constants for quotation
     */
    const STATUS_CLOSED_UNSUCCESSFUL = 0;
    const STATUS_CLOSED_SUCCESSFUL = 1;

    /**
     * Status labels for display
     */
    const STATUS_LABELS = [
        self::STATUS_CLOSED_UNSUCCESSFUL => 'Closed on Unsuccessful',
        self::STATUS_CLOSED_SUCCESSFUL => 'Successful',
    ];

    protected $fillable = [
        'receiver_id',
        'given_by_id',
        'name',
        'phone',
        'email',
        'alternate_email',
        'uploaded_document',
        'port_of_loading_id',
        'port_of_discharge_id',
        'specifications',
        'message',
        'transaction_value',
        'status',
        'quotation_reference_no',
    ];

    protected $casts = [
        'specifications' => 'array',
    ];

    public function receiver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
    public function givenBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'given_by_id');
    }
    public function portOfLoading(): BelongsTo
    {
        return $this->belongsTo(Port::class, 'port_of_loading_id');
    }
    public function portOfDischarge(): BelongsTo
    {
        return $this->belongsTo(Port::class, 'port_of_discharge_id');
    }

    /**
     * Get the status label for display
     */
    public function getStatusLabel(): string
    {
        return self::STATUS_LABELS[$this->status] ?? 'N/A';
    }
}
