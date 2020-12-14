<?php

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = array(
            array('product_code'=>'G01001','product_name'=>'Halothane (with vaporizer)','product_description'=>'Fluothane (halothane) is an inhalation anesthetic indicated for the induction and maintenance of general anesthesia','product_size'=>'250ml', 'product_unit'=>'Bottle','product_category_id'=> 1),
            array('product_code'=>'G01002','product_name'=>'Isoflurance Inhalation','product_description'=>'Isoflurane is a halogenated hydrocarbon that is commonly used as an animal anesthetic.','product_size'=>'100ml', 'product_unit'=>'Bottle','product_category_id'=> 1),
            array('product_code'=>'G01003','product_name'=>'Ketamine Injection IP 10 mg/ml','product_description'=>'Ketamine Injection IP 10 mg/ml','product_size'=>'100ml', 'product_unit'=>'Vial','product_category_id'=> 1),
            array('product_code'=>'G01004','product_name'=>'etamine Injection IP 10 mg/ml','product_description'=>'etamine Injection IP 10 mg/ml','product_size'=>'2ml', 'product_unit'=>'Vial','product_category_id'=> 1),
            array('product_code'=>'G01005','product_name'=>'Nitrous Oxide Inhalation','product_description'=>'Nitrous Oxide Inhalation','product_size'=>'100 ml', 'product_unit'=>'Bottle','product_category_id'=> 1),
            array('product_code'=>'G01006','product_name'=>'Oxygen Inhalation','product_description'=>'Oxygen Inhalation','product_size'=>'', 'product_unit'=>'Bottle','product_category_id'=> 1),
            array('product_code'=>'G01007','product_name'=>'Acetylsalicyclic Acid','product_description'=>'Acetylsalicyclic Acid','product_size'=>'325 mg', 'product_unit'=>'','product_category_id'=> 2),
            array('product_code'=>'G01008','product_name'=>'Paracetamol','product_description'=>'Paracetamol','product_size'=>'500 mg', 'product_unit'=>'','product_category_id'=> 2),
            array('product_code'=>'G01009','product_name'=>'BetaPyn','product_description'=>'Relieves head, neck and shoulder tension pain','product_size'=>'18 Tables', 'product_unit'=>'Box','product_category_id'=> 2),
            array('product_code'=>'G01010','product_name'=>'Lenapain','product_description'=>'Relieves pain associated with tension','product_size'=>'18 Tables', 'product_unit'=>'Box','product_category_id'=> 2),
        );

        foreach ($products as $product)
        {
            Product::create($product);
        }
    }
}
