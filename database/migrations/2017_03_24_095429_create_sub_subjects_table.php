<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubSubjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_subjects', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->boolean('active')->default(true);
            $table->integer('subject_id')->unsigned();
            $table->integer('min_person');
            $table->integer('max_person');
            $table->integer('current_person')->nullable()->default(0);
            $table->timestamps();
        });

        Schema::table('sub_subjects', function (Blueprint $table) {
            $table->foreign('subject_id')
                ->references('id')
                ->on('subjects');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sub_subjects');
    }
}
