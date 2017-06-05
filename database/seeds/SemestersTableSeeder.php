<?php

use Illuminate\Database\Seeder;

class SemestersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('semesters')->delete();
        
        \DB::table('semesters')->insert(array (
            0 => 
            array (
                'id' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
                'name' => 'Letni 2016/2017',
                'number' => 1,
            ),
            1 => 
            array (
                'id' => 2,
                'created_at' => NULL,
                'updated_at' => NULL,
                'name' => 'Zimowy 2017/2018',
                'number' => 2,
            ),
            2 => 
            array (
                'id' => 3,
                'created_at' => NULL,
                'updated_at' => NULL,
                'name' => 'Letni 2017/2018',
                'number' => 3,
            ),
            3 => 
            array (
                'id' => 4,
                'created_at' => NULL,
                'updated_at' => NULL,
                'name' => 'Zimowy 2018/2019',
                'number' => 4,
            ),
            4 =>
                array (
                    'id' => 5,
                    'created_at' => NULL,
                    'updated_at' => NULL,
                    'name' => 'Brak semestru',
                    'number' => 0,
                ),
        ));
        $semester = \App\Semester::find(5);
        $semester->id = 0;
        $semester->save();
        
        
    }
}