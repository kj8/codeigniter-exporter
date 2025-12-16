<?php

declare(strict_types=1);

namespace Kj8\CodeIgniterExporter\Writer;

interface DataWriterInterface
{
    /**
     * @param iterable<array<string|int|float|null>> $data
     */
    public function write(iterable $data): void;
}
