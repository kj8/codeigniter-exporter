```php
class ExportController extends BaseController
{
    public function csv()
    {
        $reader = new IdRangeCodeIgniterDatabaseReader(
            db_connect(),
            'users',
            ['id', 'email', 'created_at']
        );

        $writer = new CsvOpenSpoutWriter(new FileInfo(WRITEPATH.'exports/users.csv'), ['Id', 'E-mail', 'Created at'], ',', '"');

        $service = new DataExportService($reader, $writer);
        $service->export();

        return $this->response->setBody('CSV generated');
    }
}
```
