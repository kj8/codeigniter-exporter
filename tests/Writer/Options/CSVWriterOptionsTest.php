<?php

declare(strict_types=1);

namespace Kj8\Tests\CodeIgniterExporter\Writer\Options;

use Kj8\CodeIgniterExporter\Writer\Options\CSVWriterOptions;
use OpenSpout\Writer\CSV\Options;
use PHPUnit\Framework\TestCase;

/**
 * Testuje klasę CSVWriterOptions.
 * Tests the CSVWriterOptions class.
 */
final class CSVWriterOptionsTest extends TestCase
{
    /**
     * Testuje domyślne wartości opcji.
     * Tests default option values.
     */
    public function testDefaultValues(): void
    {
        $optionsWrapper = new CSVWriterOptions();
        $options = $optionsWrapper->unwrap();

        $this->assertInstanceOf(Options::class, $options);
        $this->assertSame(',', $options->FIELD_DELIMITER);
        $this->assertSame('"', $options->FIELD_ENCLOSURE);
        $this->assertTrue($options->SHOULD_ADD_BOM);
    }

    /**
     * Testuje przekazywanie niestandardowych opcji.
     * Tests passing custom options.
     */
    public function testCustomValues(): void
    {
        $delimiter = ';';
        $enclosure = "'";
        $shouldAddBom = false;

        $optionsWrapper = new CSVWriterOptions($delimiter, $enclosure, $shouldAddBom);
        $options = $optionsWrapper->unwrap();

        $this->assertSame($delimiter, $options->FIELD_DELIMITER);
        $this->assertSame($enclosure, $options->FIELD_ENCLOSURE);
        $this->assertSame($shouldAddBom, $options->SHOULD_ADD_BOM);
    }
}
