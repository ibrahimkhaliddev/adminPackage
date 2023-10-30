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
        $packageWebPath = __DIR__ . '/Routes/web.php';

        $projectWebContents = file_get_contents($projectWebPath);
        $packageWebContents = str_replace("use Illuminate\Support\Facades\Route;\n", '', file_get_contents($packageWebPath));

        $additionalLines = "use App\Http\Controllers\HomeController;\nuse App\Http\Controllers\MenuController;\n";

        if (strpos($projectWebContents, $additionalLines) === false) {
            $projectWebContents = $additionalLines . $projectWebContents;
        }

        $slackControllerLine = "use App\Http\Controllers\SlackController;";
        if (strpos($projectWebContents, $slackControllerLine) !== false) {
            $projectWebContents = str_replace($slackControllerLine . "\n", '', $projectWebContents);
            $projectWebContents = preg_replace("/<\?php\n+/", "<?php\n\n" . $slackControllerLine . "\n", $projectWebContents, 1);
        }

        if (strpos($projectWebContents, $packageWebContents) === false) {
            $projectWebContents .= $packageWebContents;
            file_put_contents($projectWebPath, $projectWebContents);
        }
    }
}
