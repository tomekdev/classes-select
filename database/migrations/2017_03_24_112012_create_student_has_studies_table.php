<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentHasStudiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_has_studies', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('student_id')->unsigned();
            $table->integer('field_id')->unsigned();
            $table->integer('semester_id')->unsigned();
            $table->integer('degree_id')->unsigned();
            $table->integer('study_form_id')->unsigned();
            $table->float('average')->nullable();
            $table->boolean('active')->default(true);
        });

        Schema::table('student_has_studies', function (Blueprint $table) {
            $table->foreign('student_id')
                ->references('id')
                ->on('students');
        });

        Schema::table('student_has_studies', function (Blueprint $table) {
            $table->foreign('field_id')
                ->references('id')
                ->on('fields');
        });

        Schema::table('student_has_studies', function (Blueprint $table) {
            $table->foreign('semester_id')
                ->references('id')
                ->on('semesters');
        });

        Schema::table('student_has_studies', function (Blueprint $table) {
            $table->foreign('degree_id')
                ->references('id')
                ->on('degrees');
        });

        Schema::table('student_has_studies', function (Blueprint $table) {
            $table->foreign('study_form_id')
                ->references('id')
                ->on('study_forms');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_has_studies');
    }
}
