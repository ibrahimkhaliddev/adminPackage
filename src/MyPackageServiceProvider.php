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

        // Get the contents of the existing web.php file.
        $existingWebPhpContents = file_get_contents(base_path('routes/web.php'));

        // Merge the contents of the two files.
        $mergedWebPhpContents = array_merge($myWebPhpContents, $existingWebPhpContents);

        // Write the contents of the merged file to the existing web.php file.
        file_put_contents(base_path('routes/web.php'), $mergedWebPhpContents);

        // Publish the myCustomAdminPackage/layout.blade.php file to the resources/views/CustomAdminPackage/layout.blade.php file.
        $this->publishes([
            __DIR__ . '/resources/views/myCustomAdminPackage/layout.blade.php' => resource_path('views/CustomAdminPackage/layout.blade.php'),
        ], 'my-package-resources');

        // Publish the Http/Controllers directory to the app_path('Http/Controllers') directory.
        $this->publishes([
            __DIR__ . '/Http/Controllers' => app_path('Http/Controllers'),
        ], 'my-package-resources');

        // Publish the Routes/web.php file to the base_path('routes/web.php') file.
        $this->publishes([
            __DIR__ . '/Routes/web.php' => base_path('routes/web.php'),
        ], 'my-package-resources');
    }
}
