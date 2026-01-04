<?php

declare(strict_types=1);

namespace Kj8\CodeIgniterExporter\Reader;

use CodeIgniter\Database\ConnectionInterface;

/**
 * @example
 * $reader = new IdRangeCodeIgniterDatabaseReader(
 *     db_connect(),
 *     'users',
 *     ['id', 'email', 'status', 'created_at'],
 *     function (BaseBuilder $builder) {
 *         $builder
 *             ->where('status', 'active')
 *             ->where('created_at >=', '2024-01-01')
 *             ->whereIn('role', ['admin', 'editor'])
 *             ->like('email', '@example.com');
 *     },
 *     5000,
 *     'id'
 * );
 *
 * foreach ($reader->read() as $row) {
 *     echo $row['email'];
 * }
 *
 * @template TConnection
 * @template TResult
 */
final class IdRangeCodeIgniterDatabaseReader implements DataReaderInterface
{
    /**
     * Callback function to apply additional WHERE conditions to the query builder.
     *
     * @var callable|null
     */
    private $whereCallback;

    /**
     * @param list<string>                              $columns
     * @param ConnectionInterface<TConnection, TResult> $db
     */
    public function __construct(
        private readonly ConnectionInterface $db,
        private readonly string $table,
        private readonly array $columns,
        ?callable $whereCallback = null,
        private readonly int $chunkSize = 500,
        private readonly string $idColumn = 'id',
        private readonly bool $useHavingInsteadOfWhereForLastId = false,
    ) {
        $this->whereCallback = $whereCallback;
    }

    public function read(): iterable
    {
        $lastId = 0;

        while (true) {
            $builder = $this->db
                ->table("$this->table AS table_")
                ->select($this->columns)
                ->orderBy("$this->idColumn", 'ASC')
                ->limit($this->chunkSize);

            if ($this->useHavingInsteadOfWhereForLastId) {
                $builder = $builder->having("$this->idColumn > ", $lastId);
            } else {
                $builder = $builder->where("$this->idColumn > ", $lastId);
            }

            if (null !== $this->whereCallback) {
                ($this->whereCallback)($builder);
            }

            $query = $builder->get();

            if (false === $query) {
                break;
            }

            $rows = $query->getResultArray();

            if (!$rows) {
                break;
            }
            foreach ($rows as $row) {
                $lastId = $row[$this->idColumn];
                yield $row;
            }

            $query->freeResult();
            unset($rows);
        }
    }
}
