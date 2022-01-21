<?php

namespace App\Providers;

use App\Contracts\AdminContract;
use App\Contracts\ArticleContract;
use App\Contracts\CandidateContract;
use App\Contracts\CategoryContract;
use App\Contracts\CountryContract;
use App\Contracts\EmployeeContract;
use App\Contracts\InstitutionContract;
use App\Contracts\IntakeContract;
use App\Contracts\LeadContract;
use App\Contracts\OfficeContract;
use App\Contracts\PackageContract;
use App\Contracts\PermissionContract;
use App\Contracts\PostContract;
use App\Contracts\ProgramContract;
use App\Contracts\RecruiterContract;
use App\Contracts\RegionContract;
use App\Contracts\RoleContract;
use App\Contracts\SettingContract;
use App\Contracts\ShortlistContract;
use App\Contracts\StaffContract;
use App\Contracts\StudentContract;
use App\Contracts\StudentDocumentContract;
use App\Contracts\StudentEducationContract;
use App\Contracts\StudentGuardianContract;
use App\Contracts\SubjectContract;
use App\Contracts\TeamContract;
use App\Contracts\UserContract;
use App\Contracts\VacancyContract;
use App\Models\Students\Shortlist;
use App\Repositories\AdminRepository;
use App\Repositories\ArticleRepository;
use App\Repositories\CandidateRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\CountryRepository;
use App\Repositories\EmployeeRepository;
use App\Repositories\InstitutionRepository;
use App\Repositories\IntakeRepository;
use App\Repositories\LeadRepository;
use App\Repositories\OfficeRepository;
use App\Repositories\PackageRepository;
use App\Repositories\PermissionRepository;
use App\Repositories\PostRepository;
use App\Repositories\ProgramRepository;
use App\Repositories\RecruiterRepository;
use App\Repositories\RegionRepository;
use App\Repositories\RoleRepository;
use App\Repositories\SettingRepository;
use App\Repositories\ShortlistRepository;
use App\Repositories\StaffRepository;
use App\Repositories\StudentDocumentRepository;
use App\Repositories\StudentEducationRepository;
use App\Repositories\StudentGuardianRepository;
use App\Repositories\StudentRepository;
use App\Repositories\SubjectRepository;
use App\Repositories\TeamRepository;
use App\Repositories\UserRepository;
use App\Repositories\VacancyRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    protected $repositories = [
        RoleContract::class => RoleRepository::class,
        PermissionContract::class => PermissionRepository::class,
        UserContract::class => UserRepository::class,
        AdminContract::class => AdminRepository::class,
        SettingContract::class => SettingRepository::class,
        PostContract::class => PostRepository::class,
        RegionContract::class => RegionRepository::class,
        CountryContract::class => CountryRepository::class,
        OfficeContract::class => OfficeRepository::class,
        EmployeeContract::class => EmployeeRepository::class,
        VacancyContract::class => VacancyRepository::class,
        CandidateContract::class => CandidateRepository::class,
        PackageContract::class => PackageRepository::class,
        CategoryContract::class => CategoryRepository::class,
        ArticleContract::class => ArticleRepository::class,
        InstitutionContract::class => InstitutionRepository::class,
        SubjectContract::class => SubjectRepository::class,
        ProgramContract::class => ProgramRepository::class,
        IntakeContract::class => IntakeRepository::class,
        LeadContract::class => LeadRepository::class,
        RecruiterContract::class => RecruiterRepository::class,
        TeamContract::class => TeamRepository::class,
        StaffContract::class => StaffRepository::class,
        StudentContract::class => StudentRepository::class,
        ShortlistContract::class => ShortlistRepository::class,
        StudentGuardianContract::class => StudentGuardianRepository::class,
        StudentEducationContract::class => StudentEducationRepository::class,
        StudentDocumentContract::class => StudentDocumentRepository::class
    ];

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        foreach ($this->repositories as $interface => $implementation) {
            $this->app->bind($interface, $implementation);
        }
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
