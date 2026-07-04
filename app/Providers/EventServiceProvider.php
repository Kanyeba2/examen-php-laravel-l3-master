<?php

namespace App\Providers;

use App\Events\MobilePaymentStatusUpdated;
use App\Listeners\SendMobilePaymentReceipt;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    // Mappe les events metier avec leurs listeners associes.
    protected $listen = [
        MobilePaymentStatusUpdated::class => [
            SendMobilePaymentReceipt::class,
        ],
    ];

    public function boot(): void
    {
        //
    }
}
