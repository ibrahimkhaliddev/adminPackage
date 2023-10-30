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
        // Define the lines that need to be added at the top
        $additionalLines = "use Illuminate\Support\Facades\Route;\nuse App\Http\Controllers\HomeController;\nuse App\Http\Controllers\MenuController;\n\n";

        // Get the contents of the existing web.php file
        $existingWebPhpContents = file_get_contents(base_path('routes/web.php'));

        // Prepend the additional lines at the top of the existing web.php file content
        $updatedWebPhpContents = $additionalLines . $existingWebPhpContents;

        // Write the updated content back to the web.php file
        file_put_contents(base_path('routes/web.php'), $updatedWebPhpContents);

        $myWebPhpContents = file_get_contents(__DIR__ . '/Routes/web.php');

        // Append the contents of the package's web.php file to the main project's web.php file
        file_put_contents(base_path('routes/web.php'), $myWebPhpContents, FILE_APPEND | LOCK_EX);

        $this->publishes([
            __DIR__ . '/resources/views/myCustomAdminPackage/layout.blade.php' => resource_path('views/CustomAdminPackage/layout.blade.php'),
        ], 'my-package-resources');

        $this->publishes([
            __DIR__ . '/Http/Controllers' => app_path('Http/Controllers'),
        ], 'my-package-resources');
    }
}
