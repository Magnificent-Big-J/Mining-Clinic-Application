<?php

use App\Models\DocumentType;
use Illuminate\Database\Seeder;

class DocumentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = array(
            array('name'=> 'Prescriptions'),
            array('name'=> 'X-Rays'),
        );

        foreach ($types as $type) {
            DocumentType::create($type);
        }
    }
}
