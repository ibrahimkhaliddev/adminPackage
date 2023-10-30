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

        preg_match('/use App\\Http\\Controllers\\MenuController;/', $myWebPhpContents, $matches);
        $extractedLine = isset($matches[0]) ? $matches[0] : '';

        $existingWebPhpContents = file_get_contents(base_path('routes/web.php'));

        file_put_contents(base_path('routes/web.php'), $extractedLine, FILE_APPEND | LOCK_EX);

        $this->publishes([
            __DIR__ . '/resources/views/myCustomAdminPackage/layout.blade.php' => resource_path('views/CustomAdminPackage/layout.blade.php'),
        ], 'my-package-resources');

        $this->publishes([
            __DIR__ . '/Http/Controllers' => app_path('Http/Controllers'),
        ], 'my-package-resources');
    }
}
