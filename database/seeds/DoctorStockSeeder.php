<?php

use App\Models\DoctorProduct;
use App\Models\ProductStock;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DoctorStockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $doctor_products = array(
          array('price' => rand(100,1000), 'threshold'=> 100, 'quantity' => 200, 'doctor_id' => 1, 'product_id' => 1),
          array('price' => rand(100,1000), 'threshold'=> 100, 'quantity' => 200, 'doctor_id' => 1, 'product_id' => 2),
          array('price' => rand(100,1000), 'threshold'=> 100, 'quantity' => 400, 'doctor_id' => 1, 'product_id' => 3),
          array('price' => rand(100,1000), 'threshold'=> 100, 'quantity' => 300, 'doctor_id' => 1, 'product_id' => 4),
          array('price' => rand(100,1000), 'threshold'=> 100, 'quantity' => 200, 'doctor_id' => 1, 'product_id' => 5),
          array('price' => rand(100,1000), 'threshold'=> 100, 'quantity' => 400, 'doctor_id' => 1, 'product_id' => 6),
          array('price' => rand(100,1000), 'threshold'=> 100, 'quantity' => 300, 'doctor_id' => 1, 'product_id' => 7),
          array('price' => rand(100,1000), 'threshold'=> 100, 'quantity' => 200, 'doctor_id' => 1, 'product_id' => 8),
          array('price' => rand(100,1000), 'threshold'=> 100, 'quantity' => 200, 'doctor_id' => 1, 'product_id' => 9),
          array('price' => rand(100,1000), 'threshold'=> 100, 'quantity' => 400, 'doctor_id' => 1, 'product_id' => 10),

        );

        foreach ($doctor_products as $doctor_product) {
            DoctorProduct::create($doctor_product);
        }

        $product_stocks = array(
            array('stock_date' => Carbon::now(), 'quantity' => 200, 'doctor_product_id' => 1),
            array('stock_date' => Carbon::now(), 'quantity' => 200, 'doctor_product_id' => 2),
            array('stock_date' => Carbon::now(), 'quantity' => 400, 'doctor_product_id' => 3),
            array('stock_date' => Carbon::now(), 'quantity' => 300, 'doctor_product_id' => 4),
            array('stock_date' => Carbon::now(), 'quantity' => 200, 'doctor_product_id' => 5),
            array('stock_date' => Carbon::now(), 'quantity' => 400, 'doctor_product_id' => 6),
            array('stock_date' => Carbon::now(), 'quantity' => 300, 'doctor_product_id' => 7),
            array('stock_date' => Carbon::now(), 'quantity' => 200, 'doctor_product_id' => 8),
            array('stock_date' => Carbon::now(), 'quantity' => 200, 'doctor_product_id' => 9),
            array('stock_date' => Carbon::now(), 'quantity' => 400, 'doctor_product_id' => 10),
        );

        foreach ($product_stocks as $product_stock) {
            ProductStock::create($product_stock);
        }
    }
}
