<?php

use App\Http\Controllers\CommentsController;
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

Route::get('/test', function () {
    return view('newdashboard');
});


// -------------------------------- LOGIN ROUTES -------------------------------------------
Route::get('/login', [AuthManager::class, 'login'])->name('login');
Route::post('/login', [AuthManager::class, 'loginPost'])->name('login.post');

// forgot password Route
Route::post('/forgotpassword', [AuthManager::class, 'sendResetLink'])->name('reset.link');
Route::get('/reset-password/{token}', [AuthManager::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [AuthManager::class, 'resetPassword'])->name('password.update');


// -------------------------------- LOGOUT ROUTE ----------------------------------------------
Route::get('/logout', [AuthManager::class, 'logout'])->name('logout');


// -------------------------------- Dashboard Routes -------------------------------------
// to dashboard
Route::get('/dashboard/{id}', [DashboardController::class, 'dashboard'])->name('dashboard');

// ---- USER ROUTES -----
// view all users
Route::get('/dashboard/{id}/allusers', [DashboardController::class, 'viewAllUsers'])->name('view.allusers');
// filters for view all users table
Route::get('/dashboard/{id}/allusers', [DashboardController::class, 'viewAllUsers'])->name('view.allusers');
// edit user details
Route::get('/dashboard/{admin_id}/{user_id}/edit-user', [EditUserController::class, 'toEditPage'])->name('edit.user');
Route::post('/dashboard/{admin_id}/{user_id}/edit-user', [EditUserController::class, 'editDetails'])->name('edit.user.post');
//delete user
Route::get('/dashboard/{admin_id}/{user_id}/delete-user', [DashboardController::class, 'deleteUser'])->name('delete.user');
// create new user
Route::get('/dashboard/{id}/new-user', [DashboardController::class, 'newUserPage'])->name('new.user');
Route::post('/dashboard/{id}/new-user', [NewUserController::class, 'createUser'])->name('createNewUser');

// ---- ADMIN ROUTES -----
// view all admins
Route::get('/dashboard/{id}/alladmins', [DashboardController::class, 'viewAllAdmins'])->name('view.alladmins');

// ---- DEPARTMENT ROUTES ----

// view all departments
Route::get('/dashboard/{id}/alldepartments', [DashboardController::class, 'viewAllDepartments'])->name('view.alldepartments');
// to new department page
Route::get('/dashboard/{admin_id}/departments/', [DashboardController::class, 'toNewDepartmentPage'])->name('view.departments');
// create new department
Route::post('/dashboard/{admin_id}/departments/', [DepartmentController::class, 'createNewDepartment'])->name('create.department');
// to edit department page
Route::get('/dashboard/{admin_id}/{department_id}/edit-department', [DepartmentController::class, 'toEditDepartmentPage'])->name('edit.department');
// edit department
Route::post('/dashboard/{admin_id}/{department_id}/edit-department', [DepartmentController::class, 'editDepartment'])->name('edit.department.post');
// delete department
Route::get('/dashboard/{admin_id}/{department_id}/delete-department', [DepartmentController::class, 'deleteDepartment'])->name('delete.department');

// ---- LAUNCH SURVEY ROUTES ----
// to schedule survey page
Route::get('/dashboard/{user_id}/schedule-survey', [SurveysController::class, 'toScheduleSurveyPage'])->name('schedule.survey.page');
// schedule survey
Route::post('/dashboard/{user_id}/schedule-survey', [SurveysController::class, 'scheduleSurvey'])->name('schedule.survey');
// edit scheduled survey
Route::post('/dashboard/{scheduled_survey_id}/{user_id}/edit-scheduled-survey', [SurveysController::class, 'editScheduledSurvey'])->name('edit.scheduled.survey');


// ---- SURVEY ROUTES ----
// to view all surveys page
Route::get('/dashboard/{user_id}/all-survey', [SurveysController::class, 'viewAllSurveys'])->name('view.surveys');

// ---- QUESTION ROUTES ----
// to survey questions page
Route::get('/dashboard/{user_id}/all-survey-questions', [SurveysController::class, 'viewAllSurveyQuestions'])->name('survey.questions');

// SURVEY RESPONDENTS ROUTES
Route::get('/dashboard/{user_id}/all-survey-respondents', [SurveysController::class, 'viewSurveyRespondents'])->name('survey.respondents');

// COMMENTS ROUTES
Route::get('/dashboard/{user_id}/all-comments', [CommentsController::class, 'viewAllComments'])->name('view.allcomments');
Route::post('/dashboard/{user_id}/all-comments', [CommentsController::class, 'createNewComment'])->name('new.comment');













// questions routes
Route::get('/dashboard/{survey_question_id}/{user_id}/edit-question', [QuestionsController::class, 'toEditQuestionPage'])->name('edit.question');
Route::post('/dashboard/{survey_question_id}/{user_id}/edit-question', [QuestionsController::class, 'editQuestionDetails'])->name('edit.question.post');
Route::get('/dashboard/{survey_question_id}/{user_id}/delete-question', [QuestionsController::class, 'deleteQuestion'])->name('delete.question');

// comment routes
Route::get('/dashboard/{comment_id}/{user_id}/edit-comment', [CommentsController::class, 'toEditCommentPage'])->name('edit.comment');
Route::post('/dashboard/{comment_id}/{user_id}/edit-comment', [CommentsController::class, 'editCommentDetails'])->name('edit.comment.post');
Route::get('/dashboard/{comment_id}/{user_id}/delete-comment', [CommentsController::class, 'deleteComment'])->name('delete.comment');




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

