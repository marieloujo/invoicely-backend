<?php

declare(strict_types=1);

namespace App\Helpers;

use Illuminate\Support\Facades\Route;


class RouteLoader
{
    public static function loadRoutesFrom($path)
    {
        // Get a list of subdirectories in the provided path (API versions)
        $apiVersions = array_filter(glob($path . '/*'), 'is_dir');

        // Include route files for each API version and group them by version
        foreach ($apiVersions as $version) {

            $versionName = basename($version);

            Route::prefix($versionName)->group(function () use ($version) {

                $routeFiles = glob("{$version}/*.php");

                foreach ($routeFiles as $routeFile) {
                    include $routeFile;
                }
            });

        }
    }
}
