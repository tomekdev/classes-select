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
                'name' => 'Wydział Fizjoterapii',
            ),

            2 =>
                array (
                    'id' => 3,
                    'created_at' => NULL,
                    'updated_at' => NULL,
                    'name' => 'Brak wydziału',
                ),
        ));
        $faculty = \App\Faculty::find(3);
        $faculty->id = 0;
        $faculty->save();
        
        
    }
}