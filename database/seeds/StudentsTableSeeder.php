<?php

use Illuminate\Database\Seeder;

class StudentsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('students')->delete();
        
        \DB::table('students')->insert(array (
            0 => 
            array (
                'id' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
                'index' => 89546,
                'email' => '89546@student.po.edu.pl',
                'name' => 'Patryk',
                'surname' => 'Trompeta',
                'password' => '$$2y$10$bAKvU0yzRvsWHNy/QAvJLexi.XP8M8EJu/gOVYW.wyxsz1Pw.WqC2',
                'average' => 3.0,
                'study_end' => 2018,
                'active' => 1,
            ),
            1 => 
            array (
                'id' => 3,
                'created_at' => NULL,
                'updated_at' => '2017-03-26 18:06:27',
                'index' => 89546,
                'email' => '89545@studet.po.edu.pl',
                'name' => 'Mateusz',
                'surname' => 'Trobus',
                'password' => '$2y$10$AvgEjI2.YO1fdrYqr0hsauGYam7vycRBnq5.LYytB2/Q6NGrecM5m',
                'average' => 3.2000000000000002,
                'study_end' => 2025,
                'active' => 1,
            ),
            2 => 
            array (
                'id' => 4,
                'created_at' => NULL,
                'updated_at' => '2017-03-28 14:43:17',
                'index' => 89534,
                'email' => '89534@student.po.edu.pl',
                'name' => 'Jan',
                'surname' => 'Kowalsi',
                'password' => '$$2y$10$bAKvU0yzRvsWHNy/QAvJLexi.XP8M8EJu/gOVYW.wyxsz1Pw.WqC2',
                'average' => 4.9000000000000004,
                'study_end' => 2018,
                'active' => 0,
            ),
        ));
        
        
    }
}