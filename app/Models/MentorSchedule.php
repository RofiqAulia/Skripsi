<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MentorSchedule extends Model
{
    protected $fillable = ['mentor_id','date','start_time','end_time'];
    protected $appends = ['status'];

    public function mentor()
    {
        return $this->belongsTo(Mentor::class);
    }

    public function session()
    {
        return $this->hasOne(MentoringSession::class, 'schedule_id');
    }

    public function getStatusAttribute()
    {
        $now = \Carbon\Carbon::now('Asia/Jakarta');
        $scheduleDateTime = \Carbon\Carbon::parse($this->date . ' ' . $this->end_time, 'Asia/Jakarta');

        if ($now->greaterThan($scheduleDateTime)) {
            return 'Expired';
        }

        if ($this->session && $this->session->status !== 'cancelled') {
            return 'Booked';
        }

        return 'Available';
    }
}
