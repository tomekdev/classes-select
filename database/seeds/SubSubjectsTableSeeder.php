<?php

use Illuminate\Database\Seeder;

class SubSubjectsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('sub_subjects')->delete();
        
        \DB::table('sub_subjects')->insert(array (
            0 => 
            array (
                'id' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
                'name' => 'Teleinformatyka',
                'min_person' => 10,
                'max_person' => 25,
                'subject_id' => 1,
            ),
            1 => 
            array (
                'id' => 2,
                'created_at' => NULL,
                'updated_at' => NULL,
                'name' => 'Mikroprocesory',
                'min_person' => 15,
                'max_person' => 20,
                'subject_id' => 1,
            ),
            2 =>
                array (
                    'id' => 3,
                    'created_at' => NULL,
                    'updated_at' => NULL,
                    'name' => 'Biochemia',
                    'min_person' => 15,
                    'max_person' => 20,
                    'subject_id' => 2,
                ),
            4 =>
                array (
                    'id' => 4,
                    'created_at' => NULL,
                    'updated_at' => NULL,
                    'name' => 'Biomechanika',
                    'min_person' => 15,
                    'max_person' => 20,
                    'subject_id' => 2,
                ),
        ));
        
        
    }
}