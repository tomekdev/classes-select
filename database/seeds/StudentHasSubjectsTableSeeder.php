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

        ));


    }
}
