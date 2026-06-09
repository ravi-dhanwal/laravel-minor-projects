<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use App\Mail\AdminNewUserMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendAdminEmail
{
    public function __construct() {}

    public function handle(UserRegistered $event): void
    {
        $adminEmail = env('ADMIN_EMAIL', config('mail.from.address'));
        Mail::to($adminEmail)->send(new AdminNewUserMail($event->user));
    }
}
