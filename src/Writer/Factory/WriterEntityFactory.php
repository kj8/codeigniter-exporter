<?php

declare(strict_types=1);

namespace Kj8\CodeIgniterExporter\Writer\Factory;

use Kj8\CodeIgniterExporter\Writer\Options\CSVWriterOptionsInterface;
use Kj8\CodeIgniterExporter\Writer\Options\ODSWriterOptionsInterface;
use Kj8\CodeIgniterExporter\Writer\Options\XLSXWriterOptionsInterface;
use OpenSpout\Writer\CSV\Writer as WriterCSV;
use OpenSpout\Writer\ODS\Writer as WriterODS;
use OpenSpout\Writer\XLSX\Writer as WriterXLSX;

class WriterEntityFactory
{
    public static function createCSVWriter(CSVWriterOptionsInterface $options): WriterCSV
    {
        return new WriterCSV($options->unwrap());
    }

    public static function createXLSXWriter(XLSXWriterOptionsInterface $options): WriterXLSX
    {
        return new WriterXLSX($options->unwrap());
    }

    public static function createODSWriter(ODSWriterOptionsInterface $options): WriterODS
    {
        return new WriterODS($options->unwrap());
    }
}
