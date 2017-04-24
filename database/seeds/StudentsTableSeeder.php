<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class StudentsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        // '$2y$10$AvgEjI2.YO1fdrYqr0hsauGYam7vycRBnq5.LYytB2/Q6NGrecM5m' - zaq12wsx
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
                'password' => Hash::make('zaq12wsx'),
                'study_end' => 2018,
                'active' => 1,
            ),
            1 => 
            array (
                'id' => 2,
                'created_at' => NULL,
                'updated_at' => '2017-03-26 18:06:27',
                'index' => 89546,
                'email' => '89545@studet.po.edu.pl',
                'name' => 'Mateusz',
                'surname' => 'Trobus',
                'password' => Hash::make('zaq12wsx'),
                'study_end' => 2025,
                'active' => 1,
            ),
            2 => 
            array (
                'id' => 3,
                'created_at' => NULL,
                'updated_at' => NULL,
                'index' => 89534,
                'email' => '89534@student.po.edu.pl',
                'name' => 'Jan',
                'surname' => 'Kowalski',
                'password' => Hash::make('zaq12wsx'),
                'study_end' => 2018,
                'active' => 1,
            ),
        ));
        
        
    }
}