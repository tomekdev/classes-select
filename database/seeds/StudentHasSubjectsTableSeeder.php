<?php

use Illuminate\Database\Seeder;

class StudentHasSubjectsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('student_has_subjects')->delete();
        
        \DB::table('student_has_subjects')->insert(array (
            0 => 
            array (
                'id' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
                'student_id' => 2,
                'subSubject_id' => 1,
            ),
            1 => 
            array (
                'id' => 2,
                'created_at' => NULL,
                'updated_at' => NULL,
                'student_id' => 2,
                'subSubject_id' => 3,
            ),
        ));
        
        
    }
}