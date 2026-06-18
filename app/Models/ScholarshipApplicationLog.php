<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ScholarshipApplicationLog extends Model
{
    protected $fillable = [
        'scholarship_application_id',
        'stage',
        'status',
        'log_date',
        'notes',
    ];

    protected $casts = [
        'log_date' => 'date',
    ];

    public function application(): BelongsTo
    {
        return $this->belongsTo(ScholarshipApplication::class, 'scholarship_application_id');
    }

    // ──────────────────────────────────────────────
    // Accessors
    // ──────────────────────────────────────────────

    public function getStageLabelAttribute(): string
    {
        return ScholarshipApplication::STAGES[$this->stage] ?? ucfirst($this->stage);
    }

    public function getStatusLabelAttribute(): string
    {
        return ScholarshipApplication::STATUSES[$this->status] ?? ucfirst($this->status);
    }
}
