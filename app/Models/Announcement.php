<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    public function get_announcement_category(){
        return $this->belongsTo('App\Models\Category','category_id','id');
        // ->select('category_name');
    }
    use HasFactory;
}