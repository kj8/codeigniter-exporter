<?php

declare(strict_types=1);

namespace Kj8\Tests\CodeIgniterExporter\Writer\Factory;

use Kj8\CodeIgniterExporter\Writer\Factory\WriterEntityFactory;
use Kj8\CodeIgniterExporter\Writer\Options\CSVWriterOptionsInterface;
use Kj8\CodeIgniterExporter\Writer\Options\ODSWriterOptionsInterface;
use Kj8\CodeIgniterExporter\Writer\Options\XLSXWriterOptionsInterface;
use OpenSpout\Writer\CSV\Options as CSVOptions;
use OpenSpout\Writer\CSV\Writer as CSVWriter;
use OpenSpout\Writer\ODS\Options as ODSOptions;
use OpenSpout\Writer\ODS\Writer as ODSWriter;
use OpenSpout\Writer\XLSX\Options as XLSXOptions;
use OpenSpout\Writer\XLSX\Writer as XLSXWriter;
use PHPUnit\Framework\TestCase;

/**
 * Testuje fabrykę WriterEntityFactory.
 * Tests the WriterEntityFactory.
 */
final class WriterEntityFactoryTest extends TestCase
{
    /**
     * Test tworzenia writera CSV.
     * Test creating CSV writer.
     */
    public function testCreateCSVWriter(): void
    {
        $optionsMock = $this->createMock(CSVWriterOptionsInterface::class);
        $optionsMock->method('unwrap')->willReturn(new CSVOptions());

        $writer = WriterEntityFactory::createCSVWriter($optionsMock);

        $this->assertInstanceOf(CSVWriter::class, $writer);
    }

    /**
     * Test tworzenia writera XLSX.
     * Test creating XLSX writer.
     */
    public function testCreateXLSXWriter(): void
    {
        $optionsMock = $this->createMock(XLSXWriterOptionsInterface::class);
        $optionsMock->method('unwrap')->willReturn(new XLSXOptions());

        $writer = WriterEntityFactory::createXLSXWriter($optionsMock);

        $this->assertInstanceOf(XLSXWriter::class, $writer);
    }

    /**
     * Test tworzenia writera ODS.
     * Test creating ODS writer.
     */
    public function testCreateODSWriter(): void
    {
        $optionsMock = $this->createMock(ODSWriterOptionsInterface::class);
        $optionsMock->method('unwrap')->willReturn(new ODSOptions());

        $writer = WriterEntityFactory::createODSWriter($optionsMock);

        $this->assertInstanceOf(ODSWriter::class, $writer);
    }
}
