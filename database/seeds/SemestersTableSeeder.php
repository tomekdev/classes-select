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
                'number' => 2,
            ),
            1 =>
            array (
                'id' => 2,
                'created_at' => NULL,
                'updated_at' => NULL,
                'name' => 'Letni 2016/2017',
                'number' => 4,
            ),
            2 =>
            array (
                'id' => 3,
                'created_at' => NULL,
                'updated_at' => NULL,
                'name' => 'Letni 2016/2017',
                'number' => 6,
            ),
            3 =>
            array (
                'id' => 4,
                'created_at' => NULL,
                'updated_at' => NULL,
                'name' => 'Letni 2016/2017',
                'number' => 8,
            ),
            4 =>
            array (
                'id' => 5,
                'created_at' => NULL,
                'updated_at' => NULL,
                'name' => 'Letni 2016/2017',
                'number' => 10,
            ),
            5 =>
            array (
                'id' => 6,
                'created_at' => NULL,
                'updated_at' => NULL,
                'name' => 'Letni 2017/2018',
                'number' => 2,
            ),
            6 =>
            array (
                'id' => 7,
                'created_at' => NULL,
                'updated_at' => NULL,
                'name' => 'Letni 2017/2018',
                'number' => 4,
            ),
            7 =>
            array (
                'id' => 8,
                'created_at' => NULL,
                'updated_at' => NULL,
                'name' => 'Letni 2017/2018',
                'number' => 6,
            ),
            8 =>
            array (
                'id' => 9,
                'created_at' => NULL,
                'updated_at' => NULL,
                'name' => 'Letni 2017/2018',
                'number' => 8,
            ),
            9 =>
            array (
                'id' => 10,
                'created_at' => NULL,
                'updated_at' => NULL,
                'name' => 'Letni 2017/2018',
                'number' => 10,
            ),
            10 =>
            array (
                'id' => 11,
                'created_at' => NULL,
                'updated_at' => NULL,
                'name' => 'Zimowy 2016/2017',
                'number' => 1,
            ),
            11 =>
            array (
                'id' => 12,
                'created_at' => NULL,
                'updated_at' => NULL,
                'name' => 'Zimowy 2016/2017',
                'number' => 3,
            ),
            12 =>
            array (
                'id' => 13,
                'created_at' => NULL,
                'updated_at' => NULL,
                'name' => 'Zimowy 2016/2017',
                'number' => 5,
            ),
            13 =>
            array (
                'id' => 14,
                'created_at' => NULL,
                'updated_at' => NULL,
                'name' => 'Zimowy 2016/2017',
                'number' => 7,
            ),
            14 =>
            array (
                'id' => 15,
                'created_at' => NULL,
                'updated_at' => NULL,
                'name' => 'Zimowy 2016/2017',
                'number' => 9,
            ),
            15 =>
            array (
                'id' => 16,
                'created_at' => NULL,
                'updated_at' => NULL,
                'name' => 'Zimowy 2017/2018',
                'number' => 1,
            ),
            16 =>
            array (
                'id' => 17,
                'created_at' => NULL,
                'updated_at' => NULL,
                'name' => 'Zimowy 2017/2018',
                'number' => 3,
            ),
            17 =>
            array (
                'id' => 18,
                'created_at' => NULL,
                'updated_at' => NULL,
                'name' => 'Zimowy 2017/2018',
                'number' => 5,
            ),
            18 =>
            array (
                'id' => 19,
                'created_at' => NULL,
                'updated_at' => NULL,
                'name' => 'Zimowy 2017/2018',
                'number' => 7,
            ),
            19 =>
            array (
                'id' => 20,
                'created_at' => NULL,
                'updated_at' => NULL,
                'name' => 'Zimowy 2017/2018',
                'number' => 9,
            ),
        ));


    }
}
