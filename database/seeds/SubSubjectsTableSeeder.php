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
                'name' => 'Przykładowy pierwszy',
                'min_person' => 10,
                'max_person' => 25,
                'subject_id' => 1,
            ),
            1 =>
            array (
                'id' => 2,
                'created_at' => NULL,
                'updated_at' => NULL,
                'name' => 'Przykładowy drugi',
                'min_person' => 15,
                'max_person' => 20,
                'subject_id' => 1,
            ),
            2 =>
                array (
                    'id' => 3,
                    'created_at' => NULL,
                    'updated_at' => NULL,
                    'name' => 'Test pierwszy',
                    'min_person' => 15,
                    'max_person' => 20,
                    'subject_id' => 2,
                ),
            3 =>
                array (
                    'id' => 4,
                    'created_at' => NULL,
                    'updated_at' => NULL,
                    'name' => 'Test drugi',
                    'min_person' => 15,
                    'max_person' => 20,
                    'subject_id' => 2,
                ),
            4 =>
                array (
                    'id' => 5,
                    'created_at' => NULL,
                    'updated_at' => NULL,
                    'name' => 'opcja 1',
                    'min_person' => 15,
                    'max_person' => 20,
                    'subject_id' => 3,
                ),
            5 =>
                array (
                    'id' => 6,
                    'created_at' => NULL,
                    'updated_at' => NULL,
                    'name' => 'opcja 2',
                    'min_person' => 15,
                    'max_person' => 20,
                    'subject_id' => 3,
                ),
            6 =>
                array (
                    'id' => 7,
                    'created_at' => NULL,
                    'updated_at' => NULL,
                    'name' => 'zajecia 1',
                    'min_person' => 15,
                    'max_person' => 20,
                    'subject_id' => 4,
                ),
            7 =>
                array (
                    'id' => 8,
                    'created_at' => NULL,
                    'updated_at' => NULL,
                    'name' => 'zajecia 2',
                    'min_person' => 15,
                    'max_person' => 20,
                    'subject_id' => 4,
                ),
        ));


    }
}
