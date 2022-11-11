<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = ['Pantalon','Kazak','Elbise','Tişört',
        'Takım','Gelinlik','Şort','Tayt','Alt Eşofman',
        'Çıtçıtlı Atlet','Pijama Takımı','Kapri','Takım elbise',
        
    ];
        foreach ($categories as $category) {
            Category::create([
                'name' => $category
            ]);
        }
    }
}
