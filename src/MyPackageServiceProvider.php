<?php

namespace Panelist\AdminPackage;

use Illuminate\Support\ServiceProvider;

class MyPackageServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Add any necessary bindings or services here
    }

    public function boot()
    {
        $this->appendWebRoutes();

        $this->publishes([
            __DIR__ . '/resources/views/myCustomAdminPackage/layout.blade.php' => resource_path('views/CustomAdminPackage/layout.blade.php'),
        ], 'my-package-resources');

        $this->publishes([
            __DIR__ . '/Http/Controllers' => app_path('Http/Controllers'),
        ], 'my-package-resources');
    }

    private function appendWebRoutes()
    {
        $projectWebPath = base_path('routes/web.php');
        $packageWebContents = file_get_contents(__DIR__ . 'Routes/web.php');

        $additionalLines = "\nuse App\Http\Controllers\SlackController;\n";

        $projectWebContents = file_get_contents($projectWebPath);
        $pattern = '/<\?php/';
        $projectWebContents = preg_replace($pattern, "<?php" . $additionalLines, $projectWebContents, 1);

        $packageWebContents = str_replace('<?php', '', $packageWebContents); // Remove opening PHP tag

        if (strpos($projectWebContents, $packageWebContents) === false) {
            // Add new route group with proper formatting
            $packageWebContents = str_replace('Route::middleware', "\n\nRoute::middleware", $packageWebContents);

            // Append the package's routes
            $projectWebContents .= $packageWebContents;

            // Write the updated content back to the file
            file_put_contents($projectWebPath, $projectWebContents);
        }
    }
}
