<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable=[
        'name',
        'status'
    ];




    public function get_category_announcements(){
        return $this->hasMany('App\Models\Announcement',
        'category_id','id')->latest();

    }

    public function paginated_announcements($perPage = 12)
    {
        return $this->get_category_announcements()
        ->paginate($perPage);
    }
}