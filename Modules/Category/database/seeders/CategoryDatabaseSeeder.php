<?php

namespace Modules\Category\database\seeders;

use Illuminate\Database\Seeder;
use Modules\Category\app\Models\Category;

class CategoryDatabaseSeeder extends Seeder
{
    public static int $recordCount = 10;
    public function run()
    {
        $categories = [];

        for ($i = 0 ; $i<self::$recordCount ; $i++){
            $categories[] = [
                'name' => fake()->name()
            ];
        }
        foreach (array_chunk($categories, 50 ) as $chunk){
            Category::insert($chunk);
        }
    }
}
