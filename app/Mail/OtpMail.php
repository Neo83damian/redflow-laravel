<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public string $code)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(subject: 'REDFLOW Password Reset Code');
    }

    public function content(): Content
    {
        return new Content(
            htmlString: '<p>Your REDFLOW password reset verification code is:</p>'
                . '<h1 style="letter-spacing:6px;">' . e($this->code) . '</h1>'
                . '<p>This code expires in 10 minutes. If you did not request this, you can ignore this email.</p>'
        );
    }
}
