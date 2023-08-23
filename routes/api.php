<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'auth:api'], function () {
    Route::group(['prefix' => 'user'], function () {
        Route::get('list',[App\Http\Controllers\API\UserController::class,'index']);
        Route::get('all',[App\Http\Controllers\API\UserController::class,'index_all']);
        Route::get('all-available-teacher/{id}/{schedule_id}',[App\Http\Controllers\API\UserController::class,'index_all_available_teacher']);
        Route::post('create',[App\Http\Controllers\API\UserController::class,'store']);
        Route::put('update/{id}',[App\Http\Controllers\API\UserController::class,'update']);
        Route::delete('delete/{id}',[App\Http\Controllers\API\UserController::class,'destroy']);
    });
    Route::group(['prefix' => 'permission'], function () {
        Route::get('list',[App\Http\Controllers\API\PermissionController::class,'index']);
        Route::get('all',[App\Http\Controllers\API\PermissionController::class,'index_all']);
        Route::post('create',[App\Http\Controllers\API\PermissionController::class,'store']);
        Route::put('update/{id}',[App\Http\Controllers\API\PermissionController::class,'update']);
        Route::delete('delete/{id}',[App\Http\Controllers\API\PermissionController::class,'destroy']);
    });
    Route::group(['prefix' => 'role'], function () {
        Route::get('list',[App\Http\Controllers\API\RoleController::class,'index']);
        Route::get('all',[App\Http\Controllers\API\RoleController::class,'index_all']);
        Route::post('create',[App\Http\Controllers\API\RoleController::class,'store']);
        Route::put('update/{id}',[App\Http\Controllers\API\RoleController::class,'update']);
        Route::delete('delete/{id}',[App\Http\Controllers\API\RoleController::class,'destroy']);
    });
    Route::group(['prefix' => 'registrar'], function () {
        Route::get('list',[App\Http\Controllers\API\RegistrarController::class,'index']);
        Route::get('all',[App\Http\Controllers\API\RegistrarController::class,'index_all']);
        Route::post('create',[App\Http\Controllers\API\RegistrarController::class,'store']);
        Route::put('update/{id}',[App\Http\Controllers\API\RegistrarController::class,'update']);
        Route::delete('delete/{id}',[App\Http\Controllers\API\RegistrarController::class,'destroy']);
    });
    Route::group(['prefix' => 'program'], function () {
        Route::get('list',[App\Http\Controllers\API\ProgramController::class,'index']);
        Route::get('all',[App\Http\Controllers\API\ProgramController::class,'index_all']);
        Route::post('create',[App\Http\Controllers\API\ProgramController::class,'store']);
        Route::put('update/{id}',[App\Http\Controllers\API\ProgramController::class,'update']);
        Route::delete('delete/{id}',[App\Http\Controllers\API\ProgramController::class,'destroy']);
    });
    Route::group(['prefix' => 'major'], function () {
        Route::get('list',[App\Http\Controllers\API\MajorController::class,'index']);
        Route::get('all',[App\Http\Controllers\API\MajorController::class,'index_all']);
        Route::get('all/{id}',[App\Http\Controllers\API\MajorController::class,'index_all_not_in']);
        Route::post('create',[App\Http\Controllers\API\MajorController::class,'store']);
        Route::put('update/{id}',[App\Http\Controllers\API\MajorController::class,'update']);
        Route::delete('delete/{id}',[App\Http\Controllers\API\MajorController::class,'destroy']);
    });
    Route::group(['prefix' => 'subject'], function () {
        Route::get('list',[App\Http\Controllers\API\SubjectController::class,'index']);
        Route::get('all',[App\Http\Controllers\API\SubjectController::class,'index_all']);
        Route::get('all-by-level/{level}',[App\Http\Controllers\API\SubjectController::class,'index_all_by_level']);
        Route::post('create',[App\Http\Controllers\API\SubjectController::class,'store']);
        Route::put('update/{id}',[App\Http\Controllers\API\SubjectController::class,'update']);
        Route::delete('delete/{id}',[App\Http\Controllers\API\SubjectController::class,'destroy']);
    });
    Route::group(['prefix' => 'section'], function () {
        Route::get('list',[App\Http\Controllers\API\SectionController::class,'index']);
        Route::get('all',[App\Http\Controllers\API\SectionController::class,'index_all']);
        Route::get('all/{level}',[App\Http\Controllers\API\SectionController::class,'index_all_level']);
        Route::post('create',[App\Http\Controllers\API\SectionController::class,'store']);
        Route::put('update/{id}',[App\Http\Controllers\API\SectionController::class,'update']);
        Route::delete('delete/{id}',[App\Http\Controllers\API\SectionController::class,'destroy']);
    });
    Route::group(['prefix' => 'schedule'], function () {
        Route::get('list',[App\Http\Controllers\API\ScheduleController::class,'index']);
        Route::get('search',[App\Http\Controllers\API\ScheduleController::class,'index_search_schedule']);
        Route::get('teacher',[App\Http\Controllers\API\ScheduleController::class,'index_schedule']);
        Route::get('all',[App\Http\Controllers\API\ScheduleController::class,'index_all']);
        Route::post('create',[App\Http\Controllers\API\ScheduleController::class,'store']);
        Route::put('update/{id}',[App\Http\Controllers\API\ScheduleController::class,'update']);
        Route::delete('delete/{id}',[App\Http\Controllers\API\ScheduleController::class,'destroy']);
    });
    Route::group(['prefix' => 'level-subject'], function () {
        Route::get('list',[App\Http\Controllers\API\LevelHasSubjectController::class,'index']);
        Route::get('all',[App\Http\Controllers\API\LevelHasSubjectController::class,'index_all']);
        Route::get('set-level-subject/{level}',[App\Http\Controllers\API\LevelHasSubjectController::class,'set_level_subjects']);
        Route::post('create',[App\Http\Controllers\API\LevelHasSubjectController::class,'store']);
        Route::put('update/{id}',[App\Http\Controllers\API\LevelHasSubjectController::class,'update']);
        Route::delete('delete/{id}',[App\Http\Controllers\API\LevelHasSubjectController::class,'destroy']);
    });
    Route::group(['prefix' => 'substitution'], function () {
        Route::get('list',[App\Http\Controllers\API\SubstitutionController::class,'index']);
        Route::get('all',[App\Http\Controllers\API\SubstitutionController::class,'index_all']);
        Route::post('create',[App\Http\Controllers\API\SubstitutionController::class,'store']);
        Route::put('update/{id}',[App\Http\Controllers\API\SubstitutionController::class,'update']);
        Route::delete('delete/{id}',[App\Http\Controllers\API\SubstitutionController::class,'destroy']);
        Route::get('/substitution-print-report-api/{id}',[App\Http\Controllers\API\SubstitutionController::class,'print_report']);

    });
    Route::group(['prefix' => 'settings'], function () {
        Route::get('index-school-year',[App\Http\Controllers\API\SettingController::class,'index_school_year']);
        Route::put('update-school-year/{id}',[App\Http\Controllers\API\SettingController::class,'update_school_year']);
        Route::get('index-schedule-encoding',[App\Http\Controllers\API\SettingController::class,'index_schedule_encoding']);
        Route::put('update-schedule-encoding/{id}',[App\Http\Controllers\API\SettingController::class,'update_schedule_encoding']);
        Route::get('period-schedule-encoding',[App\Http\Controllers\API\SettingController::class,'period_schedule_encoding']);
        Route::get('index-principal',[App\Http\Controllers\API\SettingController::class,'index_principal']);
        Route::put('update-principal/{id}',[App\Http\Controllers\API\SettingController::class,'update_principal']);
        Route::get('index-school-name',[App\Http\Controllers\API\SettingController::class,'index_school_name']);
        Route::put('update-school-name/{id}',[App\Http\Controllers\API\SettingController::class,'update_school_name']);
        Route::get('index-short-school-name',[App\Http\Controllers\API\SettingController::class,'index_short_school_name']);
        Route::put('update-short-school-name/{id}',[App\Http\Controllers\API\SettingController::class,'update_short_school_name']);
        Route::get('index-school-logo',[App\Http\Controllers\API\SettingController::class,'index_school_logo']);
        Route::post('update-school-logo',[App\Http\Controllers\API\SettingController::class,'update_school_logo']);
        Route::get('reset-substitute-status',[App\Http\Controllers\API\SettingController::class,'reset_substitute_status']);
        Route::post('update-profile-image',[App\Http\Controllers\API\SettingController::class,'update_profile_image']);
    });
    Route::group(['prefix' => 'teacher-load'], function () {
        Route::get('list',[App\Http\Controllers\API\TeacherLoadController::class,'index']);
        Route::get('loads/{id}',[App\Http\Controllers\API\TeacherLoadController::class,'show']);
    });
});




