<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mentor extends Model
{
    protected $fillable = ['user_id', 'current_position', 'company', 'quota', 'photo', 'education', 'career_journey', 'achievements'];

    protected $casts = [
        'education' => 'array',
        'career_journey' => 'array',
        'achievements' => 'array',
    ];

        public function user()
        {
            return $this->belongsTo(\App\Models\User::class);
        }

    protected static function booted()
    {
        static::created(function ($mentor) {
            if ($mentor->user) {
                $mentor->user->assignRole('mentor');
            }
        });

        static::deleted(function ($mentor) {
            if ($mentor->user) {
                $mentor->user->removeRole('mentor');
            }
        });

        static::saved(function ($mentor) {
            if ($mentor->isDirty('photo') && $mentor->user) {
                if ($mentor->user->photo !== $mentor->photo) {
                    $mentor->user->updateQuietly(['photo' => $mentor->photo]);
                }
            }
        });
    }

    public function schedules()
    {
        return $this->hasMany(MentorSchedule::class);
    }

    public function sessions()
    {
        return $this->hasMany(MentoringSession::class);
    }
}
