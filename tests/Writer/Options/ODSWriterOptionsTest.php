<?php

declare(strict_types=1);

namespace Kj8\Tests\CodeIgniterExporter\Writer\Options;

use Kj8\CodeIgniterExporter\Writer\Options\ODSWriterOptions;
use OpenSpout\Writer\ODS\Options;
use PHPUnit\Framework\TestCase;

/**
 * Testuje klasę ODSWriterOptions.
 * Tests the ODSWriterOptions class.
 */
final class ODSWriterOptionsTest extends TestCase
{
    /**
     * Testuje czy unwrap zwraca instancję opcji ODS.
     * Tests if unwrap returns an instance of ODS options.
     */
    public function testUnwrap(): void
    {
        $optionsWrapper = new ODSWriterOptions();
        $options = $optionsWrapper->unwrap();

        $this->assertInstanceOf(Options::class, $options);
    }
}
