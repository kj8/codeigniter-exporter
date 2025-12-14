<?php

declare(strict_types=1);

namespace Kj8\CodeIgniterExporter;

use Kj8\CodeIgniterExporter\Reader\DataReaderInterface;
use Kj8\CodeIgniterExporter\Writer\DataWriterInterface;

final class DataExportService
{
    public function __construct(
        private readonly DataReaderInterface $reader,
        private readonly DataWriterInterface $writer,
    ) {
    }

    public function export(): void
    {
        $this->writer->write($this->reader->read());
    }
}
