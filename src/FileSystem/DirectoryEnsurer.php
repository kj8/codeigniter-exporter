<?php

declare(strict_types=1);

namespace Kj8\CodeIgniterExporter\FileSystem;

class DirectoryEnsurer
{
    public function ensure(string $path): void
    {
        $dir = dirname($path);

        if (!is_dir($dir)) {
            mkdir($dir, 0o777, true);
        }
    }
}
