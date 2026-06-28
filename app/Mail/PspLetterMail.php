<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Attachment;
use App\Models\PspApplication;
use Illuminate\Support\Facades\Storage;

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
        $this->pdfContent  = $pdfContent;
        $this->filename    = $filename;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $subject = match($this->application->status) {
            'approved' => 'PSP Application Approved — Scholarship Preparation Program (PSP)',
            'review'   => 'PSP Application Requires Revision — Scholarship Preparation Program (PSP)',
            'rejected' => 'PSP Application Rejected — Scholarship Preparation Program (PSP)',
            default    => 'PSP Application Status Update — Scholarship Preparation Program (PSP)',
        };

        return new Envelope(subject: $subject);
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

    /**
     * Get attachments for the message.
     *
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        $attachments = [];

        // Attach the PSP decision letter PDF
        if ($this->pdfContent) {
            $attachments[] = Attachment::fromData(fn () => $this->pdfContent, $this->filename)
                ->withMime('application/pdf');
        }

        // Attach study plan files (if any)
        if ($this->application->studyPlan && !empty($this->application->studyPlan->files)) {
            foreach ($this->application->studyPlan->files as $file) {
                $pathStr      = is_array($file) ? ($file['path'] ?? '') : $file;
                $originalName = is_array($file) ? ($file['original_name'] ?? basename($pathStr)) : basename($pathStr);

                if ($pathStr) {
                    $fullPath = Storage::disk('public')->path($pathStr);
                    if (file_exists($fullPath)) {
                        $attachments[] = Attachment::fromPath($fullPath)->as($originalName);
                    }
                }
            }
        }

        // Attach all uploaded documents belonging to this user
        if ($this->application->user) {
            $documents = \App\Models\Document::where('user_id', $this->application->user_id)->get();
            foreach ($documents as $doc) {
                if ($doc->file) {
                    $fullPath = Storage::disk('public')->path($doc->file);
                    if (file_exists($fullPath)) {
                        $label = \App\Models\Document::typeLabel($doc->type) . ' — ' . basename($doc->file);
                        $attachments[] = Attachment::fromPath($fullPath)->as($label);
                    }
                }
            }
        }

        return $attachments;
    }
}
