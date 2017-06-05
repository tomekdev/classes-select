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
                'name' => 'Architektura',
                'faculty_id' => 1,
            ),
            1 =>
            array (
                'id' => 2,
                'created_at' => NULL,
                'updated_at' => NULL,
                'name' => 'Budownictwo',
                'faculty_id' => 1,
            ),
            2 =>
            array (
                'id' => 3,
                'created_at' => NULL,
                'updated_at' => NULL,
                'name' => 'Administracja',
                'faculty_id' => 2,
            ),
            3 =>
            array (
                'id' => 4,
                'created_at' => NULL,
                'updated_at' => NULL,
                'name' => 'Ekonomia',
                'faculty_id' => 2,
            ),
            4 =>
            array (
                'id' => 5,
                'created_at' => NULL,
                'updated_at' => NULL,
                'name' => 'Zarządzanie',
                'faculty_id' => 2,
            ),

            25 =>
                array (
                    'id' => 26,
                    'created_at' => NULL,
                    'updated_at' => NULL,
                    'name' => 'Brak kierunku',
                    'faculty_id' => 0,
                ),

            5 =>
            array (
                'id' => 6,
                'created_at' => NULL,
                'updated_at' => NULL,
                'name' => 'Automatyka i robotyka',
                'faculty_id' => 3,
            ),
            6 =>
            array (
                'id' => 7,
                'created_at' => NULL,
                'updated_at' => NULL,
                'name' => 'Elektronika przemysłowa',
                'faculty_id' => 3,
            ),
            7 =>
            array (
                'id' => 8,
                'created_at' => NULL,
                'updated_at' => NULL,
                'name' => 'Elektrotechnika',
                'faculty_id' => 3,
            ),
            8 =>
            array (
                'id' => 9,
                'created_at' => NULL,
                'updated_at' => NULL,
                'name' => 'Informatyka',
                'faculty_id' => 3,
            ),
            9 =>
            array (
                'id' => 10,
                'created_at' => NULL,
                'updated_at' => NULL,
                'name' => 'Inżynieria biomedyczna',
                'faculty_id' => 3,
            ),
            10 =>
            array (
                'id' => 11,
                'created_at' => NULL,
                'updated_at' => NULL,
                'name' => 'Technologie energii odnawialnej',
                'faculty_id' => 3,
            ),
            11 =>
            array (
                'id' => 12,
                'created_at' => NULL,
                'updated_at' => NULL,
                'name' => 'Inżynieria bezpieczeństwa',
                'faculty_id' => 4,
            ),
            12 =>
            array (
                'id' => 13,
                'created_at' => NULL,
                'updated_at' => NULL,
                'name' => 'Logistyka',
                'faculty_id' => 4,
            ),
            13 =>
            array (
                'id' => 14,
                'created_at' => NULL,
                'updated_at' => NULL,
                'name' => 'Technologia żywności i żywienie człowieka',
                'faculty_id' => 4,
            ),
            14 =>
            array (
                'id' => 15,
                'created_at' => NULL,
                'updated_at' => NULL,
                'name' => 'Zarządzanie i inżynieria produkcji',
                'faculty_id' => 4,
            ),
            15 =>
            array (
                'id' => 16,
                'created_at' => NULL,
                'updated_at' => NULL,
                'name' => 'Energetyka',
                'faculty_id' => 5,
            ),
            16 =>
            array (
                'id' => 17,
                'created_at' => NULL,
                'updated_at' => NULL,
                'name' => 'Inżynieria środowiska',
                'faculty_id' => 5,
            ),
            17 =>
            array (
                'id' => 18,
                'created_at' => NULL,
                'updated_at' => NULL,
                'name' => 'Mechanika i budowa maszyn',
                'faculty_id' => 5,
            ),
            18 =>
            array (
                'id' => 19,
                'created_at' => NULL,
                'updated_at' => NULL,
                'name' => 'Mechatronika',
                'faculty_id' => 5,
            ),
            19 =>
            array (
                'id' => 20,
                'created_at' => NULL,
                'updated_at' => NULL,
                'name' => 'Transport',
                'faculty_id' => 5,
            ),
            20 =>
            array (
                'id' => 21,
                'created_at' => NULL,
                'updated_at' => NULL,
                'name' => 'Fizjoterapia',
                'faculty_id' => 6,
            ),
            21 =>
            array (
                'id' => 22,
                'created_at' => NULL,
                'updated_at' => NULL,
                'name' => 'Turystyka i rekreacja',
                'faculty_id' => 6,
            ),
            22 =>
            array (
                'id' => 23,
                'created_at' => NULL,
                'updated_at' => NULL,
                'name' => 'Wychowanie fizyczne',
                'faculty_id' => 6,
            ),
            23 =>
            array (
                'id' => 24,
                'created_at' => NULL,
                'updated_at' => NULL,
                'name' => 'Przemysłowe technologie informatyczne',
                'faculty_id' => 7,
            ),
            24 =>
            array (
                'id' => 25,
                'created_at' => NULL,
                'updated_at' => NULL,
                'name' => 'Systemy biotechniczne',
                'faculty_id' => 7,
            ),
        ));
        $field = \App\Field::find(26);
        $field->id = 0;
        $field->save();
    }
}
