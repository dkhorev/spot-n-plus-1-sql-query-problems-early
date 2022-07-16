<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * @var array<string, array<string>>
     */
    protected $listen = [
    ];

    public function shouldDiscoverEvents()
    {
        return false;
    }
}
