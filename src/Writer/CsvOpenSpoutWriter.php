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
    private Writer $writer;

    /**
     * @throws IOException
     */
    public function __construct(
        FileInfo $fileInfo,
        private readonly ?array $csvHeaders = null,
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
                $this->writeHeader(null !== $this->csvHeaders ? $this->csvHeaders : array_keys($row));
                $this->headerWritten = true;
            }

            $cells = [];
            foreach ($row as $value) {
                $cells[] = Cell::fromValue($value);
            }

            $this->writer->addRow(new Row($cells));
        }

        $this->writer->close();
    }

    /**
     * @throws WriterNotOpenedException
     * @throws IOException
     */
    private function writeHeader(array $headers): void
    {
        $cells = array_map(fn ($header) => Cell::fromValue($header), $headers);
        $this->writer->addRow(new Row($cells));
    }
}
