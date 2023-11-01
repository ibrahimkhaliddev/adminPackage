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
        $this->publishViews();
        $this->publishControllers();
        $this->publishMigrations();
        $this->editWebRoutes();
        $this->editMigrations();
    }

    private function publishViews()
    {
        $sourceViewPath = __DIR__ . '/resources/views/myCustomAdminPackage/layout.blade.php';
        $destinationViewPath = resource_path('views/CustomAdminPackage/layout.blade.php');
        $this->publishFile($sourceViewPath, $destinationViewPath);
    }

    private function publishControllers()
    {
        $sourceControllerPath = __DIR__ . '/Http/Controllers';
        $destinationControllerPath = app_path('Http/Controllers');
        $this->publishFile($sourceControllerPath, $destinationControllerPath);
    }

    private function publishMigrations()
    {
        $sourceMigrationPath = __DIR__ . '/Database/migrations';
        $destinationMigrationPath = database_path('migrations');
        $this->publishFile($sourceMigrationPath, $destinationMigrationPath);
    }

    private function publishFile($source, $destination)
    {
        $this->publishes([$source => $destination], 'laravel-assets');
    }

    private function editWebRoutes()
    {
        $packageWebPath = __DIR__ . '/Routes/web.php';
        $sampleWebPath = __DIR__ . '/Routes/sample.php';
        $originalWebPath = base_path('routes/web.php');

        $linesToRemove = ['use Illuminate\Support\Facades\Route;', 'use App\Http\Controllers\MenuController;'];

        $packageWebContent = $this->removeLinesFromFile($packageWebPath, $linesToRemove);
        $packageWebContent = $this->cleanPhpTags($packageWebContent);

        $originalWebContent = file($originalWebPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $filteredLines = array_filter($originalWebContent, fn($line) => strpos(trim($line), 'use') === 0);
        array_unshift($filteredLines, '<?php');

        $originalFilteredLines = array_filter($originalWebContent, fn($line) => strpos(trim($line), 'use') !== 0 && $line !== '<?php' && !empty(trim($line)));
        
        $linesToInsert = [ 'use App\Http\Controllers\MenuController;', ' '];

        $mergedLines = array_unique(array_merge($filteredLines, $linesToInsert, $originalFilteredLines, explode("\n", $packageWebContent)));

        $resultContent = implode("\n", $mergedLines) . "\n});";

        file_put_contents($sampleWebPath, $resultContent);
        file_put_contents($originalWebPath, $resultContent);
    }

    private function removeLinesFromFile($filePath, $linesToRemove)
    {
        $fileContents = file_get_contents($filePath);

        foreach ($linesToRemove as $line) {
            $fileContents = str_replace($line, '', $fileContents);
        }

        return $fileContents;
    }

    private function cleanPhpTags($content)
    {
        $content = preg_replace('/\s*<\?php\s*/', '', $content);
        $content = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $content);
        return $content;
    }

    private function editMigrations()
    {
        $migrationFiles = glob(database_path('migrations/*create_users_table.php'));
        if (!empty($migrationFiles)) {
            $file = $migrationFiles[0];
            $contents = file_get_contents($file);
            $searchLine = '$table->string(\'role\');';
            $newLine = "\t\t\t\$table->string('role');\n";
            if (strpos($contents, $searchLine) === false) {
                $position = strpos($contents, '$table->id();');
                if ($position !== false) {
                    $position += strlen('$table->id();') + 1;
                    $updatedContents = substr_replace($contents, $newLine, $position, 0);

                    if ($contents !== $updatedContents) {
                        file_put_contents($file, $updatedContents);
                    }
                }
            }
        }
    }
}

