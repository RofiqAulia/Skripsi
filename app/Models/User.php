<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\Hash;
use Filament\Models\Contracts\HasAvatar;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;

class User extends Authenticatable implements HasAvatar, FilamentUser
{
    use HasRoles;
    use HasFactory; 

    protected $fillable = [
        'name',
        'email',
        'password',
        'position',
        'company',
        'photo',
        'age',
        'signature_image',
        'signature_pad',
        'toefl_score',
        'ielts_score',
        'department_id',
        'group_id',
        'direktorat_id',
    ];

    public function setPasswordAttribute($value)
    {
        // hanya hash kalau belum di-hash
        if (!password_get_info($value)['algo']) {
            $this->attributes['password'] = Hash::make($value);
        } else {
            $this->attributes['password'] = $value;
        }
    }

    public function getFilamentAvatarUrl(): ?string
    {
        return $this->photo ? asset($this->photo) : null;
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->hasAnyRole(['super_admin', 'mentor', 'pimpinan']);
    }

    public function mentor()
    {
        return $this->hasOne(\App\Models\Mentor::class);
    }


    public function sessions()
    {
        return $this->hasMany(MentoringSession::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function direktorat()
    {
        return $this->belongsTo(Direktorat::class);
    }

    public function studyPlan()
    {
        return $this->hasOne(StudyPlan::class);
    }

    public function pspApplication()
    {
        return $this->hasOne(PspApplication::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function scholarshipApplications()
    {
        return $this->hasMany(ScholarshipApplication::class);
    }

    public function financialPlans()
    {
        return $this->hasMany(FinancialPlan::class);
    }

    public function updateLeadership()
    {
        // First, remove this user from any existing head_id
        \App\Models\Department::where('head_id', $this->id)->update(['head_id' => null]);
        \App\Models\Group::where('head_id', $this->id)->update(['head_id' => null]);
        \App\Models\Direktorat::where('head_id', $this->id)->update(['head_id' => null]);

        // If they have the pimpinan role, assign them to their current placement
        if ($this->hasRole('pimpinan')) {
            if ($this->department_id) {
                \App\Models\Department::where('id', $this->department_id)->update(['head_id' => $this->id]);
            } elseif ($this->group_id) {
                \App\Models\Group::where('id', $this->group_id)->update(['head_id' => $this->id]);
            } elseif ($this->direktorat_id) {
                \App\Models\Direktorat::where('id', $this->direktorat_id)->update(['head_id' => $this->id]);
            }
        }
    }
}
