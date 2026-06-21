<x-mail::message>
# Status Update for Your Financial Plan

Hello {{ $plan->user->name ?? 'User' }},

The status of your Financial Plan for **{{ $plan->scholarshipApplication->programStudy->scholarship ?? 'Scholarship' }}** at **{{ $plan->scholarshipApplication->programStudy->university ?? 'University' }}** has been updated by the Admin.

**Current Status:** <span style="text-transform: uppercase; font-weight: bold;">{{ str_replace('_', ' ', $plan->status) }}</span>

@if($plan->status === 'revision_needed')
**Admin Notes for Revision:**
> {{ $plan->admin_notes ?? 'No additional notes provided.' }}

Please update your Financial Plan based on the feedback above and resubmit it for review.
@elseif($plan->status === 'approved')
Congratulations! Your Financial Plan has been **Approved**. 

We have attached the officially approved Financial Plan document (PDF) to this email for your records.
@if($plan->admin_notes)
**Admin Notes:**
> {{ $plan->admin_notes }}
@endif
@endif

<x-mail::button :url="url('/financial-plan')">
View My Financial Plan
</x-mail::button>

Thanks,<br>
Department of CLD
</x-mail::message>
