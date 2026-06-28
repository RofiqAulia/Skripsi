<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\FinancialPlan;

class AdminFinancialPlanRevisionMail extends Mailable
{
    use Queueable, SerializesModels;

    public FinancialPlan $plan;

    public function __construct(FinancialPlan $plan)
    {
        $this->plan = $plan;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Revised Financial Plan Submitted - ' . ($this->plan->user->name ?? 'User'),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.admin_financial_plan_revision',
        );
    }
}
