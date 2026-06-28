<x-mail::message>
# Revised Financial Plan Submitted

Hello Admin,

The user **{{ $plan->user->name ?? 'User' }}** has just resubmitted their Financial Plan after completing the requested revisions.

**Details:**
- **Scholarship:** {{ $plan->scholarshipApplication->programStudy->scholarship ?? 'N/A' }}
- **University:** {{ $plan->scholarshipApplication->programStudy->university ?? 'N/A' }}
- **Country:** {{ $plan->scholarshipApplication->programStudy->country ?? 'N/A' }}
- **Submitted At:** {{ now()->format('d M Y, H:i') }}

Please review the updated Financial Plan in the admin dashboard.

<x-mail::button :url="url('/admin/financial-plans/' . $plan->id . '/edit')">
Review Financial Plan
</x-mail::button>

Thanks,<br>
System
</x-mail::message>
