<?php

declare(strict_types=1);

namespace Kj8\CodeIgniterExporter\Writer\Options;

use OpenSpout\Writer\ODS\Options;

class ODSWriterOptions implements ODSWriterOptionsInterface
{
    private readonly Options $options;

    public function __construct()
    {
        $this->options = new Options();
    }

    public function unwrap(): Options
    {
        return $this->options;
    }
}
