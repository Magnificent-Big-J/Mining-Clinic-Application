<?php

use App\Models\Screening;
use App\Models\ScreeningQuestionnaire;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class CovidSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $covids = array(
            array('name'=>'Have travelled to a high risk country in the last 14 days', 'screening_type_id' => 1, 'image_path' => 'questions/covid-19.jpeg'),
            array('name'=>'Have you had contact with anyone with confirmed COVID-19 in the last 14 days', 'screening_type_id' => 1, 'image_path' => 'questions/covid-19.jpeg'),
            array('name'=>'Do you have symptoms such as fever, cough and difficulty in breathing', 'screening_type_id' => 1, 'image_path' => 'questions/covid-19.jpeg'),
            array('name' => 'Experiencing any pain with your kidney?', 'screening_type_id' => 2, 'image_path' => 'questions/kidney.jpeg'),
            array('name' => 'Having digestion problem?', 'screening_type_id' => 2, 'image_path' => 'questions/digestion.jpg'),
            array('name' => 'Is your throat soar?', 'screening_type_id' => 2, 'image_path' => 'questions/throat.jpeg'),
        );

        foreach ($covids as $covid) {
            ScreeningQuestionnaire::create($covid);
        }
        $answers = array('Yes', 'No');

        $screenings = array(
            array('appointment_id' => 1, 'screening_questionnaire_id' => 1, 'screening_date' => Carbon::now(),'screening_answer' => $answers[rand(0,1)]),
            array('appointment_id' => 1, 'screening_questionnaire_id' => 2, 'screening_date' => Carbon::now(),'screening_answer' => $answers[rand(0,1)]),
            array('appointment_id' => 1, 'screening_questionnaire_id' => 3, 'screening_date' => Carbon::now(),'screening_answer' => $answers[rand(0,1)]),
            array('appointment_id' => 2, 'screening_questionnaire_id' => 1, 'screening_date' => Carbon::now(),'screening_answer' => $answers[rand(0,1)]),
            array('appointment_id' => 2, 'screening_questionnaire_id' => 2, 'screening_date' => Carbon::now(),'screening_answer' => $answers[rand(0,1)]),
            array('appointment_id' => 2, 'screening_questionnaire_id' => 3, 'screening_date' => Carbon::now(),'screening_answer' => $answers[rand(0,1)]),
            array('appointment_id' => 3, 'screening_questionnaire_id' => 1, 'screening_date' => Carbon::now(),'screening_answer' => $answers[rand(0,1)]),
            array('appointment_id' => 3, 'screening_questionnaire_id' => 2, 'screening_date' => Carbon::now(),'screening_answer' => $answers[rand(0,1)]),
            array('appointment_id' => 3, 'screening_questionnaire_id' => 3, 'screening_date' => Carbon::now(),'screening_answer' => $answers[rand(0,1)]),
            array('appointment_id' => 4, 'screening_questionnaire_id' => 1, 'screening_date' => Carbon::now(),'screening_answer' => $answers[rand(0,1)]),
            array('appointment_id' => 4, 'screening_questionnaire_id' => 2, 'screening_date' => Carbon::now(),'screening_answer' => $answers[rand(0,1)]),
            array('appointment_id' => 4, 'screening_questionnaire_id' => 3, 'screening_date' => Carbon::now(),'screening_answer' => $answers[rand(0,1)]),
            array('appointment_id' => 5, 'screening_questionnaire_id' => 1, 'screening_date' => Carbon::now(),'screening_answer' => $answers[rand(0,1)]),
            array('appointment_id' => 5, 'screening_questionnaire_id' => 2, 'screening_date' => Carbon::now(),'screening_answer' => $answers[rand(0,1)]),
            array('appointment_id' => 5, 'screening_questionnaire_id' => 3, 'screening_date' => Carbon::now(),'screening_answer' => $answers[rand(0,1)]),
            array('appointment_id' => 6, 'screening_questionnaire_id' => 1, 'screening_date' => Carbon::now(),'screening_answer' => $answers[rand(0,1)]),
            array('appointment_id' => 6, 'screening_questionnaire_id' => 2, 'screening_date' => Carbon::now(),'screening_answer' => $answers[rand(0,1)]),
            array('appointment_id' => 6, 'screening_questionnaire_id' => 3, 'screening_date' => Carbon::now(),'screening_answer' => $answers[rand(0,1)]),
            array('appointment_id' => 7, 'screening_questionnaire_id' => 1, 'screening_date' => Carbon::now(),'screening_answer' => $answers[rand(0,1)]),
            array('appointment_id' => 7, 'screening_questionnaire_id' => 2, 'screening_date' => Carbon::now(),'screening_answer' => $answers[rand(0,1)]),
            array('appointment_id' => 7, 'screening_questionnaire_id' => 3, 'screening_date' => Carbon::now(),'screening_answer' => $answers[rand(0,1)]),
            array('appointment_id' => 8, 'screening_questionnaire_id' => 1, 'screening_date' => Carbon::now(),'screening_answer' => $answers[rand(0,1)]),
            array('appointment_id' => 8, 'screening_questionnaire_id' => 2, 'screening_date' => Carbon::now(),'screening_answer' => $answers[rand(0,1)]),
            array('appointment_id' => 8, 'screening_questionnaire_id' => 3, 'screening_date' => Carbon::now(),'screening_answer' => $answers[rand(0,1)]),
            array('appointment_id' => 9, 'screening_questionnaire_id' => 1, 'screening_date' => Carbon::now(),'screening_answer' => $answers[rand(0,1)]),
            array('appointment_id' => 9, 'screening_questionnaire_id' => 2, 'screening_date' => Carbon::now(),'screening_answer' => $answers[rand(0,1)]),
            array('appointment_id' => 9, 'screening_questionnaire_id' => 3, 'screening_date' => Carbon::now(),'screening_answer' => $answers[rand(0,1)]),
        );

        foreach ($screenings as $screening) {
            Screening::create($screening);
        }


    }
}
