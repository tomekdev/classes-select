<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subjects', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('study_form_id')->unsigned();
            $table->integer('degree_id')->unsigned();
            $table->integer('semester_id')->unsigned();;
            $table->integer('field_id')->unsigned();;
            $table->string('name');
            $table->boolean('active')->default(true);
        });

        Schema::table('subjects', function (Blueprint $table) {
            $table->foreign('semester_id')
                ->references('id')
                ->on('semesters');
        });

        Schema::table('subjects', function (Blueprint $table) {
            $table->foreign('field_id')
                ->references('id')
                ->on('fields');
        });

        Schema::table('subjects', function (Blueprint $table) {
            $table->foreign('study_form_id')
                ->references('id')
                ->on('study_forms');
        });

        Schema::table('subjects', function (Blueprint $table) {
            $table->foreign('degree_id')
                ->references('id')
                ->on('degrees');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subjects');
    }
}
