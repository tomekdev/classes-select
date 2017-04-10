<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSecurityQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('security_questions', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('question_id')->unsigned();
            $table->string('answer');
            $table->integer('student_id')->unsigned();
            $table->boolean('active')->default(true);
        });

        Schema::table('security_questions', function (Blueprint $table) {
            $table->foreign('student_id')
                ->references('id')
                ->on('students');
        });

        Schema::table('security_questions', function (Blueprint $table) {
            $table->foreign('question_id')
                ->references('id')
                ->on('questions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('security_questions');
    }
}
