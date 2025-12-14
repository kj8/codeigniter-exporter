<?php

declare(strict_types=1);

namespace Kj8\CodeIgniterExporter\Writer;

use Kj8\CodeIgniterExporter\FileSystem\FileInfo;
use OpenSpout\Common\Entity\Cell;
use OpenSpout\Common\Entity\Row;
use OpenSpout\Common\Exception\IOException;
use OpenSpout\Writer\CSV\Options;
use OpenSpout\Writer\CSV\Writer;
use OpenSpout\Writer\Exception\WriterNotOpenedException;

final class CsvOpenSpoutWriter implements DataWriterInterface
{
    private bool $headerWritten = false;
    private readonly Writer $writer;

    /**
     * @param array<int, string>|null $documentHeaders
     *
     * @throws IOException
     */
    public function __construct(
        FileInfo $fileInfo,
        private readonly ?array $documentHeaders = null,
        string $fieldDelimiter = ',',
        string $fieldEnclosure = '"',
    ) {
        $options = new Options();
        $options->FIELD_DELIMITER = $fieldDelimiter;
        $options->FIELD_ENCLOSURE = $fieldEnclosure;

        $this->writer = new Writer($options);

        $this->writer->openToFile($fileInfo->getPathname());
    }

    /**
     * @throws WriterNotOpenedException
     * @throws IOException
     */
    public function write(iterable $data): void
    {
        foreach ($data as $row) {
            if (!$this->headerWritten) {
                $this->writeHeader($this->documentHeaders ?? array_keys($row));
                $this->headerWritten = true;
            }

            /**
             * @var array<int, bool|\DateInterval|\DateTimeInterface|float|int|string|null> $row
             */
            $cells = array_map(fn($value) => Cell::fromValue($value), $row);

            $this->writer->addRow(new Row($cells));
        }

        $this->writer->close();
    }

    /**
     * @param array<int, string> $headers
     *
     * @throws WriterNotOpenedException
     * @throws IOException
     */
    private function writeHeader(array $headers): void
    {
        $cells = array_map(fn($header) => Cell::fromValue($header), $headers);
        $this->writer->addRow(new Row($cells));
    }
}
