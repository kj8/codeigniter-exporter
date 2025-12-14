<?php

declare(strict_types=1);

namespace Kj8\CodeIgniterExporter\Writer;

interface DataWriterInterface
{
    /**
     * @param iterable<array<string, mixed>> $data
     */
    public function write(iterable $data): void;
}
