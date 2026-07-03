<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $fillable = ['direktorat_id', 'name', 'head_id'];

    public function direktorat()
    {
        return $this->belongsTo(Direktorat::class);
    }

    public function head()
    {
        return $this->hasOne(User::class)->whereHas('roles', function($q) {
            $q->where('name', 'pimpinan');
        });
    }

    public function departments()
    {
        return $this->hasMany(Department::class);
    }
}
