<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ScholarshipApplication extends Model
{
    // ──────────────────────────────────────────────
    // Constants
    // ──────────────────────────────────────────────

    public const STAGES = [
        'pendaftaran' => 'Registration',
    ];

    public const STATUSES = [
        'pending'     => 'Pending',
        'tidak_lolos' => 'Rejected',
        'lolos'       => 'Accepted',
    ];

    // ──────────────────────────────────────────────
    // Fillable & Casts
    // ──────────────────────────────────────────────

    protected $fillable = [
        'user_id',
        'scholarship_id',
        'program_study_id',
        'psp_application_id',
        'university',
        'current_stage',
        'status',
        'updated_date',
        'notes',
    ];

    protected $casts = [
        'updated_date' => 'date',
    ];

    // ──────────────────────────────────────────────
    // Relationships
    // ──────────────────────────────────────────────

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scholarship(): BelongsTo
    {
        return $this->belongsTo(Scholarship::class);
    }

    public function programStudy(): BelongsTo
    {
        return $this->belongsTo(ProgramStudy::class);
    }

    public function pspApplication(): BelongsTo
    {
        return $this->belongsTo(PspApplication::class, 'psp_application_id');
    }

    public function financialPlan()
    {
        return $this->hasOne(FinancialPlan::class);
    }

    public function logs(): HasMany
    {
        return $this->hasMany(ScholarshipApplicationLog::class);
    }

    // ──────────────────────────────────────────────
    // Accessors
    // ──────────────────────────────────────────────

    /**
     * Shortcut: ambil negara dari scholarship terkait.
     */
    public function getCountryAttribute(): ?string
    {
        return $this->scholarship?->country;
    }

    /**
     * Label tahapan terkini (human-readable).
     */
    public function getCurrentStageLabelAttribute(): string
    {
        return self::STAGES[$this->current_stage] ?? ucfirst($this->current_stage);
    }

    /**
     * Label status (human-readable).
     */
    public function getStatusLabelAttribute(): string
    {
        return self::STATUSES[$this->status] ?? ucfirst($this->status);
    }

    /**
     * Dynamic status calculation:
     * Simply returns the status since stage is only Pendaftaran.
     */
    public function getDisplayStatusAttribute(): string
    {
        return $this->status;
    }

    /**
     * Dynamic status label (human-readable).
     */
    public function getDisplayStatusLabelAttribute(): string
    {
        $status = $this->display_status;
        return self::STATUSES[$status] ?? ucfirst($status);
    }

    // ──────────────────────────────────────────────
    // Scopes
    // ──────────────────────────────────────────────

    public function scopeLolos($query)
    {
        return $query->where('status', 'lolos');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeTidakLolos($query)
    {
        return $query->where('status', 'tidak_lolos');
    }

    public function scopeByCountry($query, string $country)
    {
        return $query->whereHas('scholarship', fn ($q) => $q->where('country', $country));
    }

    public function scopeByPeriod($query, string $from, string $to)
    {
        return $query->whereBetween('updated_date', [$from, $to]);
    }

    public function scopeByProgram($query, int $programStudyId)
    {
        return $query->where('program_study_id', $programStudyId);
    }
}
