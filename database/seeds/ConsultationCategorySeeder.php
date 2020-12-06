<?php

use App\Models\Consultation;
use App\Models\ConsultationCategory;
use Illuminate\Database\Seeder;

class ConsultationCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = array(
            array('name'=>"GENETIC"),
            array('name'=>"MUSCLE AGING"),
            array('name'=>"OSTEOPOROSIS"),
            array('name'=>"BRAIN AGING"),
            array('name'=>"HEART AGING"),
            array('name'=>"CANCER RISK EVALUATION"),
            array('name'=>"SLEEP APNEA"),
            array('name'=>"WOMEN'S HEALTH"),
        );
        foreach ($categories as $category) {
            ConsultationCategory::create($category);
        }
        $consultations = array(
            array('consultation_category_id'=> 1, 'name' => 'Prenatal or Preconception Panels'),
            array('consultation_category_id'=> 1, 'name' => 'Wellness and Longevity Panel'),
            array('consultation_category_id'=> 1, 'name' => 'Carrier Screening Panel'),
            array('consultation_category_id'=> 2, 'name' => 'Muscle Loss'),
            array('consultation_category_id'=> 2, 'name' => 'Depression'),
            array('consultation_category_id'=> 2, 'name' => 'Hormone Decline'),
            array('consultation_category_id'=> 3, 'name' => 'Fractured Hip'),
            array('consultation_category_id'=> 3, 'name' => 'Fractured Arm'),
            array('consultation_category_id'=> 3, 'name' => 'Spinal Cord'),
            array('consultation_category_id'=> 4, 'name' => 'MRI'),
            array('consultation_category_id'=> 4, 'name' => 'Brain exercise'),
            array('consultation_category_id'=> 4, 'name' => 'Physical exercise for brain function'),
            array('consultation_category_id'=> 5, 'name' => 'Heart risk factor evaluation'),
            array('consultation_category_id'=> 5, 'name' => 'Genetic counselling and testing'),
            array('consultation_category_id'=> 6, 'name' => 'Targeted physical examination'),
            array('consultation_category_id'=> 6, 'name' => 'Supplement, medication and lifestyle advice'),
            array('consultation_category_id'=> 6, 'name' => 'Ultrasound'),
            array('consultation_category_id'=> 7, 'name' => 'Heart failure'),
            array('consultation_category_id'=> 7, 'name' => 'Heart rhythm disturbances'),
            array('consultation_category_id'=> 7, 'name' => 'Pulmonary hypertension'),
            array('consultation_category_id'=> 8, 'name' => 'Psychosocial evaluation'),
            array('consultation_category_id'=> 8, 'name' => 'Menopause evaluation'),
            array('consultation_category_id'=> 8, 'name' => 'Menopause evaluation'),
            array('consultation_category_id'=> 8, 'name' => 'Cognitive impairment and dementia'),
        );

        foreach ($consultations as $consultation) {
            Consultation::create($consultation);
        }
    }
}
