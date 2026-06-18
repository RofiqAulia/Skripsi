<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    /**
     * Required document types for the mentoring program.
     */
    public const REQUIRED_TYPES = [
        'cv'                => 'CV / Curriculum Vitae',
        'motivation_letter' => 'Motivation Letter',
        'ielts_toefl'       => 'IELTS / TOEFL Certificate',
        'transcript'        => 'Academic Transcript',
        'psp'               => 'Personal Study Plan (PSP)',
    ];

    protected $fillable = [
        'user_id',
        'type',
        'category',
        'file',
        'status',
        'notes',
        'reviewed_by',
        'reviewed_at',
    ];

    protected $casts = [
        'reviewed_at' => 'datetime',
    ];

    // ──────────────────────────────────────────
    // Relationships
    // ──────────────────────────────────────────

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    // ──────────────────────────────────────────
    // Helpers
    // ──────────────────────────────────────────

    /**
     * Get the human-readable label for a document type.
     */
    public static function typeLabel(string $type): string
    {
        return self::REQUIRED_TYPES[$type] ?? ucfirst(str_replace('_', ' ', $type));
    }

    /**
     * Check whether a given type key is a required document.
     */
    public static function isRequiredType(string $type): bool
    {
        return array_key_exists($type, self::REQUIRED_TYPES);
    }
}
