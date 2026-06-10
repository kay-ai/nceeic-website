<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use App\Livewire\Portal\StepOne;
use App\Livewire\Portal\StepTwo;
use App\Livewire\Portal\StepThree;
use App\Livewire\Portal\Dashboard;

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
        Livewire::component('portal.step-one',   StepOne::class);
        Livewire::component('portal.step-two',   StepTwo::class);
        Livewire::component('portal.step-three', StepThree::class);
        Livewire::component('portal.dashboard',  Dashboard::class);
    }
}
