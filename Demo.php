<?php

declare(strict_types=1);

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Database;
use Kj8\CodeIgniterExporter\FileSystem\DirectoryEnsurer;
use Kj8\CodeIgniterExporter\Reader\IdRangeCodeIgniterDatabaseReader;
use Kj8\CodeIgniterExporter\Writer\Factory\WriterEntityFactory;
use Kj8\CodeIgniterExporter\Writer\OpenSpoutFileWriter;
use Kj8\CodeIgniterExporter\Writer\Options\CSVWriterOptions;
use OpenSpout\Common\Exception\IOException;
use OpenSpout\Writer\Exception\WriterNotOpenedException;

include __DIR__.'/vendor/autoload.php';

class Demo extends BaseController
{
    /**
     * @throws IOException
     * @throws WriterNotOpenedException
     */
    public function csv(): ResponseInterface
    {
        $reader = new IdRangeCodeIgniterDatabaseReader(
            Database::connect(),
            'users',
            ['id', 'email', 'created_at']
        );

        $filePath = WRITEPATH.'exports/users.csv';

        (new DirectoryEnsurer())->ensure($filePath);

        $options = new CSVWriterOptions();

        $writer = WriterEntityFactory::createCSVWriter($options);
        $fileWriter = new OpenSpoutFileWriter($writer, $filePath);

        $fileWriter->write($reader->read());

        return $this->response->setBody('CSV generated');
    }
}
