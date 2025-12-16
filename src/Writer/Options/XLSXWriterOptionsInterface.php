<?php

declare(strict_types=1);

namespace Kj8\CodeIgniterExporter\Writer\Options;

use OpenSpout\Writer\XLSX\Options;

interface XLSXWriterOptionsInterface
{
    public function unwrap(): Options;
}
