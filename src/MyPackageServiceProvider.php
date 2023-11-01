<?php

namespace Panelist\AdminPackage;

use Illuminate\Support\ServiceProvider;

class MyPackageServiceProvider extends ServiceProvider
{
    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        // Add any necessary bindings or services here
    }

    /**
     * Bootstrap any package services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishViews();
        $this->publishControllers();
        $this->publishMigrations();
        $this->editWebRoutes();
        $this->editMigrations();
    }

    /**
     * Publish custom views from the package to the main application.
     *
     * @return void
     */
    private function publishViews()
    {
        // Define the source and destination paths for the views
        $sourceViewPath = __DIR__ . '/resources/views/myCustomAdminPackage/layout.blade.php';
        $destinationViewPath = resource_path('views/CustomAdminPackage/layout.blade.php');

        // Publish the views from the package to the main application
        $this->publishFile($sourceViewPath, $destinationViewPath);
    }

    /**
     * Publish custom controllers from the package to the main application.
     *
     * @return void
     */
    private function publishControllers()
    {
        // Define the source and destination paths for the controllers
        $sourceControllerPath = __DIR__ . '/Http/Controllers';
        $destinationControllerPath = app_path('Http/Controllers');

        // Publish the controllers from the package to the main application
        $this->publishFile($sourceControllerPath, $destinationControllerPath);
    }

    /**
     * Publish custom migrations from the package to the main application.
     *
     * @return void
     */
    private function publishMigrations()
    {
        // Define the source and destination paths for the migrations
        $sourceMigrationPath = __DIR__ . '/Database/migrations';
        $destinationMigrationPath = database_path('migrations');

        // Publish the migrations from the package to the main application
        $this->publishFile($sourceMigrationPath, $destinationMigrationPath);
    }

    /**
     * Publish a file from the package source to the application destination.
     *
     * @param string $source      The source file path.
     * @param string $destination The destination file path.
     *
     * @return void
     */
    private function publishFile($source, $destination)
    {
        // Publish the file using Laravel's publishing functionality
        $this->publishes([$source => $destination], 'laravel-assets');
    }

    /**
     * Edit the main application's web routes to integrate package routes.
     *
     * @return void
     */

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

        $linesToInsert = ['use App\Http\Controllers\MenuController;', ' '];

        $mergedLines = array_unique(array_merge($filteredLines, $linesToInsert, $originalFilteredLines, explode("\n", $packageWebContent)));

        $resultContent = implode("\n", $mergedLines) . "\n});";

        file_put_contents($sampleWebPath, $resultContent);
        file_put_contents($originalWebPath, $resultContent);
    }

    /**
     * Remove specific lines from a file.
     *
     * @param string $filePath      The file path.
     * @param array  $linesToRemove The lines to be removed.
     *
     * @return string The updated content after removing lines.
     */

    private function removeLinesFromFile($filePath, $linesToRemove)
    {
        $fileContents = file_get_contents($filePath);

        foreach ($linesToRemove as $line) {
            $fileContents = str_replace($line, '', $fileContents);
        }

        return $fileContents;
    }

    /**
     * Clean PHP tags from content.
     *
     * @param string $content The content to be cleaned.
     *
     * @return string The cleaned content.
     */
    private function cleanPhpTags($content)
    {
        $content = preg_replace('/\s*<\?php\s*/', '', $content);
        $content = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $content);
        return $content;
    }

    /**
     * Edit the package-related migrations for necessary changes.
     *
     * @return void
     */
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

