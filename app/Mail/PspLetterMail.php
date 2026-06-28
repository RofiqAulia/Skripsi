<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Attachment;
use App\Models\PspApplication;

class PspLetterMail extends Mailable
{
    use Queueable, SerializesModels;

    public $application;
    protected $pdfContent;
    protected $filename;

    /**
     * Create a new message instance.
     */
    public function __construct(PspApplication $application, $pdfContent, $filename)
    {
        $this->application = $application;
        $this->pdfContent = $pdfContent;
        $this->filename = $filename;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Scholarship Preparation Program (PSP) Decision Letter - CLD Team',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.psp_letter',
        );
    }

    public function attachments(): array
    {
        $attachments = [
            Attachment::fromData(fn () => $this->pdfContent, $this->filename)
                    ->withMime('application/pdf'),
        ];

        if ($this->application->studyPlan && !empty($this->application->studyPlan->files)) {
            foreach ($this->application->studyPlan->files as $file) {
                $pathStr = is_array($file) ? ($file['path'] ?? '') : $file;
                $originalName = is_array($file) ? ($file['original_name'] ?? basename($pathStr)) : basename($pathStr);
                
                if ($pathStr) {
                    $fullPath = \Illuminate\Support\Facades\Storage::disk('public')->path($pathStr);
                    if (file_exists($fullPath)) {
                        $attachments[] = Attachment::fromPath($fullPath)->as($originalName);
                    }
                }
            }
        }

        return $attachments;
    }
}
