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
}
