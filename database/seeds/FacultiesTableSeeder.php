<?php

use Illuminate\Database\Seeder;

class FacultiesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('faculties')->delete();
        
        \DB::table('faculties')->insert(array (
            0 => 
            array (
                'id' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
                'name' => 'Wydział Automatyki i Informatyki',
            ),
            1 => 
            array (
                'id' => 2,
                'created_at' => NULL,
                'updated_at' => NULL,
                'name' => 'XD',
            ),
        ));
        
        
    }
}