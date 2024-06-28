<?php

namespace AliMousavi\TeleNotify;

use Illuminate\Support\ServiceProvider;

class TeleNotifyServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->publishes([
            __DIR__ .'/../config/telenotify.php' => config_path('telenotify.php')
        ]);

    }

    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__ .'/../config/telenotify.php', 'telenotify'
        );

    }
}
