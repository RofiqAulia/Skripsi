<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $fillable = ['group_id', 'name', 'head_id'];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function head()
    {
        return $this->hasOne(User::class)->whereHas('roles', function($q) {
            $q->where('name', 'pimpinan');
        });
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
