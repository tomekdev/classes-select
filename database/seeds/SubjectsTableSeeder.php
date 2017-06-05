<?php

use Illuminate\Database\Seeder;

class SubjectsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('subjects')->delete();
        
        \DB::table('subjects')->insert(array (
            0 => 
            array (
                'id' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
                'study_form_id' => 2,
                'degree_id' => 1,
                'semester_id' => 1,
                'field_id' => 9,
                'name' => 'Przedmiot Wybieralny I',
            ),
            1 =>
                array (
                    'id' => 2,
                    'created_at' => NULL,
                    'updated_at' => NULL,
                    'study_form_id' => 1,
                    'degree_id' => 1,
                    'semester_id' => 2,
                    'field_id' => 9,
                    'name' => 'Przedmiot Wybieralny II',
                ),
            2 =>
                array (
                    'id' => 3,
                    'created_at' => NULL,
                    'updated_at' => NULL,
                    'study_form_id' => 1,
                    'degree_id' => 1,
                    'semester_id' => 3,
                    'field_id' => 9,
                    'name' => 'Przedmiot Wybieralny III',
                ),
            3 =>
            array (
                'id' => 4,
                'created_at' => NULL,
                'updated_at' => NULL,
                'study_form_id' => 1,
                'degree_id' => 1,
                'semester_id' => 1,
                'field_id' => 1,
                'name' => 'Przedmiot Wybieralny II',
            ),
        ));
        
        
    }
}