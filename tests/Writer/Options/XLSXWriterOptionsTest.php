<?php

declare(strict_types=1);

namespace Kj8\Tests\CodeIgniterExporter\Writer\Options;

use Kj8\CodeIgniterExporter\Writer\Options\XLSXWriterOptions;
use OpenSpout\Writer\XLSX\Options;
use PHPUnit\Framework\TestCase;

/**
 * Testuje klasę XLSXWriterOptions.
 * Tests the XLSXWriterOptions class.
 */
final class XLSXWriterOptionsTest extends TestCase
{
    /**
     * Testuje czy unwrap zwraca instancję opcji XLSX.
     * Tests if unwrap returns an instance of XLSX options.
     */
    public function testUnwrap(): void
    {
        $optionsWrapper = new XLSXWriterOptions();
        $options = $optionsWrapper->unwrap();

        $this->assertInstanceOf(Options::class, $options);
    }
}
