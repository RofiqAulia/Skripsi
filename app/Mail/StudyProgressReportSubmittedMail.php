<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Attachment;

class StudyProgressReportSubmittedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $report;
    public $user;
    public $pdfContent;
    public $fileName;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($report, $user, $pdfContent)
    {
        $this->report = $report;
        $this->user = $user;
        $this->pdfContent = $pdfContent;
        $this->fileName = 'Study_Progress_Report_' . str_replace(' ', '_', $user->name) . '_Semester_' . $report->semester . '.pdf';
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Study Progress Report Submitted - ' . $this->user->name,
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: 'emails.study-progress-report-submitted',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        $attachments = [
            Attachment::fromData(fn () => $this->pdfContent, $this->fileName)
                ->withMime('application/pdf'),
        ];

        if (!empty($this->report->certificates)) {
            foreach ($this->report->certificates as $certificatePath) {
                $fullPath = storage_path('app/public/' . $certificatePath);
                if (file_exists($fullPath)) {
                    $attachments[] = Attachment::fromPath($fullPath);
                }
            }
        }

        if (!empty($this->report->other_files)) {
            foreach ($this->report->other_files as $otherPath) {
                $fullPath = storage_path('app/public/' . $otherPath);
                if (file_exists($fullPath)) {
                    $attachments[] = Attachment::fromPath($fullPath);
                }
            }
        }

        return $attachments;
    }
}
