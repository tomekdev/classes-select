<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/************ STUDENT ROUTES ************/

Route::get('/', [
    'uses' => 'Student\StudentController@welcome',
    'as' => 'student.welcome',
]);

Route::post('/login', [
    'uses' => 'Student\StudentController@login',
    'as' => 'student.login'
]);

Route::get('/resetpassword/{token}', [
    'uses' => 'Student\StudentController@resetPassword',
    'as' => 'student.resetPassword'
]);

Route::post('/resetpassword/{token}', [
    'uses' => 'Student\StudentController@resetPassword',
    'as' => 'student.resetPassword'
]);

Route::get('/resetpassword', function(){
    return view('student.resetPassword',['firstTime' => false]);
})->name('student.showResetPasswordForm');

Route::get('/welcome', function(){
    return view('student.resetPassword',['firstTime' => true]);
})->name('student.firstTimeLogin');

Route::post('/sendresettoken{firstTime?}', [
    'uses' => 'Student\StudentController@sendResetToken',
    'as' => 'student.sendToken'
]);

Route::group([
    'middleware' => ['student'],
], function()
{
    /************AJAX********************/

    Route::post('/save/subject', [
        'uses' => 'Student\AjaxController@saveSubject',
        'as' => 'student.ajaxSaveSubject'
    ]);

    Route::post('/logout', [
        'uses' => 'Student\StudentController@logout',
        'as' => 'student.logout'
    ]);

    Route::get('/dashboard', [
        'uses' => 'Student\SubjectController@index',
        'as' => 'student.dashboard',
    ]);
    
    Route::get('/changepassword', function(){
        return view('student.changePassword');
    });

    Route::post('/changepassword', [
        'uses' => 'Student\StudentController@changePassword',
        'as' => 'student.changePassword'
    ]);
});

