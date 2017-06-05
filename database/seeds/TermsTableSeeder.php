<?php

use Illuminate\Database\Seeder;

class TermsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('terms')->delete();
        
        \DB::table('terms')->insert(array (
            0 => 
            array (
                'id' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
                'min_average' => 4.9000000000000004,
                'start_date' => '2017-07-04',
                'finish_date' => '2017-07-31',
                'semester_id' => 1,
                'field_id' => 9,
                'degree_id' => 1,
                'study_form_id' => 1,
            ),
            1 => 
            array (
                'id' => 2,
                'created_at' => NULL,
                'updated_at' => NULL,
                'min_average' => 4.5,
                'start_date' => '2017-07-08',
                'finish_date' => '2017-07-31',
                'semester_id' => 1,
                'field_id' => 9,
                'degree_id' => 1,
                'study_form_id' => 1,
            ),

        ));
        
        
    }
}