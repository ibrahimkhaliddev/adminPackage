<?php

namespace Panelist\AdminPackage;

use Illuminate\Support\ServiceProvider;

class MyPackageServiceProvider extends ServiceProvider
{
    public function register()
    {
        // ...
    }


    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../../config/MyCustomPackage.php' => config_path('MyCustomPackage.php'),
            __DIR__ . '/../../resources/views/myCustomAdminPackage/layout.blade.php' => resource_path('views/myCustomAdminPackage/layout.blade.php'),
        ]);
    }
}
