<?php

declare(strict_types=1);

namespace Kj8\CodeIgniterExporter\Writer\Options;

use OpenSpout\Writer\CSV\Options;

interface CSVWriterOptionsInterface
{
    public function unwrap(): Options;
}
