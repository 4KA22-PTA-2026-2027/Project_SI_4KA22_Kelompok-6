<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KolProfile extends Model
{
    protected $fillable = ['user_id', 'talent_category_id', 'bio', 'followers', 'instagram', 'tiktok', 'youtube', 'rate', 'total_jobs', 'completed_jobs'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(TalentCategory::class, 'talent_category_id');
    }
}
