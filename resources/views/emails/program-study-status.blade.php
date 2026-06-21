<x-mail::message>
# Status Update for Your Program Study Request

Hello {{ $programStudy->submitter->name ?? 'User' }},

The status of your suggested program study **{{ $programStudy->name }}** at **{{ $programStudy->university }}** has been updated.

**Current Status:** <span style="text-transform: uppercase; font-weight: bold;">{{ $programStudy->status }}</span>

@if($programStudy->status === 'revision')
**Admin Notes for Revision:**
> {{ $programStudy->admin_notes ?? 'No additional notes provided.' }}

Please update your submission based on the feedback above.
@elseif($programStudy->status === 'rejected')
**Reason for Rejection:**
> {{ $programStudy->admin_notes ?? 'No additional notes provided.' }}
@elseif($programStudy->status === 'approved')
Congratulations! Your suggested program study has been approved and is now visible in the system.
@endif

Please access your PSP history now in the "My Suggestions" section for further details.

<x-mail::button :url="url('/psp')">
View My Suggestions
</x-mail::button>

Thanks,<br>
Department of CLD
</x-mail::message>
