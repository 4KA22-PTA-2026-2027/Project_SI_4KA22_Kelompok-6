<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BrandProfile extends Model
{
    protected $fillable = ['user_id', 'company_name', 'description', 'logo', 'website'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
