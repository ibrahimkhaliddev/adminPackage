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
            __DIR__ . '/../resources/views/myCustomAdminPackage/layout.blade.php' => resource_path('views/vendor/myCustomAdminPackage/layout.blade.php'),
            __DIR__ . '/../Http/Controllers' => app_path('Http/Controllers'),
        ], 'my-package-resources');

        $this->addRoutes();
    }

    protected function addRoutes()
    {
        $routeFile = base_path('routes/web.php');
        $routes = "\nRoute::get('/your-route', 'YourController@yourMethod');";
        file_put_contents($routeFile, $routes, FILE_APPEND | LOCK_EX);
    }
}
