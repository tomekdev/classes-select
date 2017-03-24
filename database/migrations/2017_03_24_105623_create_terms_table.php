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
            $table->date('start_date');
            $table->date('finish_date');
            $table->integer('semester_id')->unsigned();;
            $table->integer('field_id')->unsigned();;
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
