<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MentoringReport extends Model
{
    protected $fillable = [
        'mentoring_session_id',
        'meeting_number',
        'summary',
        'output',
        'file',
        'status',
        'mentor_notes',
    ];

    // 🔥 Status constant (best practice)
    const STATUS_UNDER_REVIEW = 'under_review';
    const STATUS_REVISION = 'revision';
    const STATUS_APPROVED = 'approved';

    // Relasi
    public function session()
    {
        return $this->belongsTo(MentoringSession::class, 'mentoring_session_id');
    }

    protected static function booted()
    {
        static::creating(function ($report) {
            if (!$report->status) {
                $report->status = self::STATUS_UNDER_REVIEW;
            }
        });
    }
}