<?php

use Illuminate\Database\Seeder;

class SecurityQuestionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('security_questions')->delete();
        
        \DB::table('security_questions')->insert(array (
            0 => 
            array (
                'id' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
                'question_id' => 1,
                'answer' => 'Jurek',
                'student_id' => 1,
            ),
            1 => 
            array (
                'id' => 2,
                'created_at' => NULL,
                'updated_at' => NULL,
                'question_id' => 3,
                'answer' => 'Nie zadzieraj z fryzjerem',
                'student_id' => 3,
            ),
        ));
        
        
    }
}