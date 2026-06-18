<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Attachment;
use App\Models\FinancialPlan;

class FinancialPlanMail extends Mailable
{
    use Queueable, SerializesModels;

    public $plan;
    protected $pdfContent;
    protected $filename;

    public function __construct(FinancialPlan $plan, $pdfContent, $filename)
    {
        $this->plan = $plan;
        $this->pdfContent = $pdfContent;
        $this->filename = $filename;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Financial Plan Submission Confirmation - CLD Team',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.financial_plan_letter',
        );
    }

    public function attachments(): array
    {
        return [
            Attachment::fromData(fn () => $this->pdfContent, $this->filename)
                    ->withMime('application/pdf'),
        ];
    }
}
