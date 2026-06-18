<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MentorSchedule extends Model
{
    protected $fillable = ['mentor_id','date','start_time','end_time'];

    public function mentor()
    {
        return $this->belongsTo(Mentor::class);
    }

    public function session()
    {
        return $this->hasOne(MentoringSession::class, 'schedule_id');
    }
}
