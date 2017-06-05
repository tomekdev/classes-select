<?php

use Illuminate\Database\Seeder;

class FieldsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('fields')->delete();
        
        \DB::table('fields')->insert(array (
            0 => 
            array (
                'id' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
                'name' => 'Informatyka',
                'faculty_id' => 1,
            ),
            1 => 
            array (
                'id' => 2,
                'created_at' => NULL,
                'updated_at' => NULL,
                'name' => 'Automatyka',
                'faculty_id' => 1,
            ),
            2 => 
            array (
                'id' => 3,
                'created_at' => NULL,
                'updated_at' => NULL,
                'name' => 'Biologia',
                'faculty_id' => 2,
            ),
            3 =>
                array (
                    'id' => 4,
                    'created_at' => NULL,
                    'updated_at' => NULL,
                    'name' => 'Brak kierunku',
                    'faculty_id' => 0,
                ),
        ));
        $field = \App\Field::find(4);
        $field->id = 0;
        $field->save();
        
        
    }
}