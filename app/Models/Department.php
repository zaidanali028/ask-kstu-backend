<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $table="departments";
    use HasFactory;
    public function get_department_faculty(){
        return $this->belongsTo('App\Models\Faculty',
        'faculty_id','id');

    }
    public function get_department_programs(){
        return $this->hasMany('App\Models\Program',
        'dept_id','id');
    }
}