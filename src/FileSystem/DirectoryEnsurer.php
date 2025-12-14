<?php

declare(strict_types=1);

namespace Kj8\CodeIgniterExporter\FileSystem;

class DirectoryEnsurer
{
    public function ensure(string $path): void
    {
        if (!is_dir($path)) {
            mkdir($path, 0o777, true);
        }
    }
}
