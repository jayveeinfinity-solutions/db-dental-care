<?php

namespace App\Providers;

use App\Services\UserService;
use App\Services\DentalService;
use App\Directives\PatientComplete;
use App\Services\AppointmentService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        PatientComplete::register();
        View::composer('*', function ($view) {
            $userService = app(UserService::class);
            $dentalService = app(DentalService::class);
            $appointmentService = app(AppointmentService::class);


            $view->with(
                'userPendingAppointments',
                $userService->getPendingAppointmentCount()
            );
            $view->with(
                'dentalServices',
                $dentalService->get()
            );
            $view->with(
                'times',
                $appointmentService->getTimes()
            );
        });
    }
}
