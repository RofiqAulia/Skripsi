<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Direktorat extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'head_id'];

    public function head()
    {
        return $this->hasOne(User::class)->whereHas('roles', function($q) {
            $q->where('name', 'pimpinan');
        });
    }

    public function groups()
    {
        return $this->hasMany(Group::class);
    }
}
