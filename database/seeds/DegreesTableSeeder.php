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
                    'name' => 'Pierwszy',
                    'type' => 'Licencjat',
                ),
            2 =>
                array (
                        'id' => 3,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                        'name' => 'Drugi',
                        'type' => 'Magister',
                ),

            3 =>
                array (
                    'id' => 5,
                    'created_at' => NULL,
                    'updated_at' => NULL,
                    'name' => 'Brak stopnia',
                    'type' => '',
                ),
            4 =>
                array (
                        'id' => 4,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                        'name' => 'Trzeci',
                        'type' => 'Doktor',
                ),
        ));
        $degree = \App\Degree::find(5);
        $degree->id = 0;
        $degree->save();
    }
}
