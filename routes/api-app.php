<?php

use App\Http\Controllers\App\ArticleController;
use App\Http\Controllers\App\CategoryController;
use App\Http\Controllers\App\CountryController;
use App\Http\Controllers\App\FilterController;
use App\Http\Controllers\App\InstitutionController;
use App\Http\Controllers\App\IntakeController;
use App\Http\Controllers\App\LeadController;
use App\Http\Controllers\App\PermissionController;
use App\Http\Controllers\App\ProfileController;
use App\Http\Controllers\App\ProgramController;
use App\Http\Controllers\App\RecruiterController;
use App\Http\Controllers\App\ShortlistController;
use App\Http\Controllers\App\StaffController;
use App\Http\Controllers\App\StudentController;
use App\Http\Controllers\App\StudentDocumentController;
use App\Http\Controllers\App\StudentGuardianController;
use App\Http\Controllers\App\SubjectController;
use App\Http\Controllers\App\TeamController;
use App\Http\Controllers\ApplicationController;
use Illuminate\Support\Facades\Route;


// add middleware sanctum later
Route::prefix('app')
    ->group(function () {


        /**
         * Recruiter routes
         */
        Route::prefix('register')
            ->group(function () {

                Route::post('/', [RecruiterController::class, 'register']);
            });

        /**
         * Permission routes
         */
        Route::prefix('permission')
            ->group(function () {

                Route::get('/select', [PermissionController::class, 'getSelect']);
            });

        /**
         * Profile routes
         */
        Route::prefix('profile')
            ->group(function () {

                Route::get('/{id}', [ProfileController::class, 'index']);
                Route::put('/update', [ProfileController::class, 'update']);
                Route::put('/change-password', [ProfileController::class, 'changePassword']);
                Route::put('/image', [ProfileController::class, 'image']);
            });

        /**
         * Country routes
         */
        Route::prefix('country')
            ->group(function () {

                Route::get('/select', [CountryController::class, 'getSelect']);
                Route::get('/label', [CountryController::class, 'getLabel']);
            });

        /**
         * Team routes
         */
        Route::prefix('team')
            ->group(function () {

                Route::get('/', [TeamController::class, 'index']);
                Route::post('/store', [TeamController::class, 'store']);
                Route::put('/update', [TeamController::class, 'update']);
                Route::delete('/delete/{id}', [TeamController::class, 'delete']);
            });

        /**
         * Staff routes
         */
        Route::prefix('staff')
            ->group(function () {

                Route::get('/', [StaffController::class, 'index']);
                Route::get('/recruiters/{id}', [StaffController::class, 'getByRecruiter']);
                Route::get('/select', [StaffController::class, 'getSelect']);
                Route::get('/select/recruiters/{id}', [StaffController::class, 'getSelectByRecruiter']);
                Route::post('/store', [StaffController::class, 'store']);
                Route::put('/update', [StaffController::class, 'update']);
                Route::delete('/delete/{id}', [StaffController::class, 'delete']);
            });

        /**
         * Lead routes
         */
        Route::prefix('lead')
            ->group(function () {

                Route::get('/', [LeadController::class, 'index']);
                Route::get('/select', [LeadController::class, 'select']);
                Route::post('/store', [LeadController::class, 'store']);
                Route::put('/update', [LeadController::class, 'update']);
                Route::delete('/delete/{id}', [LeadController::class, 'delete']);
            });

        /**
         * Category routes
         */
        Route::prefix('category')
            ->group(function () {
                Route::get('/', [CategoryController::class, 'index']);
            });

        /**
         * Article routes
         */
        Route::prefix('article')
            ->group(function () {

                Route::get('/{category_id}', [ArticleController::class, 'index']);
            });

        /**
         * Institution routes
         */
        Route::prefix('institution')
            ->group(function () {

                Route::get('/', [InstitutionController::class, 'index']);
                Route::get('/get/{id}', [InstitutionController::class, 'show']);
                Route::get('/select', [InstitutionController::class, 'getSelect']);
            });

        /**
         * Subject routes
         */
        Route::prefix('subject')
            ->group(function () {

                Route::get('/', [SubjectController::class, 'index']);
                Route::get('/select', [SubjectController::class, 'getSelect']);
                Route::get('/label', [SubjectController::class, 'getLabel']);
            });

        /**
         * Intake routes
         */
        Route::prefix('intake')
            ->group(function () {

                Route::get('/', [IntakeController::class, 'index']);
                Route::get('/select', [IntakeController::class, 'getSelect']);
            });

        /**
         * Program routes
         */
        Route::prefix('program')
            ->group(function () {

                Route::get('/', [ProgramController::class, 'index']);
                Route::get('/get/{id}', [ProgramController::class, 'get']);
                Route::get('/select', [ProgramController::class, 'getSelect']);
            });

        /**
         * Student routes
         */
        Route::prefix('student')
            ->group(function () {

                Route::get('/', [StudentController::class, 'index']);
                Route::get('/get/{id}', [StudentController::class, 'show']);
                Route::get('/all-details/{id}', [StudentController::class, 'allDetails']);
                Route::get('/recruiters/{id}', [StudentController::class, 'getByRecruiterId']);
                Route::get('/recruiters/{id}/unassigned', [StudentController::class, 'getByRecruiterIdUnassigned']);
                Route::get('/recruiters/{id}/count', [StudentController::class, 'getApplicationPhaseCount']);
                Route::get('/recruiters/{id}/phase/{phase}', [StudentController::class, 'getByRecruiterIdAndPhase']);
                Route::post('/store', [StudentController::class, 'store']);
                Route::put('/update', [StudentController::class, 'update']);
                Route::put('/change-phase/{id}', [StudentController::class, 'changePhase']);
                Route::delete('/delete/{id}', [StudentController::class, 'delete']);


                Route::prefix('document')
                    ->group(function () {
                        Route::prefix('/mandatory')
                            ->group(function () {
                                Route::prefix('/{student_id}')
                                    ->group(function () {
                                        Route::get('/get', [StudentDocumentController::class, 'get']);
                                    });
                                Route::get('/show/{id}', [StudentDocumentController::class, 'show']);
//                                Route::post('/store', [StudentDocumentController::class, 'store']);
                                Route::post('/update', [StudentDocumentController::class, 'update']);
//                                Route::delete('/delete/{id}', [StudentDocumentController::class, 'delete']);
                            });

                        Route::prefix('/additional')
                            ->group(function () {
                                Route::prefix('/{student_id}')
                                    ->group(function () {
                                        Route::get('/get', [StudentDocumentController::class, 'getAdditional']);
                                    });
                                Route::get('/show/{id}', [StudentDocumentController::class, 'show']);
                                Route::post('/store', [StudentDocumentController::class, 'store']);
                                Route::post('/update', [StudentDocumentController::class, 'update']);
                                Route::delete('/delete/{id}', [StudentDocumentController::class, 'delete']);
                            });
                    });
            });

        Route::prefix('filter')
            ->group(function () {

                Route::get('/data', [FilterController::class, 'filters']);
                Route::get('/result', [FilterController::class, 'results']);
            });

        /**
         * Shortlist routes
         */
        Route::prefix('shortlist')
            ->group(function () {
                Route::get('/get/{id}', [ShortlistController::class, 'show']);
                Route::get('/get/{id}/details', [ShortlistController::class, 'showDetails']);
                Route::post('/store', [ShortlistController::class, 'store']);
                Route::put('/update', [ShortlistController::class, 'update']);
                Route::delete('/delete/{id}', [ShortlistController::class, 'delete']);
                Route::post('/delete/checked', [ShortlistController::class, 'deleteChecked']);
            });

        /**
         * Guardian routes
         */
        Route::prefix('guardians')
            ->group(function () {
                Route::delete('/delete/{id}', [StudentGuardianController::class, 'delete']);
            });

        /**
         * Education routes
         */
        Route::prefix('educations')
            ->group(function () {
                Route::delete('/delete/{id}', [StudentGuardianController::class, 'delete']);
            });


        /**
         * Application routes
         */
        Route::prefix('application')
            ->group(function () {

                Route::put('/apply', [ApplicationController::class, 'apply']);
            });

    });
