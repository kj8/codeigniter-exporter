<?php

declare(strict_types=1);

namespace Kj8\CodeIgniterExporter\Writer\Options;

use OpenSpout\Writer\CSV\Options;

final class CSVWriterOptions implements CSVWriterOptionsInterface
{
    private readonly Options $options;

    public function __construct(
        string $delimiter = ',',
        string $enclosure = '"',
        bool $shouldAddBom = true,
    ) {
        $this->options = new Options();

        $this->options->FIELD_DELIMITER = $delimiter;
        $this->options->FIELD_ENCLOSURE = $enclosure;
        $this->options->SHOULD_ADD_BOM = $shouldAddBom;
    }

    public function unwrap(): Options
    {
        return $this->options;
    }
}
