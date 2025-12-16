<?php

declare(strict_types=1);

namespace Kj8\CodeIgniterExporter\Writer;

use Kj8\CodeIgniterExporter\Common\CellCreator;
use Kj8\CodeIgniterExporter\Writer\Factory\WriterEntityFactory;
use Kj8\CodeIgniterExporter\Writer\Options\CSVWriterOptions;
use Kj8\CodeIgniterExporter\Writer\Options\CSVWriterOptionsInterface;
use Kj8\CodeIgniterExporter\Writer\Options\ODSWriterOptions;
use Kj8\CodeIgniterExporter\Writer\Options\ODSWriterOptionsInterface;
use Kj8\CodeIgniterExporter\Writer\Options\WriterOptionsInterface;
use Kj8\CodeIgniterExporter\Writer\Options\XLSXWriterOptions;
use Kj8\CodeIgniterExporter\Writer\Options\XLSXWriterOptionsInterface;
use OpenSpout\Common\Entity\Row;
use OpenSpout\Common\Exception\IOException;
use OpenSpout\Writer\AbstractWriter;
use OpenSpout\Writer\Exception\WriterNotOpenedException;

class OpenSpoutFileWriter implements DataWriterInterface
{
    private bool $headerWritten = false;
    private readonly AbstractWriter $writer;

    /**
     * @param array<int, string>|null $documentHeaders
     */
    public function __construct(
        private readonly string $filePath,
        //        private readonly WriterOptionsInterface $options,
        private readonly CSVWriterOptionsInterface|ODSWriterOptionsInterface|XLSXWriterOptionsInterface $options,
        private readonly ?array $documentHeaders = null,
    ) {
        $this->writer = match (true) {
            $this->options instanceof CSVWriterOptions => WriterEntityFactory::createCSVWriter($this->options),
            $this->options instanceof XLSXWriterOptions => WriterEntityFactory::createXLSXWriter($this->options),
            $this->options instanceof ODSWriterOptions => WriterEntityFactory::createODSWriter($this->options),
            default => throw new \LogicException('Unsupported writer options.'),
        };
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
