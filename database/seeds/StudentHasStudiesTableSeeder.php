<?php

use Illuminate\Database\Seeder;

class StudentHasStudiesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('student_has_studies')->delete();
        
        \DB::table('student_has_studies')->insert(array (
            0 => 
            array (
                'id' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
                'student_id' => 1,
                'field_id' => 1,
                'semester_id' => 1,
            ),
            1 => 
            array (
                'id' => 2,
                'created_at' => NULL,
                'updated_at' => NULL,
                'student_id' => 3,
                'field_id' => 1,
                'semester_id' => 2,
            ),
            2 => 
            array (
                'id' => 3,
                'created_at' => NULL,
                'updated_at' => NULL,
                'student_id' => 3,
                'field_id' => 3,
                'semester_id' => 3,
            ),
        ));
        
        
    }
}