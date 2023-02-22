<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admins;
use Illuminate\Support\Facades\Hash;

class admins_table_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      
      
        //insert one admin record
        $admin_record=[
            [
            'id'=>5,
            'name'=>'kingThrive_',
            'gender'=>'male',
            
            'admin_type'=>"dean",
            'email'=>'linux@kvng.com',
            'password'=>Hash::make('12345678'),
           
       

        ]
        ];
        Admins::insert($admin_record);

    }
}