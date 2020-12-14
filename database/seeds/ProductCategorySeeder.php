<?php

use App\Models\ProductCategory;
use Illuminate\Database\Seeder;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = array(
          array('name'=> 'Anaesthetics'),
          array('name'=>'General')
        );

        foreach ($categories as $category)
        {
            ProductCategory::create($category);
        }
    }
}
