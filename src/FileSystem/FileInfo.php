<?php

declare(strict_types=1);

namespace Kj8\CodeIgniterExporter\FileSystem;

class FileInfo extends \SplFileInfo
{
    public function __construct(string $filename)
    {
        parent::__construct($filename);

        $dir = $this->getPath();

        if (!file_exists($dir)) {
            mkdir($dir, 0o777, true);
        }
    }
}
