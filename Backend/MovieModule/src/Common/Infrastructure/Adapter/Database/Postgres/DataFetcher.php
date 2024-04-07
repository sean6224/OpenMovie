<?php
declare(strict_types=1);
namespace App\Common\Infrastructure\Adapter\Database\Postgres;

use App\Common\Domain\Port\Database\DataFetcherPort;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use PDO;

/**
 * Adapter for interacting with database using Doctrine DBAL.
 */
class DataFetcher implements DataFetcherPort
{
    private Connection $connection;

    /**
     * Constructs new DataFetcherAdapter instance.
     *
     * @param Connection $connection Doctrine DBAL connection.
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Retrieves the first record from results of an SQL query.
     *
     * @param string $tableName The name of table to query.
     * @return array|null The first record from the results, or null if no record is found.
     */
    public function first(string $tableName): ?array
    {
        return $this->createQuery($tableName)
            ->setMaxResults(1)
            ->execute()
            ->fetchAssociative();
    }

    /**
     * Retrieves all records from the results of an SQL query.
     *
     * @param string $tableName The name of table to query.
     * @return array An associative array with the results.
     */
    public function get(string $tableName): array
    {
        return $this->createQuery($tableName)
            ->execute()
            ->fetchAllAssociative();
    }

    /**
     * Retrieves the value of field from first record of the SQL query results.
     *
     * @param string $tableName The name of table to query.
     * @param string $field The field whose value is to be retrieved.
     * @return mixed|null The value of the field from the first record, or null if no record is found.
     */
    public function value(string $tableName, string $field): mixed
    {
        $result = $this->createQuery($tableName)
            ->select($field)
            ->setMaxResults(1)
            ->execute()
            ->fetchOne();

        return $result !== false ? $result : null;
    }

    /**
     * Retrieves the value of field from all records of the SQL query results.
     *
     * @param string $tableName The name of table to query.
     * @param string $field The field whose value is to be retrieved.
     * @return array An array of field values from each record.
     */
    public function pluck(string $tableName, string $field): array
    {
        $results = $this->createQuery($tableName)
            ->select($field)
            ->execute()
            ->fetchAll(PDO::FETCH_COLUMN);

        return $results ?: [];
    }

    /**
     * Checks if record meets the conditions of SQL query.
     *
     * @param string $tableName The name of table to query.
     * @return bool True if the record meets conditions, false otherwise.
     */
    public function exists(string $tableName): bool
    {
        $result = $this->createQuery($tableName)
            ->select('COUNT(*)')
            ->setMaxResults(1)
            ->execute()
            ->fetchOne();

        return (int) $result > 0;
    }

    /**
     * Executes an SQL query and returns one column as an array.
     *
     * @param string $tableName The name of table to query.
     * @param string $column The column name.
     * @return array An array of column values.
     */
    public function pluckColumn(string $tableName, string $column): array
    {
        $results = $this->createQuery($tableName)
            ->select($column)
            ->execute()
            ->fetchAll(PDO::FETCH_COLUMN);

        return $results ?: [];
    }

    /**
     * Executes an SQL query and returns the first value from first record.
     *
     * @param string $tableName The name of table to query.
     * @param string $column The column name.
     * @return mixed|null The value from column.
     */
    public function pluckFirst(string $tableName, string $column): mixed
    {
        $result = $this->createQuery($tableName)
            ->select($column)
            ->setMaxResults(1)
            ->execute()
            ->fetchOne();

        return $result !== false ? $result : null;
    }

    /**
     * Executes an SQL query and returns number of records.
     *
     * @param string $tableName The name of table to query.
     * @return int The number of records.
     */
    public function count(string $tableName): int
    {
        $result = $this->createQuery($tableName)
            ->select('COUNT(*)')
            ->execute()
            ->fetchOne();

        return (int) $result;
    }

    /**
     * Executes an SQL query and returns the minimum value from column.
     *
     * @param string $tableName The name of table to query.
     * @param string $column The column name.
     * @return mixed|null The minimum value of column.
     */
    public function min(string $tableName, string $column): mixed
    {
        $result = $this->createQuery($tableName)
            ->select('MIN(' . $column . ')')
            ->execute()
            ->fetchOne();

        return $result !== false ? $result : null;
    }

    /**
     * Executes an SQL query and returns the maximum value from column.
     *
     * @param string $tableName The name of table to query.
     * @param string $column The column name.
     * @return mixed|null The maximum value of column.
     */
    public function max(string $tableName, string $column): mixed
    {
        $result = $this->createQuery($tableName)
            ->select('MAX(' . $column . ')')
            ->execute()
            ->fetchOne();

        return $result !== false ? $result : null;
    }

    /**
     * Executes an SQL query and returns the sum of column values.
     *
     * @param string $tableName The name of table to query.
     * @param string $column The column name.
     * @return mixed|null The sum of column values.
     */
    public function sum(string $tableName, string $column): mixed
    {
        $result = $this->createQuery($tableName)
            ->select('SUM(' . $column . ')')
            ->execute()
            ->fetchOne();

        return $result !== false ? $result : null;
    }

    /**
     * Executes an SQL query and returns the average value from column.
     *
     * @param string $tableName The name of table to query.
     * @param string $column The column name.
     * @return mixed|null The average value of column.
     */
    public function avg(string $tableName, string $column): mixed
    {
        $result = $this->createQuery($tableName)
            ->select('AVG(' . $column . ')')
            ->execute()
            ->fetchOne();

        return $result !== false ? $result : null;
    }

    /**
     * Retrieves column names from given table.
     *
     * @param string $tableName The name of table.
     * @return array An array of column names.
     * @throws Exception
     */
    public function getColumns(string $tableName): array
    {
        $schemaManager = $this->connection->createSchemaManager();
        $columns = $schemaManager->listTableColumns($tableName);
        $columnNames = [];

        foreach ($columns as $column) {
            $columnNames[] = $column->getName();
        }

        return $columnNames;
    }
}
