<?php

use Illuminate\Database\Seeder;

class StudyFormSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('study_forms')->delete();

        \DB::table('study_forms')->insert(array (
            0 =>
                array (
                    'id' => 1,
                    'created_at' => NULL,
                    'updated_at' => NULL,
                    'name' => 'Stacjonarne',
                ),
            1 =>
                array (
                    'id' => 2,
                    'created_at' => NULL,
                    'updated_at' => NULL,
                    'name' => 'Niestacjonarne',
                ),
            2 =>
                array (
                    'id' => 3,
                    'created_at' => NULL,
                    'updated_at' => NULL,
                    'name' => 'Brak formy studiów',
                ),
        ));
        $studyForm = \App\StudyForm::find(3);
        $studyForm->id = 0;
        $studyForm->save();
    }
}
