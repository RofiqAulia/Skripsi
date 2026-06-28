<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MentoringSession extends Model
{
    protected $fillable = [
        'user_id','mentor_id','schedule_id','status','link_meet'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function mentor()
    {
        return $this->belongsTo(Mentor::class);
    }

    public function schedule()
    {
        return $this->belongsTo(MentorSchedule::class);
    }

    public function report()
    {
        return $this->hasOne(MentoringReport::class);
    }

    protected static function booted()
    {
        static::updated(function ($session) {
            if ($session->isDirty('status')) {
                if ($session->status === 'cancelled') {
                    // Send email to mentor
                    if ($session->mentor && $session->mentor->user) {
                        \Illuminate\Support\Facades\Mail::to($session->mentor->user->email)
                            ->send(new \App\Mail\MentoringCancelledMail($session, 'mentor'));
                    }
                    
                    // Send email to mentee
                    if ($session->user) {
                        \Illuminate\Support\Facades\Mail::to($session->user->email)
                            ->send(new \App\Mail\MentoringCancelledMail($session, 'mentee'));
                    }
                } elseif ($session->status === 'done') {
                    // Send email to mentor
                    if ($session->mentor && $session->mentor->user) {
                        \Illuminate\Support\Facades\Mail::to($session->mentor->user->email)
                            ->send(new \App\Mail\MentoringDoneMail($session, 'mentor'));
                    }
                    
                    // Send email to mentee
                    if ($session->user) {
                        \Illuminate\Support\Facades\Mail::to($session->user->email)
                            ->send(new \App\Mail\MentoringDoneMail($session, 'mentee'));
                    }
                }
            }
        });
    }
}
