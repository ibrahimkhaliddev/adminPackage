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
        // Get the contents of the my web.php file.
        $myWebPhpContents = file_get_contents(__DIR__ . '/Routes/web.php');

        // Write the contents of the my web.php file to the existing web.php file.
        file_put_contents(base_path('routes/web.php'), $myWebPhpContents);

        // Publish the myCustomAdminPackage/layout.blade.php file to the resources/views/CustomAdminPackage/layout.blade.php file.
        $this->publishes([
            __DIR__ . '/resources/views/myCustomAdminPackage/layout.blade.php' => resource_path('views/CustomAdminPackage/layout.blade.php'),
        ], 'my-package-resources');

        // Publish the Http/Controllers directory to the app_path('Http/Controllers') directory.
        $this->publishes([
            __DIR__ . '/Http/Controllers' => app_path('Http/Controllers'),
        ], 'my-package-resources');
    }
}
