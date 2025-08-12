<?php

namespace App\Services;

use App\Models\MemberQuotation;
use App\Models\User;
use App\Notifications\QuotationNotification;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;

class MemberQuotationService
{
    public function createAndNotify(array $validatedData, ?UploadedFile $document): MemberQuotation
    {
        if ($document) {
            $path = $document->store('quotation-documents', 'public');
            $validatedData['uploaded_document'] = $path;
        }

        $quotation = MemberQuotation::create($validatedData);

        Notification::route('mail', config('mail.super_admin_email'))
            ->notify(new QuotationNotification($quotation, true));

        $quotation->receiver->notify(new QuotationNotification($quotation));

        Notification::route('mail', $quotation->email)
            ->notify(new QuotationNotification($quotation, false, true));

        return $quotation;
    }
}


