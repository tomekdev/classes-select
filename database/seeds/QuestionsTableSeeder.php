<?php

use Illuminate\Database\Seeder;

class QuestionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('questions')->delete();
        
        \DB::table('questions')->insert(array (
            0 => 
            array (
                'id' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
                'question' => 'Imię Twojego psa',
            ),
            1 => 
            array (
                'id' => 2,
                'created_at' => NULL,
                'updated_at' => NULL,
                'question' => 'Nazwa Twojej pierwszej szkoły',
            ),
            2 => 
            array (
                'id' => 3,
                'created_at' => NULL,
                'updated_at' => NULL,
                'question' => 'Twój ulubiony film',
            ),
        ));
        
        
    }
}