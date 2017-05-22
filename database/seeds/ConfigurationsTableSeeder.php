<?php

use Illuminate\Database\Seeder;

class ConfigurationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('configurations')->delete();

        \DB::table('configurations')->insert(array (
                0 =>
                    array (
                        'id' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                        'mail_host' => 'smtp.gmail.com',
                        'mail_port' => 587,
                        'mail_username' => 'kokodzambo2014@gmail.com',
                        'mail_password' => 'informatyka2014',
                        'mail_encryption' => 'tls',
                        'mail_from_name' => 'Pieseł'
                    )
            ));
    }
}
