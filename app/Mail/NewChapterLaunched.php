<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewChapterLaunched extends Mailable
{
    use Queueable, SerializesModels;
    public $book;
    public $chapter;

    /**
     * Create a new message instance.
     */
    public function __construct($book, $chapter)
    {
        $this->book = $book;
        $this->chapter = $chapter;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Chapter Launched',
        );
    }

    /**
     * Get the message content definition.
     */

    public function build()
    {
        return $this->subject('🎉 New Chapter Launched!')
            ->view('emails.new-chapter-launched');
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
