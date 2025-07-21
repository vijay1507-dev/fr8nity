<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MailTemplate extends Model
{
    protected $fillable = [
        'name',
        'subject',
        'body',
        'comment',
        'variables',
        'is_active'
    ];

    protected $casts = [
        'variables' => 'array',
        'is_active' => 'boolean'
    ];

    public function parseTemplate(array $data)
    {
        $subject = $this->subject;
        $body = $this->body;

        foreach ($data as $key => $value) {
            $placeholder = '{{' . $key . '}}';
            $subject = str_replace($placeholder, $value, $subject);
            $body = str_replace($placeholder, $value, $body);
        }

        return [
            'subject' => $subject,
            'body' => $body
        ];
    }
} 