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
            __DIR__ . '/resources/views/myCustomAdminPackage/layout.blade.php' => resource_path('views/CustomAdminPackage/layout.blade.php'),
            __DIR__ . '/Http/Controllers' => app_path('Http/Controllers'),
            __DIR__ . '/Routes/web.php' => base_path('routes/'),
        ], 'my-package-resources');
    }
    
}
