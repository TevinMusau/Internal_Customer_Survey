<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\QuestionCategoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthManager;
use App\Http\Controllers\NewUserController;
use App\Http\Controllers\EditUserController;
use App\Http\Controllers\SurveysController;
use App\Http\Controllers\QuestionsController;


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
Route::get('/dashboard/{user_id}/surveys/managing-partner-survey', [SurveysController::class, 'introToManagingPartnerSurvey'])->name('mp.survey.intro');
Route::get('/dashboard/{user_id}/surveys/managing-partner-survey/ratings_explained', [SurveysController::class, 'ratingsExplained'])->name('mp.survey.ratings_explained');

Route::get('/dashboard/{user_id}/surveys/managing-partner-survey/survey', [SurveysController::class, 'managingPartnerSurvey'])->name('mp.survey');
Route::post('/dashboard/{user_id}/surveys/managing-partner-survey/survey', [SurveysController::class, 'managingPartnerSurvey'])->name('mp.survey.post');

// Staff Survey
Route::get('/dashboard/{user_id}/surveys/staff-survey', [SurveysController::class, 'toStaffSurveyIntroPage'])->name('staffsurveypage.intro');
Route::get('/dashboard/{user_id}/surveys/staff-survey/ratings_explained', [SurveysController::class, 'ratingsExplained'])->name('staff.survey.ratings_explained');
Route::get('/dashboard/{user_id}/surveys/staff-survey/select_dept', [SurveysController::class, 'staffSurveySelectDepartments'])->name('staff.survey.departments');
Route::post('/dashboard/{user_id}/surveys/staff-survey/select_dept', [SurveysController::class, 'displaySurveyPerDepartment'])->name('display.staff.survey');


Route::post('/dashboard/{user_id}/q_category/create', [QuestionCategoryController::class, 'store'])->name('create.category');
Route::post('/dashboard/{user_id}/survey_question/create', [QuestionsController::class, 'store'])->name('create.question');
