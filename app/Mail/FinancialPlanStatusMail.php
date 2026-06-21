<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\FinancialPlan;

class FinancialPlanStatusMail extends Mailable
{
    use Queueable, SerializesModels;

    public FinancialPlan $plan;
    public string $newStatus;
    public ?string $adminNotes;

    public function __construct(FinancialPlan $plan, string $newStatus, ?string $adminNotes = null)
    {
        $this->plan = $plan;
        $this->newStatus = $newStatus;
        $this->adminNotes = $adminNotes;
    }

    public function envelope(): Envelope
    {
        $subject = match ($this->newStatus) {
            'approved' => 'Financial Plan Approved - CLD Team',
            'revision_needed' => 'Financial Plan Requires Revision - CLD Team',
            default => 'Financial Plan Status Update - CLD Team',
        };

        return new Envelope(subject: $subject);
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.financial_plan_status',
        );
    }

    public function attachments(): array
    {
        if ($this->newStatus === 'approved') {
            $plan = $this->plan;
            $plan->loadMissing(['user', 'scholarshipApplication.programStudy', 'items']);
            
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.financial-plan-letter', compact('plan'))
                ->setPaper('a4', 'portrait');
            $pdfContent = $pdf->output();

            $filename = 'Approved-Financial-Plan-' . ($plan->user->name ?? 'User') . '-' . now()->format('Ymd') . '.pdf';

            return [
                \Illuminate\Mail\Mailables\Attachment::fromData(fn () => $pdfContent, $filename)
                    ->withMime('application/pdf'),
            ];
        }

        return [];
    }
}
