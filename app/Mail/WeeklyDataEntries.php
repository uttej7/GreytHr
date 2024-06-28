<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class WeeklyDataEntries extends Mailable
{
    use Queueable, SerializesModels;
    public $filePath;
    public $fromAddress, $writer;

    /**
     * Create a new message instance.
     */
    public function __construct($filePath, $fromAddress)
    {
        $this->filePath = $filePath;
        $this->fromAddress = $fromAddress;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Weekly Data Entries',
        );
    }

    public function build()
    {
        return $this->from($this->fromAddress)
                    ->subject('Weekly Data Entries Export')
                    ->view('data-entry_content_view')
                    ->attach($this->filePath, [
                        'as' => 'data_entries.xlsx',
                        'mime' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                    ]);
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'data-entry_content_view',
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
