<?php

namespace Tests;

use Illuminate\Support\Facades\File;

trait Helper
{
    protected function saveResponseToFile($response, $filePath, $basePath = 'storage/responses/'): void
    {
        $full_path = base_path($basePath . $filePath);
        File::ensureDirectoryExists(dirname($full_path));
        $content = json_encode($response->json(), JSON_PRETTY_PRINT);
        file_put_contents($full_path, $content);
    }
}
