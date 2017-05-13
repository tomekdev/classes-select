<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentHasSubjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_has_subjects', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('student_id')->unsigned();
            $table->integer('subSubject_id')->unsigned();
            $table->boolean('active')->default(true);
        });

        Schema::table('student_has_subjects', function (Blueprint $table) {
            $table->foreign('student_id')
                ->references('id')
                ->on('students');
        });

        Schema::table('student_has_subjects', function (Blueprint $table) {
            $table->foreign('subSubject_id')
                ->references('id')
                ->on('sub_subjects');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_has_subjects');
    }
}
