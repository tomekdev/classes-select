<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('admins')->delete();

        \DB::table('admins')->insert(array (
                0 =>
                    array (
                        'id' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                        'name' => 'imie',
                        'surname' => 'nazwisko',
                        'login' => 'admin',
                        'password' => Hash::make('zaq12wsx'),
                    ),
            ));



    }
}
