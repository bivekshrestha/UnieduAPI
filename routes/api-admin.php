<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\CandidateController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CountryController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\InstitutionController;
use App\Http\Controllers\Admin\IntakeController;
use App\Http\Controllers\Admin\LeadController;
use App\Http\Controllers\Admin\OfficeController;
use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\ProgramController;
use App\Http\Controllers\Admin\RecruiterController;
use App\Http\Controllers\Admin\RegionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\Admin\VacancyController;
use Illuminate\Support\Facades\Route;

// add middleware sanctum later
Route::prefix('admin')
    ->group(function () {

        Route::get('', [AdminController::class, 'index']);
        Route::post('store', [AdminController::class, 'store']);
        Route::put('update', [AdminController::class, 'update']);
        Route::delete('delete/{id}', [AdminController::class, 'delete']);

        /**
         * Role routes
         */
        Route::prefix('role')
            ->group(function () {

                Route::get('/', [RoleController::class, 'index']);
                Route::get('/select', [RoleController::class, 'getSelect']);
                Route::post('/store', [RoleController::class, 'store']);
                Route::put('/update', [RoleController::class, 'update']);
                Route::delete('/delete/{id}', [RoleController::class, 'delete']);
            });

        /**
         * Settings routes
         */
        Route::prefix('setting')
            ->group(function () {

                Route::get('/', [SettingController::class, 'index']);
                Route::post('/store', [SettingController::class, 'store']);
                Route::post('/image', [SettingController::class, 'image']);
                Route::put('/update', [SettingController::class, 'update']);
                Route::delete('/delete/{id}', [SettingController::class, 'delete']);
            });

        /**
         * Role routes
         */
        Route::prefix('profile')
            ->group(function () {

                Route::get('/{id}', [ProfileController::class, 'index']);
                Route::put('/update', [ProfileController::class, 'update']);
                Route::put('/change-password', [ProfileController::class, 'changePassword']);
                Route::put('/image', [ProfileController::class, 'image']);
            });


        /**
         * Posts routes
         */
        Route::prefix('post')
            ->group(function () {

                Route::get('/', [PostController::class, 'index']);
                Route::post('/store', [PostController::class, 'store']);
                Route::put('/update', [PostController::class, 'update']);
                Route::delete('/delete/{id}', [PostController::class, 'delete']);
            });

        /**
         * Region routes
         */
        Route::prefix('region')
            ->group(function () {

                Route::get('/', [RegionController::class, 'index']);
                Route::post('/store', [RegionController::class, 'store']);
                Route::put('/update', [RegionController::class, 'update']);
                Route::delete('/delete/{id}', [RegionController::class, 'delete']);
                Route::put('/link-countries', [RegionController::class, 'linkCountries']);
            });

        /**
         * Country routes
         */
        Route::prefix('country')
            ->group(function () {

                Route::get('/', [CountryController::class, 'index']);
                Route::get('/select', [CountryController::class, 'getSelect']);
                Route::get('/label', [CountryController::class, 'getLabel']);
                Route::post('/store', [CountryController::class, 'store']);
                Route::put('/update', [CountryController::class, 'update']);
                Route::delete('/delete/{id}', [CountryController::class, 'delete']);
            });

        /**
         * Office routes
         */
        Route::prefix('office')
            ->group(function () {

                Route::get('/', [OfficeController::class, 'index']);
                Route::post('/store', [OfficeController::class, 'store']);
                Route::put('/update', [OfficeController::class, 'update']);
                Route::delete('/delete/{id}', [OfficeController::class, 'delete']);
            });

        /**
         * Employee routes
         */
        Route::prefix('employee')
            ->group(function () {

                Route::get('/', [EmployeeController::class, 'index']);
                Route::post('/store', [EmployeeController::class, 'store']);
                Route::put('/update', [EmployeeController::class, 'update']);
                Route::delete('/delete/{id}', [EmployeeController::class, 'delete']);
            });

        /**
         * Vacancy routes
         */
        Route::prefix('vacancy')
            ->group(function () {

                Route::get('/', [VacancyController::class, 'index']);
                Route::post('/store', [VacancyController::class, 'store']);
                Route::put('/update', [VacancyController::class, 'update']);
                Route::delete('/delete/{id}', [VacancyController::class, 'delete']);
            });

        /**
         * Candidate routes
         */
        Route::prefix('candidate')
            ->group(function () {

                Route::get('/', [CandidateController::class, 'index']);
                Route::post('/store', [CandidateController::class, 'store']);
                Route::put('/update', [CandidateController::class, 'update']);
                Route::delete('/delete/{id}', [CandidateController::class, 'delete']);
            });

        /**
         * Package routes
         */
        Route::prefix('package')
            ->group(function () {

                Route::get('/', [PackageController::class, 'index']);
                Route::post('/store', [PackageController::class, 'store']);
                Route::put('/update', [PackageController::class, 'update']);
                Route::delete('/delete/{id}', [PackageController::class, 'delete']);
            });

        /**
         * Category routes
         */
        Route::prefix('category')
            ->group(function () {

                Route::get('/', [CategoryController::class, 'index']);
                Route::get('/select', [CategoryController::class, 'getSelect']);
                Route::post('/store', [CategoryController::class, 'store']);
                Route::put('/update', [CategoryController::class, 'update']);
                Route::delete('/delete/{id}', [CategoryController::class, 'delete']);
            });

        /**
         * Article routes
         */
        Route::prefix('article')
            ->group(function () {

                Route::get('/', [ArticleController::class, 'index']);
                Route::post('/store', [ArticleController::class, 'store']);
                Route::put('/update', [ArticleController::class, 'update']);
                Route::delete('/delete/{id}', [ArticleController::class, 'delete']);
            });

        /**
         * Institution routes
         */
        Route::prefix('institution')
            ->group(function () {

                Route::get('/', [InstitutionController::class, 'index']);
                Route::get('/get/{id}', [InstitutionController::class, 'show']);
                Route::get('/select', [InstitutionController::class, 'getSelect']);
                Route::post('/store', [InstitutionController::class, 'store']);
                Route::put('/update', [InstitutionController::class, 'update']);
                Route::delete('/delete/{id}', [InstitutionController::class, 'delete']);
                Route::post('/file', [InstitutionController::class, 'file']);
            });

        /**
         * Subject routes
         */
        Route::prefix('subject')
            ->group(function () {

                Route::get('/', [SubjectController::class, 'index']);
                Route::get('/select', [SubjectController::class, 'getSelect']);
                Route::post('/store', [SubjectController::class, 'store']);
                Route::put('/update', [SubjectController::class, 'update']);
                Route::delete('/delete/{id}', [SubjectController::class, 'delete']);
            });

        /**
         * Intake routes
         */
        Route::prefix('intake')
            ->group(function () {

                Route::get('/', [IntakeController::class, 'index']);
                Route::get('/select', [IntakeController::class, 'getSelect']);
                Route::post('/store', [IntakeController::class, 'store']);
                Route::put('/update', [IntakeController::class, 'update']);
                Route::delete('/delete/{id}', [IntakeController::class, 'delete']);
            });

        /**
         * Program routes
         */
        Route::prefix('program')
            ->group(function () {

                Route::get('/', [ProgramController::class, 'index']);
                Route::get('/get/{id}', [ProgramController::class, 'get']);
                Route::get('/select', [ProgramController::class, 'getSelect']);
                Route::post('/store', [ProgramController::class, 'store']);
                Route::post('/file', [ProgramController::class, 'file']);
                Route::put('/update', [ProgramController::class, 'update']);
                Route::delete('/delete/{id}', [ProgramController::class, 'delete']);
            });

        /**
         * Recruiter routes
         */
        Route::prefix('recruiter')
            ->group(function () {

                Route::get('/', [RecruiterController::class, 'index']);
                Route::post('/store', [RecruiterController::class, 'store']);
                Route::put('/update', [RecruiterController::class, 'update']);
                Route::delete('/delete/{id}', [RecruiterController::class, 'delete']);
            });

        /**
         * Lead routes
         */
        Route::prefix('lead')
            ->group(function () {

                Route::get('/', [LeadController::class, 'index']);
            });

        /**
         * Student routes
         */
        Route::prefix('student')
            ->group(function () {

                Route::get('/', [StudentController::class, 'index']);
            });

    });
