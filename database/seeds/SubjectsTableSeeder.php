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
                'study_form_id' => 1,
                'degree_id' => 2,
                'semester_id' => 1,
                'field_id' => 1,
                'min_person' => 20,
                'max_person' => 60,
                'name' => 'Przedmiot Wybieralny I',
            ),
            1 => 
            array (
                'id' => 2,
                'created_at' => NULL,
                'updated_at' => NULL,
                'study_form_id' => 2,
                'degree_id' => 1,
                'semester_id' => 1,
                'field_id' => 1,
                'min_person' => 20,
                'max_person' => 55,
                'name' => 'Przedmiot Wybieralny II',
            ),
        ));
        
        
    }
}