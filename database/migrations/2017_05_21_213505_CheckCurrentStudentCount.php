<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CheckCurrentStudentCount extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('
        CREATE TRIGGER `DeleteCheckSubSubjectCurrentPerson` BEFORE DELETE ON `student_has_subjects`
        FOR EACH ROW 
        BEGIN
            set @current_person = (select current_person from sub_subjects where id=old.subSubject_id);
            set @current_person = @current_person - 1;
            update sub_subjects set current_person=@current_person where id=old.subSubject_id;
        end
        ');

        DB::unprepared('
        CREATE TRIGGER `InsertCheckSubSubjectCurrentPerson` BEFORE INSERT ON `student_has_subjects`
        FOR EACH ROW 
        BEGIN
            set @current_person = (select current_person from sub_subjects where id=NEW.subSubject_id);
            set @max_person = (select max_person from sub_subjects where id=NEW.subSubject_id);
            if(@current_person >= @max_person) THEN
                SIGNAL SQLSTATE \'10000\' SET MESSAGE_TEXT = \'brak miejsc\';
            ELSE
                set @current_person = @current_person + 1;
                update sub_subjects set current_person=@current_person where id=new.subSubject_id;
            end if;
        end
        ');

        DB::unprepared('
        CREATE TRIGGER `UpdateCheckSubSubjectCurrentPerson` BEFORE UPDATE ON `student_has_subjects`
        FOR EACH ROW 
        BEGIN
            if(new.subSubject_id != old.subSubject_id) then
            set @current_person = (select current_person from sub_subjects where id=NEW.subSubject_id);
            set @max_person = (select max_person from sub_subjects where id=NEW.subSubject_id);
            if(@current_person >= @max_person) THEN
                SIGNAL SQLSTATE \'10000\' SET MESSAGE_TEXT = \'brak miejsc\';
            ELSE
                set @current_person = @current_person + 1;
                update sub_subjects set current_person=@current_person where 			id=new.subSubject_id;
                set @old_current_person = (select current_person from sub_subjects where id=old.subSubject_id);
                set @old_current_person = @old_current_person - 1;
               update sub_subjects set current_person=@old_current_person where 			id=old.subSubject_id;
            end if;
               end if;
        end
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP TRIGGER `DeleteCheckSubSubjectCurrentPerson`');
        DB::unprepared('DROP TRIGGER `InsertCheckSubSubjectCurrentPerson`');
        DB::unprepared('DROP TRIGGER `UpdateCheckSubSubjectCurrentPerson`');
    }
}