/************* ADMIN ROUTES ************/

    // ------ Admins ------
    Route::get('admin/', [
        'uses' => 'Admin\AdminController@welcome',
        'as' => 'admin.welcome',
    ]);

    Route::post('admin/login', [
        'uses' => 'Admin\AdminController@login',
        'as' => 'admin.login'
    ]);

    Route::post('admin/delstudents', [
        'uses' => 'Admin\StudentController@deleteStudents',
        'as' => 'admin.deletestudents'
    ]);

    Route::group([
        'middleware' => ['admin'],
        'prefix' => 'admin'
    ], function() {

        /************AJAX********************/

        Route::get('/getFieldsFromFaculty/{id?}', [
            'uses' => 'Admin\AjaxController@getFieldsFromFaculty',
            'as' => 'admin.ajaxGetFields',
        ])->where('id', '[0-9]+');

        /*******User related actions**********/

        Route::post('/logout', [
            'uses' => 'Admin\AdminController@logout',
            'as' => 'admin.logout'
        ]);
        
        Route::get('/changepassword', function(){
            return view('admin.changePassword');
        });

        Route::post('/changepassword', [
            'uses' => 'Admin\AdminController@changePassword',
            'as' => 'admin.changePassword'
        ]);
        
        Route::get('/configuration', [
            'uses' => 'Admin\AdminController@getConfiguration',
            'as' => 'admin.configuration'
        ]);
        
        Route::post('/configuration', [
            'uses' => 'Admin\AdminController@saveConfiguration',
            'as' => 'admin.configuration'
        ]);

        /***********Students***************/
        Route::post('/import/students/', [
           'uses' => 'Admin\StudentController@importStudents',
            'as' => 'admin.importStudents'
        ]);


        Route::post('/import/append/students/', [
            'uses' => 'Admin\StudentController@appendStudents',
            'as' => 'admin.appendStudents'
        ]);

        Route::post('/import/overwrite/students/', [
            'uses' => 'Admin\StudentController@overwriteStudents',
            'as' => 'admin.overwriteStudents'
        ]);

        Route::post('/import/averages/', [
            'uses' => 'Admin\StudentController@importAverages',
            'as' => 'admin.importAverages'
        ]);

        Route::post('/import/append/averages/', [
            'uses' => 'Admin\StudentController@appendAverages',
            'as' => 'admin.appendAverages'
        ]);
        
        Route::get('/students/subject/{subjectId?}', [
            'uses' => 'Admin\StudentController@index',
            'as' => 'admin.studentsWithSubject'
        ]);
        
        Route::get('/students/subsubject/{subSubjectId?}', [
            'uses' => 'Admin\StudentController@index',
            'as' => 'admin.studentsWithSubSubject'
        ]);

        Route::get('/students', [
            'uses' => 'Admin\StudentController@index',
            'as' => 'admin.students'
        ]);
        
        Route::post('/students/subject/{subjectId?}', [
            'uses' => 'Admin\StudentController@index',
            'as' => 'admin.studentsWithSubject'
        ]);
        
        Route::post('/students/subsubject/{subSubjectId?}', [
            'uses' => 'Admin\StudentController@index',
            'as' => 'admin.studentsWithSubSubject'
        ]);

        Route::post('/students', [
            'uses' => 'Admin\StudentController@index',
            'as' => 'admin.students'
        ]);

        Route::get('/student/{id?}', [
            'uses' => 'Admin\StudentController@getStudentForm',
            'as' => 'admin.getstudent'
        ])->where('id', '[0-9]+');

        Route::post('/student/{id?}', [
            'uses' => 'Admin\StudentController@saveStudent',
            'as' => 'admin.savestudent'
        ])->where('id', '[0-9]+');


        Route::delete('/student/{id?}', [ // zmienione na znak zapytania
            'uses' => 'Admin\StudentController@deletestudent',
            'as' => 'admin.deletestudent'
        ])->where('id', '[0-9]+');
        
        Route::delete('/student/{id}/restore', [
            'uses' => 'Admin\StudentController@restoreStudent',
            'as' => 'admin.restoreStudent'
        ])->where('id', '[0-9]+');


        Route::post('/changeStudyAll', [ // zmienione na znak zapytania
            'uses' => 'Admin\StudentController@changeStudyAll',
            'as' => 'admin.changeStudyAll'
        ])->where('id', '[0-9]+');

        /***********Faculty***************/

        Route::get('/faculties', [
            'uses' => 'Admin\FacultyController@index',
            'as' => 'admin.faculties'
        ]);

        Route::post('/faculties', [
            'uses' => 'Admin\FacultyController@index',
            'as' => 'admin.faculties'
        ]);

        Route::get('/faculty/{id?}', [
            'uses' => 'Admin\FacultyController@getFacultyForm',
            'as' => 'admin.getfaculty'
        ])->where('id', '[0-9]+');

        Route::post('/faculty/{id?}', [
            'uses' => 'Admin\FacultyController@saveFaculty',
            'as' => 'admin.savefaculty'
        ])->where('id', '[0-9]+');

        Route::delete('/faculty/{id?}', [
            'uses' => 'Admin\FacultyController@deleteFaculty',
            'as' => 'admin.deletefaculty'
        ])->where('id', '[0-9]+');
        
        Route::delete('/faculty/{id}/restore', [
            'uses' => 'Admin\FacultyController@restoreFaculty',
            'as' => 'admin.restoreFaculty'
        ])->where('id', '[0-9]+');

        /***********Fields***************/

        Route::get('/fields', [
            'uses' => 'Admin\FieldController@index',
            'as' => 'admin.fields'
        ]);

        Route::post('/fields', [
            'uses' => 'Admin\FieldController@index',
            'as' => 'admin.fields'
        ]);

        Route::get('/field/{id?}', [
            'uses' => 'Admin\FieldController@getFieldForm',
            'as' => 'admin.getfield'
        ])->where('id', '[0-9]+');

        Route::post('/field/{id?}', [
            'uses' => 'Admin\FieldController@saveField',
            'as' => 'admin.savefield'
        ])->where('id', '[0-9]+');

        Route::delete('/field/{id?}', [
            'uses' => 'Admin\FieldController@deleteField',
            'as' => 'admin.deletefield'
        ])->where('id', '[0-9]+');
        
        Route::delete('/field/{id}/restore', [
            'uses' => 'Admin\FieldController@restoreField',
            'as' => 'admin.restoreField'
        ])->where('id', '[0-9]+');

        /***********Semesters***************/

        Route::get('/semesters', [
            'uses' => 'Admin\SemesterController@index',
            'as' => 'admin.semesters'
        ]);

        Route::post('/semesters', [
            'uses' => 'Admin\SemesterController@index',
            'as' => 'admin.semesters'
        ]);

        Route::get('/semester/{id?}', [
            'uses' => 'Admin\SemesterController@getSemesterForm',
            'as' => 'admin.getSemester'
        ])->where('id', '[0-9]+');

        Route::post('/semester/{id?}', [
            'uses' => 'Admin\SemesterController@saveSemester',
            'as' => 'admin.saveSemester'
        ])->where('id', '[0-9]+');

        Route::delete('/semester/{id?}', [
            'uses' => 'Admin\SemesterController@deleteSemester',
            'as' => 'admin.deleteSemester'
        ])->where('id', '[0-9]+');
        
        Route::delete('/semester/{id}/restore', [
            'uses' => 'Admin\SemesterController@restoreSemester',
            'as' => 'admin.restoreSemester'
        ])->where('id', '[0-9]+');

        /***********Degrees***************/

        Route::get('/degrees', [
            'uses' => 'Admin\DegreeController@index',
            'as' => 'admin.degrees'
        ]);

        Route::post('/degrees', [
            'uses' => 'Admin\DegreeController@index',
            'as' => 'admin.degrees'
        ]);

        Route::get('/degree/{id?}', [
            'uses' => 'Admin\DegreeController@getDegreeForm',
            'as' => 'admin.getDegree'
        ])->where('id', '[0-9]+');

        Route::post('/degree/{id?}', [
            'uses' => 'Admin\DegreeController@saveDegree',
            'as' => 'admin.saveDegree'
        ])->where('id', '[0-9]+');

        Route::delete('/degree/{id?}', [
            'uses' => 'Admin\DegreeController@deleteDegree',
            'as' => 'admin.deleteDegree'
        ])->where('id', '[0-9]+');
        
        Route::delete('/degree/{id}/restore', [
            'uses' => 'Admin\DegreeController@restoreDegree',
            'as' => 'admin.restoreDegree'
        ])->where('id', '[0-9]+');

        /***********Study_Form***************/

        Route::get('/studyForms', [
            'uses' => 'Admin\StudyFormController@index',
            'as' => 'admin.studyForms'
        ]);

        Route::post('/studyForms', [
            'uses' => 'Admin\StudyFormController@index',
            'as' => 'admin.studyForms'
        ]);

        Route::get('/studyForm/{id?}', [
            'uses' => 'Admin\StudyFormController@getStudyFormFrom',
            'as' => 'admin.getStudyForm'
        ])->where('id', '[0-9]+');

        Route::post('/studyForm/{id?}', [
            'uses' => 'Admin\StudyFormController@saveStudyForm',
            'as' => 'admin.saveStudyForm'
        ])->where('id', '[0-9]+');

        Route::delete('/studyForm/{id?}', [
            'uses' => 'Admin\StudyFormController@deleteStudyForm',
            'as' => 'admin.deleteStudyForm'
        ])->where('id', '[0-9]+');
        
        Route::delete('/studyForm/{id}/restore', [
            'uses' => 'Admin\StudyFormController@restoreStudyForm',
            'as' => 'admin.restoreStudyForm'
        ])->where('id', '[0-9]+');

        /***********Subject***************/

        Route::get('/subjects', [
            'uses' => 'Admin\SubjectController@index',
            'as' => 'admin.subjects'
        ]);

        Route::post('/subjects', [
            'uses' => 'Admin\SubjectController@index',
            'as' => 'admin.subjects'
        ]);

        Route::get('/subject/{id?}', [
            'uses' => 'Admin\SubjectController@getSubjectFrom',
            'as' => 'admin.getSubject'
        ])->where('id', '[0-9]+');

        Route::post('/subject/{id?}', [
            'uses' => 'Admin\SubjectController@saveSubject',
            'as' => 'admin.saveSubject'
        ])->where('id', '[0-9]+');

        Route::delete('/subject/{id?}', [
            'uses' => 'Admin\SubjectController@deleteSubject',
            'as' => 'admin.deleteSubject'
        ])->where('id', '[0-9]+');

        Route::delete('/subject/{id?}/restore', [
            'uses' => 'Admin\SubjectController@restoreSubject',
            'as' => 'admin.restoreSubject'
        ])->where('id', '[0-9]+');
        
        /***********Terms***************/

        Route::get('/terms', [
            'uses' => 'Admin\TermController@index',
            'as' => 'admin.terms'
        ]);

        Route::post('/terms', [
            'uses' => 'Admin\TermController@index',
            'as' => 'admin.terms'
        ]);

        Route::get('/term/{id?}', [
            'uses' => 'Admin\TermController@getTermFrom',
            'as' => 'admin.getTerm'
        ])->where('id', '[0-9]+');

        Route::post('/term/{id?}', [
            'uses' => 'Admin\TermController@saveTerm',
            'as' => 'admin.saveTerm'
        ])->where('id', '[0-9]+');

        Route::delete('/term/{id?}', [
            'uses' => 'Admin\TermController@deleteTerm',
            'as' => 'admin.deleteTerm'
        ])->where('id', '[0-9]+');

        Route::delete('/term/{id?}/restore', [
            'uses' => 'Admin\TermController@restoreTerm',
            'as' => 'admin.restoreTerm'
        ])->where('id', '[0-9]+');
        
        Route::any('/term/{id}/remind', [
            'uses' => 'Admin\TermController@sendTermReminders',
            'as' => 'admin.sendTermReminders'
        ])->where('id', '[0-9]+');
    });

// to jest strefa dla Mateusza i Grzesia do testowania pojedynczych widoków. Proszę tu nie grzebać, poza nimi dwoma
// Oni są panami tej strefy i tu może być szyf taki jaki zrobią, Poźniej to im skasujemy.
//-------------------------------------------------------------------------------------------------------------------------


    Route::group(['prefix' => 'testowanie'], function() {

        Route::get('/sb', function() {
            return view('student.selectableSubject');
        });

        Route::get('/importstudents', function() {
            return view('admin.importstudents');
        });
    });
//-------------------------------------------------------------------------------------------------------------------------


