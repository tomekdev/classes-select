<?php

use Illuminate\Database\Seeder;

class DegreesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('degrees')->delete();

        \DB::table('degrees')->insert(array (
            0 =>
                array (
                    'id' => 1,
                    'created_at' => NULL,
                    'updated_at' => NULL,
                    'name' => 'Pierwszy',
                    'type' => 'Inżynier',
                ),
            1 =>
                array (
                    'id' => 2,
                    'created_at' => NULL,
                    'updated_at' => NULL,
                    'name' => 'Drugi',
                    'type' => 'Magister',
                ),
        ));
    }
}
