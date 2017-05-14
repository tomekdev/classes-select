<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call(StudyFormSeeder::class);
        $this->call(DegreesTableSeeder::class);
        $this->call(AdminsTableSeeder::class);
        $this->call(StudentsTableSeeder::class);
        $this->call(FacultiesTableSeeder::class);
        $this->call(SemestersTableSeeder::class);
        $this->call(FieldsTableSeeder::class);
        $this->call(SubjectsTableSeeder::class);
        $this->call(SubSubjectsTableSeeder::class);
        $this->call(StudentHasStudiesTableSeeder::class);
        $this->call(QuestionsTableSeeder::class);
        $this->call(SecurityQuestionsTableSeeder::class);
        $this->call(StudentHasSubjectsTableSeeder::class);
        $this->call(TermsTableSeeder::class);
    }
}
