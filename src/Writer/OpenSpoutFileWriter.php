<?php

declare(strict_types=1);

namespace Kj8\CodeIgniterExporter\Writer;

use Kj8\CodeIgniterExporter\Common\CellCreator;
use OpenSpout\Common\Entity\Row;
use OpenSpout\Common\Exception\IOException;
use OpenSpout\Writer\AbstractWriter;
use OpenSpout\Writer\Exception\WriterNotOpenedException;

class OpenSpoutFileWriter implements DataWriterInterface
{
    private bool $headerWritten = false;

    /**
     * @param array<int, string>|null $documentHeaders
     */
    public function __construct(
        private readonly AbstractWriter $writer,
        private readonly string $filePath,
        private readonly ?array $documentHeaders = null,
    ) {
    }

    /**
     * @throws WriterNotOpenedException
     * @throws IOException
     */
    public function write(iterable $data): void
    {
        $this->open($this->filePath);

        foreach ($data as $row) {
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
        $this->writer->addRow(new Row(CellCreator::toCells($row)));
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
}
