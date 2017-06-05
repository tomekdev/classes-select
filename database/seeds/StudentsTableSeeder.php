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
                'email' => 's89546@student.po.edu.pl',
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
                'updated_at' => NULL,
                'index' => 89545,
                'email' => 's89545@student.po.edu.pl',
                'name' => 'Mateusz',
                'surname' => 'Torbus',
                'password' => Hash::make('zaq12wsx'),
                'study_end' => 2018,
                'active' => 1,
            ),
            2 =>
            array (
                'id' => 3,
                'created_at' => NULL,
                'updated_at' => NULL,
                'index' => 89549,
                'email' => 's89549@student.po.edu.pl',
                'name' => 'Tomasz',
                'surname' => 'Wacławek',
                'password' => Hash::make('zaq12wsx'),
                'study_end' => 2018,
                'active' => 1,
            ),
            array (
                'id' => 4,
                'created_at' => NULL,
                'updated_at' => NULL,
                'index' => 89552,
                'email' => 's89552@student.po.edu.pl',
                'name' => 'Grzegorz',
                'surname' => 'Wróbel',
                'password' => Hash::make('zaq12wsx'),
                'study_end' => 2018,
                'active' => 1,
            ),
            array (
                'id' => 5,
                'created_at' => NULL,
                'updated_at' => NULL,
                'index' => 89543,
                'email' => 's89543@student.po.edu.pl',
                'name' => 'Patryk',
                'surname' => 'Śliwiński',
                'password' => Hash::make('zaq12wsx'),
                'study_end' => 2018,
                'active' => 1,
            ),
        ));


    }
}
