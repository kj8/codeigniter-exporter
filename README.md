```php
class ExportController extends BaseController
{
    public function csv()
    {
        $reader = new \Kj8\CodeIgniterExporter\Reader\IdRangeCodeIgniterDatabaseReader(
            db_connect(),
            'users',
            ['id', 'email', 'created_at']
        );

        $writer = new \Kj8\CodeIgniterExporter\Writer\CsvOpenSpoutWriter(
            new \Kj8\CodeIgniterExporter\FileSystem\FileInfo(WRITEPATH.'exports/users.csv',
            new \Kj8\CodeIgniterExporter\FileSystem\DirectoryEnsurer()),
            ['Id', 'E-mail', 'Created at'],
            ',',
            '"'
        );

        $service = new \Kj8\CodeIgniterExporter\DataExportService($reader, $writer);
        $service->export();

        return $this->response->setBody('CSV generated');
    }
}
```
