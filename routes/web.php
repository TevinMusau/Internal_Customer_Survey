<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\QuestionCategoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthManager;
use App\Http\Controllers\NewUserController;
use App\Http\Controllers\EditUserController;
use App\Http\Controllers\SurveysController;
use App\Http\Controllers\QuestionsController;
use App\Http\Controllers\DepartmentController;

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


// questions routes
Route::get('/dashboard/{survey_question_id}/{user_id}/edit-question', [QuestionsController::class, 'toEditQuestionPage'])->name('edit.question');
Route::post('/dashboard/{survey_question_id}/{user_id}/edit-question', [QuestionsController::class, 'editQuestionDetails'])->name('edit.user.post');
Route::get('/dashboard/{survey_question_id}/{user_id}/delete-question', [QuestionsController::class, 'deleteQuestion'])->name('delete.question');


// -------------------------- Surveys ----------------------
// Managing Partner Survey
Route::get('/dashboard/{user_id}/surveys/managing-partner-survey', [SurveysController::class, 'introToManagingPartnerSurvey'])->name('mp.survey.intro');
Route::get('/dashboard/{user_id}/surveys/managing-partner-survey/ratings_explained', [SurveysController::class, 'ratingsExplained'])->name('mp.survey.ratings_explained');

Route::get('/dashboard/{user_id}/surveys/managing-partner-survey/survey', [SurveysController::class, 'managingPartnerSurvey'])->name('mp.survey');
Route::post('/dashboard/{user_id}/surveys/managing-partner-survey/survey', [SurveysController::class, 'managingPartnerSurvey'])->name('mp.survey.post');
Route::post('/dashboard/{user_id}/surveys/managing-partner-survey/submit', [SurveysController::class, 'submitManagingPartnerSurvey'])->name('submit.managingpartner.survey');

// Staff Survey
Route::get('/dashboard/{user_id}/surveys/staff-survey', [SurveysController::class, 'toStaffSurveyIntroPage'])->name('staffsurveypage.intro');
Route::get('/dashboard/{user_id}/surveys/staff-survey/ratings_explained', [SurveysController::class, 'ratingsExplained'])->name('staff.survey.ratings_explained');
Route::get('/dashboard/{user_id}/surveys/staff-survey/select_dept', [SurveysController::class, 'staffSurveySelectDepartments'])->name('staff.survey.departments');
Route::post('/dashboard/{user_id}/surveys/staff-survey/select_dept', [SurveysController::class, 'displaySurveyPerDepartment'])->name('display.staff.survey');
Route::post('/dashboard/{user_id}/{department_id}/surveys/staff-survey/submit', [SurveysController::class, 'submitStaffSurvey'])->name('submit.staff.survey');

// Supervisor Survey
Route::get('/dashboard/{user_id}/surveys/supervisor-survey', [SurveysController::class, 'toSupervisorSurveyIntroPage'])->name('supervisorsurveypage.intro');
Route::get('/dashboard/{user_id}/surveys/supervisor-survey/ratings_explained', [SurveysController::class, 'ratingsExplained'])->name('supervisor.survey.ratings_explained');
Route::get('/dashboard/{user_id}/surveys/supervisor-survey/select_supervisor', [SurveysController::class, 'supervisorSurveySelectSupervisor'])->name('supervisor.survey.supervisors');
Route::post('/dashboard/{user_id}/surveys/supervisor-survey/select_supervisor', [SurveysController::class, 'displaySupervisorSurvey'])->name('display.supervisor.survey');
Route::post('/dashboard/{user_id}/{supervisor_id}/surveys/supervisor-survey/submit', [SurveysController::class, 'submitSupervisorSurvey'])->name('submit.supervisor.survey');


Route::post('/dashboard/{user_id}/q_category/create', [QuestionCategoryController::class, 'store'])->name('create.category');
Route::post('/dashboard/{user_id}/survey_question/create', [QuestionsController::class, 'store'])->name('create.question');

// department routes
Route::get('/dashboard/{admin_id}/departments/', [DashboardController::class, 'toNewDepartmentPage'])->name('view.departments');
Route::post('/dashboard/{admin_id}/departments/', [DepartmentController::class, 'createNewDepartment'])->name('create.department');

Route::get('/dashboard/{admin_id}/{department_id}/edit-department', [DepartmentController::class, 'toEditDepartmentPage'])->name('edit.department');
Route::post('/dashboard/{admin_id}/{department_id}/edit-department', [DepartmentController::class, 'editDepartment'])->name('edit.department.post');

Route::get('/dashboard/{admin_id}/{department_id}/delete-department', [DepartmentController::class, 'deleteDepartment'])->name('delete.department');

