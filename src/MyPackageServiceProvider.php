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
        $this->publishModels();
        $this->publishMidlewares();
        $this->publishHelpers();
        $this->publishAssets();
        // $this->editMigrations();
        $this->updateUserModel();
        $this->publishRoutes();
        $this->publishSeeders();
    }

    /**
     * Publish custom views from the package to the main application.
     *
     * @return void
     */
    private function publishViews()
    {
        $sourceViewPath = __DIR__ . '/resources/views/my_package';
        $destinationViewPath = resource_path('views/my_package');
        $this->publishFile($sourceViewPath, $destinationViewPath);
    }

    private function publishMidlewares()
    {
        $sourceViewPath = __DIR__ . '/Http/Middleware/CheckPermissions.php';
        $destinationViewPath = app_path('Http/Middleware/CheckPermissions.php');
        $this->publishFile($sourceViewPath, $destinationViewPath);
        $this->addMiddlewareToKernel('permission', '\App\Http\Middleware\CheckPermissions');
    }

    /**
     * Publish custom controllers from the package to the main application.
     *
     * @return void
     */
    private function publishControllers()
    {
        $sourceControllerPath = __DIR__ . '/Http/Controllers';
        $destinationControllerPath = app_path('Http/Controllers');
        $this->publishFile($sourceControllerPath, $destinationControllerPath);
    }

    /**
     * Publish custom models from the package to the main application.
     *
     * @return void
     */
    private function publishModels()
    {
        $sourceControllerPath = __DIR__ . '/Models';
        $destinationControllerPath = app_path('Models');
        $this->publishFile($sourceControllerPath, $destinationControllerPath);
    }

    /**
     * Update the User model to include a new 'menus' relationship function if it does not exist already.
     * 
     * @return void
     */
    private function updateUserModel()
    {
        $filePath = app_path('Models/User.php');
        $newFunction = "    public function menus()
    {
        return \$this->belongsToMany(stMenu::class, 'st_user_menus', 'user_id', 'menu_id');
    }";

        $fileContent = file_get_contents($filePath);

        if (strpos($fileContent, 'public function menus()') === false) {
            $insertPosition = strpos($fileContent, 'class User extends Authenticatable');
            $insertPosition = strpos($fileContent, '{', $insertPosition) + 1;
            $updatedContent = substr($fileContent, 0, $insertPosition) . "\n" . $newFunction . "\n" . substr($fileContent, $insertPosition);

            file_put_contents($filePath, $updatedContent);
        }
    }

    private function publishHelpers()
    {
        $sourceMigrationPath = __DIR__ . '/Helpers';
        $destinationMigrationPath = app_path('/Helpers');
        $this->publishFile($sourceMigrationPath, $destinationMigrationPath);
    }

    /**
     * Publish custom migrations from the package to the main application.
     *
     * @return void
     */
    private function publishMigrations()
    {
        $sourceMigrationPath = __DIR__ . '/Database/migrations';
        $destinationMigrationPath = database_path('migrations');
        $this->publishFile($sourceMigrationPath, $destinationMigrationPath);
    }

    private function publishRoutes()
    {
        $sourceRoutePath = __DIR__ . '/Routes/adminPackage.php';
        $destinationMigrationPath = base_path('/routes/adminPackage.php');
        $this->publishFile($sourceRoutePath, $destinationMigrationPath);
        $routePath = base_path('/routes/web.php');
        $newLine = "\nrequire __DIR__.'/adminPackage.php';\n";
        $fileContent = file_get_contents($routePath);
        if (strpos($fileContent, $newLine) === false) {
            file_put_contents($routePath, $newLine, FILE_APPEND);
        }
    }


    private function publishAssets()
    {
        $sourceMigrationPath = __DIR__ . '/public/adminPackage';
        $destinationMigrationPath = public_path('/adminPackage');
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
        $this->publishes([$source => $destination], 'laravel-assets');
    }

    /**
     * Edit the main application's web routes to integrate package routes.
     *
     * @return void
     */

    private function editWebRoutes()
    {
        $routePath = base_path('routes/web.php');
        $newLine = "\n require __DIR__.'/adminPackage.php';\n";
        $fileContent = file_get_contents($routePath);
        if (strpos($fileContent, $newLine) === false) {
            file_put_contents($routePath, $newLine, FILE_APPEND);
        }
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

    private function publishSeeders(){
        $sourceMigrationPath = __DIR__ . '/database/seeders';
        $destinationMigrationPath = database_path('/seeders');
        $this->publishFile($sourceMigrationPath, $destinationMigrationPath);
    }

    /**
     * Add a new middleware entry to the Kernel.php file under $routeMiddleware.
     *
     * @param string $alias The alias of the middleware.
     * @param string $middlewareClass The fully qualified class name of the middleware.
     * @return void
     */
    private function addMiddlewareToKernel($alias, $middlewareClass)
    {
        $kernelFilePath = app_path('Http/Kernel.php');
        $kernelContent = file_get_contents($kernelFilePath);
        $newMiddlewareEntry = "\n        '{$alias}' => {$middlewareClass}::class," . PHP_EOL;
        if (strpos($kernelContent, $newMiddlewareEntry) === false) {
            $position = strrpos($kernelContent, "\n    ];");
            $updatedContent = substr_replace($kernelContent, $newMiddlewareEntry, $position, 0);
            file_put_contents($kernelFilePath, $updatedContent);
        }
    }





}

