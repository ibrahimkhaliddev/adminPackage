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

        $this->publishes([
            __DIR__ . '/resources/views/myCustomAdminPackage/layout.blade.php' => resource_path('views/CustomAdminPackage/layout.blade.php'),
        ], 'my-package-resources');

        $this->publishes([
            __DIR__ . '/Http/Controllers' => app_path('Http/Controllers'),
        ], 'my-package-resources');

        $contents = File::get(__DIR__ . '/Routes/web.php');

            // Extract lines containing specific content
            $specificLines = [];
            $searchLines = [
                'use Illuminate\Support\Facades\Route;',
                'use App\Http\Controllers\HomeController;',
                'use App\Http\Controllers\MenuController;'
            ];

            $lines = explode("\n", $contents);

            foreach ($lines as $line) {
                foreach ($searchLines as $searchLine) {
                    if (strpos($line, $searchLine) !== false) {
                        $specificLines[] = $line;
                    }
                }
            }

            // Display or process the extracted content
            foreach ($specificLines as $specificLine) {
                echo $specificLine . "\n";
            }
    }

    
    
}
