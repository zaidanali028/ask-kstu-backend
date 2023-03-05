<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnnouncementDetail extends Model
{
    use HasFactory;
    protected $appends=[
        'tmp_image'
    ];

    public function getTmpImageAttribute(){
        return [
           'tmp_image'=>null
        ];
    }


}