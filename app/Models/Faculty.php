<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faculty extends Model
{
    use HasFactory;
    public function get_faculty_departments(){
        return $this->hasMany('App\Models\Department',
        'faculty_id','id');
    }


}