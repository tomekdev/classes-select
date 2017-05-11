<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTermsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('terms', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->float('min_average');
            $table->dateTime('start_date');
            $table->dateTime('finish_date');
            $table->integer('semester_id')->unsigned();
            $table->integer('field_id')->unsigned();
            $table->integer('degree_id')->unsigned();
            $table->integer('study_form_id')->unsigned();
            $table->boolean('active')->default(true);
        });

        Schema::table('terms', function (Blueprint $table) {
            $table->foreign('semester_id')
                ->references('id')
                ->on('semesters');
        });

        Schema::table('terms', function (Blueprint $table) {
            $table->foreign('field_id')
                ->references('id')
                ->on('fields');
        });

        Schema::table('terms', function (Blueprint $table) {
            $table->foreign('degree_id')
                ->references('id')
                ->on('degrees');
        });

        Schema::table('terms', function (Blueprint $table) {
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
        Schema::dropIfExists('terms');
    }
}
