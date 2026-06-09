<?php

namespace App\Providers;

use App\Events\UserRegistered;
use App\Listeners\SendWelcomeEmail;
use App\Listeners\SendAdminEmail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        UserRegistered::class => [
            SendWelcomeEmail::class,    
            SendAdminEmail::class,  
        ],
    ];

    public function boot(): void {}

    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
