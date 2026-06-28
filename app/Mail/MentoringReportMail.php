<?php

namespace App\Mail;

use App\Models\MentoringReport;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class MentoringReportMail extends Mailable
{
    use Queueable, SerializesModels;

    public $report;

    public function __construct(MentoringReport $report)
    {
        $this->report = $report;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Mentoring Report Submission - ' . ($this->report->session->user->name ?? 'Mentee'),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.mentoring_report',
        );
    }

    public function attachments(): array
    {
        $attachments = [];

        if ($this->report->file) {
            $path = Storage::disk('public')->path($this->report->file);
            if (file_exists($path)) {
                $attachments[] = Attachment::fromPath($path)
                                ->as(basename($this->report->file));
            }
        }

        return $attachments;
    }
}
