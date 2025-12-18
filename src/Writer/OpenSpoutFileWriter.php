<?php

declare(strict_types=1);

namespace Kj8\CodeIgniterExporter\Writer;

use OpenSpout\Common\Entity\Cell;
use OpenSpout\Common\Entity\Row;
use OpenSpout\Common\Exception\IOException;
use OpenSpout\Writer\AbstractWriter;
use OpenSpout\Writer\Exception\WriterNotOpenedException;

class OpenSpoutFileWriter implements DataWriterInterface
{
    private bool $headerWritten = false;

    /**
     * @param array<int, string>|null $documentHeaders
     * @param array<int, string>|null $onlyFields
     */
    public function __construct(
        private readonly AbstractWriter $writer,
        private readonly string $filePath,
        private readonly ?array $documentHeaders = null,
        private readonly ?array $onlyFields = null,
    ) {}

    /**
     * @throws WriterNotOpenedException
     * @throws IOException
     */
    public function write(iterable $data): void
    {
        $this->open($this->filePath);

        foreach ($data as $row) {
            if (null !== $this->onlyFields) {
                $row = array_replace(
                    array_flip($this->onlyFields),
                    array_intersect_key($row, array_flip($this->onlyFields))
                );
            }

            if (!$this->headerWritten) {
                $this->writeRow($this->documentHeaders ?? array_keys($row));
                $this->headerWritten = true;
            }

            $this->writeRow($row);
        }

        $this->close();
    }

    /**
     * @param array<float|int|string|null> $row
     *
     * @throws IOException
     * @throws WriterNotOpenedException
     */
    private function writeRow(array $row): void
    {
        $this->writer->addRow(new Row($this->toCells($row)));
    }

    /**
     * @throws IOException
     */
    private function open(string $filePath): void
    {
        $this->writer->openToFile($filePath);
    }

    private function close(): void
    {
        $this->writer->close();
    }

    /**
     * @param array<int, scalar|\DateTimeInterface|\DateInterval|null> $values
     *
     * @return array<int, Cell>
     */
    private function toCells(array $values): array
    {
        return array_map(static fn($v) => Cell::fromValue($v), $values);
    }
}
