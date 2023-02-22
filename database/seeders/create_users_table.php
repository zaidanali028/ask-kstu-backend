<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;


class create_users_table extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user_record=[
            [
            'id'=>3,
            'name'=>'kingThrive__',
            'password'=>Hash::make('12345678'),
            'gender'=>'male',
             'email'=>'linux@kvng2.com',
             'user_img'=>'',
             'index_no'=>'0521413500397',
             'faculty_id'=>7,
             'dept_id'=>6,
             "program_id"=>45,
             "status"=>1,
             "yr_of_admission"=>"2018",
             "yr_of_completion"=>"2022"
             

            
           
       

        ]
        ];

        User::insert($user_record);

    }
}