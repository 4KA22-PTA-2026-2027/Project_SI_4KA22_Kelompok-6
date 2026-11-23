<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TalentCategory extends Model
{
    protected $fillable = ['name', 'icon'];

    public function kolProfiles()
    {
        return $this->hasMany(KolProfile::class);
    }

    public function jobs()
    {
        return $this->hasMany(Job::class);
    }
}
