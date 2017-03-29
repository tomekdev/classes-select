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
                'start_date' => '2017-03-08',
                'finish_date' => '2017-03-31',
                'semester_id' => 1,
                'field_id' => 1,
            ),
            1 => 
            array (
                'id' => 2,
                'created_at' => NULL,
                'updated_at' => NULL,
                'min_average' => 4.5,
                'start_date' => '2017-03-04',
                'finish_date' => '2017-03-31',
                'semester_id' => 1,
                'field_id' => 1,
            ),
        ));
        
        
    }
}