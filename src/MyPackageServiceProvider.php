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
        $myWebPhpContents = file_get_contents(__DIR__ . '/Routes/web.php');

        // Remove the line "use Illuminate\Support\Facades\Route;" from the package's web.php content
        $myWebPhpContents = str_replace("use Illuminate\Support\Facades\Route;\n", '', $myWebPhpContents);

        $existingWebPhpContents = file_get_contents(base_path('routes/web.php'));

        // Append the modified package's web.php content to the main project's web.php
        file_put_contents(base_path('routes/web.php'), $myWebPhpContents, FILE_APPEND | LOCK_EX);

        $this->publishes([
            __DIR__ . '/resources/views/myCustomAdminPackage/layout.blade.php' => resource_path('views/CustomAdminPackage/layout.blade.php'),
        ], 'my-package-resources');

        $this->publishes([
            __DIR__ . '/Http/Controllers' => app_path('Http/Controllers'),
        ], 'my-package-resources');
    }
}
