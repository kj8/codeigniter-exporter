<?php

declare(strict_types=1);

namespace Kj8\CodeIgniterExporter\Reader;

interface DataReaderInterface
{
    /**
     * @return iterable<array<string, mixed>>
     */
    public function read(): iterable;
}
