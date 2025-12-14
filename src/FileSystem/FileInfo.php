<?php

declare(strict_types=1);

namespace Kj8\CodeIgniterExporter\FileSystem;

class FileInfo extends \SplFileInfo
{
    public function __construct(
        string $filename,
        DirectoryEnsurer $directoryEnsurer,
    ) {
        $directoryEnsurer->ensure(\dirname($filename));

        parent::__construct($filename);
    }
}
