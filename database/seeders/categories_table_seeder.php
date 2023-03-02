<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class categories_table_seeder extends Seeder
{
    
    
   
    public function run(): void
    {
        $category_records=[
      
            ['id'=>1,
           
          
            'status'=>1,
            'name'=>"Academic Information"
    
    
         ],
         ['id'=>2,
           
          
         'status'=>1,
         'name'=>"Latest News "
    
         ]
        ];
    

    Category::insert($category_records);


    }
}