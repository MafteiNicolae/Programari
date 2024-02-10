<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ChangeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $day;
    public $hour;
    public $oldDay;
    public $oldHour;
    /**
     * Create a new message instance.
     */
    public function __construct($name, $day, $hour, $oldDay, $oldHour)
    {
        $this->name = $name;
        $this->day = $day;
        $this->hour = $hour;
        $this->oldDay = $oldDay;
        $this->oldHour = $oldHour;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Change Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'mail.changeAppointment',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
