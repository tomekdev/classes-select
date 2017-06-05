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
                'name' => 'Wydział Budownictwa i Architektury',
            ),
            1 =>
            array (
                'id' => 2,
                'created_at' => NULL,
                'updated_at' => NULL,
                'name' => 'Wydział Ekonomii i Zarządzania',
            ),
            2 =>
            array (
                'id' => 3,
                'created_at' => NULL,
                'updated_at' => NULL,
                'name' => 'Wydział Elektrotechniki Automatyki i Informatyki',
            ),
            3 =>
            array (
                'id' => 4,
                'created_at' => NULL,
                'updated_at' => NULL,
                'name' => 'Wydział Inżynierii Produkcji i Logistyki',
            ),
            4 =>
            array (
                'id' => 5,
                'created_at' => NULL,
                'updated_at' => NULL,
                'name' => 'Wydział Mechaniczny',
            ),
            5 =>
            array (
                'id' => 6,
                'created_at' => NULL,
                'updated_at' => NULL,
                'name' => 'Wydział Wychowania Fizycznego i Fizjoterapii',
            ),
            6 =>
            array (
                'id' => 7,
                'created_at' => NULL,
                'updated_at' => NULL,
                'name' => 'Wydział Inżynierii Systemów Technicznych',
            ),

            7 =>
                array (
                    'id' => 8,
                    'created_at' => NULL,
                    'updated_at' => NULL,
                    'name' => 'Brak wydziału',
                ),
        ));
        $faculty = \App\Faculty::find(8);
        $faculty->id = 0;
        $faculty->save();

    }
}
