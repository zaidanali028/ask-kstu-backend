<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    protected $table="programs";

    use HasFactory;
    public function get_program_department(){
        return $this->belongsTo('App\Models\Department',
        'dept_id','id');
    }

}