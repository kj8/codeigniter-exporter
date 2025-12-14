<?php

declare(strict_types=1);

namespace Kj8\Tests\CodeIgniterExporter;

use Kj8\CodeIgniterExporter\DataExportService;
use Kj8\CodeIgniterExporter\Reader\DataReaderInterface;
use Kj8\CodeIgniterExporter\Writer\DataWriterInterface;
use PHPUnit\Framework\TestCase;

class DataExportServiceTest extends TestCase
{
    public function testItPassesReadDataToWriter(): void
    {
        $data = ['foo', 'bar'];

        $reader = $this->createMock(DataReaderInterface::class);
        $writer = $this->createMock(DataWriterInterface::class);

        $reader
            ->expects($this->once())
            ->method('read')
            ->willReturn($data);

        $writer
            ->expects($this->once())
            ->method('write')
            ->with($data);

        $service = new DataExportService($reader, $writer);
        $service->export();
    }
}
