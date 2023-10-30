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

        $filePath = __DIR__ . '/Routes/web.php';
        $editedFilePath = __DIR__ . '/Routes/sample.php';
        $originalPath = base_path('routes/web.php');
        
        $linesToRemove = [
            'use Illuminate\Support\Facades\Route;',
            'use App\Http\Controllers\HomeController;',
            'use App\Http\Controllers\MenuController;',
        ];
        
        $fileContents = file_get_contents($filePath);
        
        // Remove specific lines from the file
        foreach ($linesToRemove as $line) {
            $fileContents = str_replace($line, '', $fileContents);
        }
        
        $thepackageWeb = $fileContents;
        
        // Remove the <?php tag and empty lines from the $thepackageWeb variable
        $thepackageWeb = preg_replace('/\s*<\?php\s*/', '', $thepackageWeb);
        $thepackageWeb = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $thepackageWeb);
        
        $lines = file($originalPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        
        // Filter out lines that start with 'use'
        $filteredLines = array_filter($lines, function ($line) {
            return strpos(trim($line), 'use') === 0;
        });
        
        $linesToInsert = [
            '<?php',
            'use App\Http\Controllers\HomeController;',
            'use App\Http\Controllers\MenuController;',
        ];
        
        // Merge the lines to insert, filtered lines, and the modified file contents
        $resultLines = array_merge($linesToInsert, $filteredLines, explode("\n", $thepackageWeb));
        
        // Combine the lines into a single string
        $resultContent = implode("\n", $resultLines);
        
        // Write the updated content back to the file
        file_put_contents($editedFilePath, $resultContent);
        
        
        
        



        // Write the updated content back to the file
        // file_put_contents($editedFilePath, implode("\n", $resultLines));
        // echo implode("\n", $resultLines);
        //     $lines = explode("\n", $contents);
        //     $newContents = '';
        //     foreach ($lines as $line) {
        //         $shouldRemove = false;
        //         foreach ($linesToRemove as $lineToRemove) {
        //             if (strpos(trim($line), trim($lineToRemove)) !== false) {
        //                 $shouldRemove = true;
        //                 break;
        //             }
        //         }
        //         if (!$shouldRemove) {
        //             $newContents .= $line . "\n";
        //         }
        //     }

        //     // Write the updated content back to the file
        //     file_put_contents($filePath, $newContents);

        //     // echo $newContents;
        //     // Display a success message
        //     // echo "Lines removed successfully.";
        // } else {
        //     // Handle the case when the file doesn't exist
        //     echo "File not found.";
        // }
    }
}
