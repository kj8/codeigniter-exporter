<?php

declare(strict_types=1);

namespace Kj8\CodeIgniterExporter\Writer\Options;

use OpenSpout\Writer\ODS\Options;

interface ODSWriterOptionsInterface
{
    public function unwrap(): Options;
}
