<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;

    public function get_announcement_category()
    {
        return $this->belongsTo('App\Models\Category', 'category_id', 'id');
        // ->select('category_name');
    }
    public function get_announcement_key_moments()
    {
        return $this->hasMany('App\Models\AnnouncementDetail', 'announcement_id', 'id');

    }
}
