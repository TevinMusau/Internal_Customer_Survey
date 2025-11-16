<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthManager;
use App\Http\Controllers\NewUserController;
use App\Http\Controllers\EditUserController;
use App\Http\Controllers\SurveysController;


Route::get('/', function () {
    return view('index');
})->name('home');

// -------------------------------- LOGIN ROUTES -------------------------------------------
Route::get('/login', [AuthManager::class, 'login'])->name('login');
Route::post('/login', [AuthManager::class, 'loginPost'])->name('login.post');

// -------------------------------- LOGOUT ROUTE ----------------------------------------------
Route::get('/logout', [AuthManager::class, 'logout'])->name('logout');


// -------------------------------- Dashboard Route -------------------------------------
Route::get('/dashboard/{id}', [DashboardController::class, 'dashboard'])->name('dashboard');
Route::get('/dashboard/{id}/new-user', [DashboardController::class, 'newUserPage'])->name('new.user');
Route::get('/dashboard/{admin_id}/{user_id}/delete-user', [DashboardController::class, 'deleteUser'])->name('delete.user');

// create new user route
Route::post('/dashboard/{id}/new-user', [NewUserController::class, 'createUser'])->name('createNewUser');

// edit user details
Route::get('/dashboard/{admin_id}/{user_id}/edit-user', [EditUserController::class, 'toEditPage'])->name('edit.user');
Route::post('/dashboard/{admin_id}/{user_id}/edit-user', [EditUserController::class, 'editDetails'])->name('edit.user.post');


// -------------------------- Surveys ----------------------
// Managing Partner Survey
Route::get('/dashboard/{user_id}/surveys/managing-partner-survey', [SurveysController::class, 'toManagingPartnerSurveyPage'])->name('mp.surveypage');
Route::get('/dashboard/{user_id}/surveys/managing-partner-survey/intro', [SurveysController::class, 'surveyStart'])->name('mp.survey.intro');
Route::get('/dashboard/{user_id}/surveys/managing-partner-survey/survey/p1', [SurveysController::class, 'managingPartnerSurvey'])->name('mp.survey.p1');
Route::post('/dashboard/{user_id}/surveys/managing-partner-survey/survey/p1', [SurveysController::class, 'managingPartnerSurveyStep1'])->name('mp.survey.p1.post');

Route::get('/dashboard/{user_id}/surveys/managing-partner-survey/survey/p2', [SurveysController::class, 'managingPartnerSurveyStep2'])->name('mp.survey.p2');
Route::post('/dashboard/{user_id}/surveys/managing-partner-survey/survey/p2', [SurveysController::class, 'managingPartnerSurveyStep2'])->name('mp.survey.p2.post');

Route::get('/dashboard/{user_id}/surveys/managing-partner-survey/survey/p2', [SurveysController::class, 'managingPartnerSurveyStep2'])->name('mp.survey.p2');
Route::post('/dashboard/{user_id}/surveys/managing-partner-survey/survey/p2', [SurveysController::class, 'managingPartnerSurveyStep2'])->name('mp.survey.p2.post');

Route::get('/dashboard/{user_id}/surveys/managing-partner-survey/survey/p3', [SurveysController::class, 'managingPartnerSurveyStep3'])->name('mp.survey.p3');
Route::post('/dashboard/{user_id}/surveys/managing-partner-survey/survey/p3', [SurveysController::class, 'managingPartnerSurveyStep3'])->name('mp.survey.p3.post');

// Staff Survey
Route::get('/dashboard/{user_id}/surveys/staff-survey', [SurveysController::class, 'toStaffSurveyPage'])->name('staff.surveypage');
Route::get('/dashboard/{user_id}/surveys/staff-survey/intro', [SurveysController::class, 'surveyStart'])->name('staff.survey.intro');

