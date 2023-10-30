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
        $packageWebContents = file_get_contents(__DIR__ . '/Routes/web.php');

        $additionalLines = "use App\Http\Controllers\SlackController;\nuse App\Http\Controllers\HomeController;\nuse App\Http\Controllers\MenuController;\n";

        $pattern = '/<\?php\s*/';
        $projectWebContents = preg_replace($pattern, "<?php\n\n" . $additionalLines, file_get_contents($projectWebPath), 1);

        if (strpos($projectWebContents, $packageWebContents) === false) {
            $projectWebContents .= $packageWebContents;
            file_put_contents($projectWebPath, $projectWebContents);
        }
    }
}
