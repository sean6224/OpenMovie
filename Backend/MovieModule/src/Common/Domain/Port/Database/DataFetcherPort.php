<?php
declare(strict_types=1);
namespace App\Common\Domain\Port\Database;

/**
 * Interface representing port for interacting with database.
 */
interface DataFetcherPort
{
    /**
     * Retrieves first record from results of SQL query.
     *
     * @param string $tableName The name of table to query.
     * @return array|null First record from results.
     */
    public function first(string $tableName): ?array;

    /**
     * Retrieves all records from results of SQL query.
     *
     * @param string $tableName The name of table to query.
     * @return array An associative array with results.
     */
    public function get(string $tableName): array;

    /**
     * Retrieves the field value from first record of SQL query results.
     *
     * @param string $tableName The name of table to query.
     * @param string $field The field whose value is to be retrieved.
     * @return mixed|null The value of the field from the first record.
     */
    public function value(string $tableName, string $field): mixed;

    /**
     * Retrieves the value of field from all records of SQL query results.
     *
     * @param string $tableName The name of table to query.
     * @param string $field The field whose value is to be retrieved.
     * @return array An array of field values from each record.
     */
    public function pluck(string $tableName, string $field): array;

    /**
     * Checks if the record meets conditions of SQL query.
     *
     * @param string $tableName The name of table to query.
     * @return bool True if the record meets conditions, false otherwise.
     */
    public function exists(string $tableName): bool;

    /**
     * Executes SQL query and returns one column as an array.
     *
     * @param string $tableName The name of table to query.
     * @param string $column Column name.
     * @return array An array of column values.
     */
    public function pluckColumn(string $tableName, string $column): array;

    /**
     * Executes SQL query and returns the first value from first record.
     *
     * @param string $tableName The name of table to query.
     * @param string $column Column name.
     * @return mixed|null Value from column.
     */
    public function pluckFirst(string $tableName, string $column): mixed;

    /**
     * Executes SQL query and returns number of records.
     *
     * @param string $tableName The name of table to query.
     * @return int Number of records.
     */
    public function count(string $tableName): int;

    /**
     * Executes SQL query and returns minimum value from column.
     *
     * @param string $tableName The name of table to query.
     * @param string $column Column name.
     * @return mixed|null Minimum value of column.
     */
    public function min(string $tableName, string $column): mixed;

    /**
     * Executes SQL query and returns the maximum value from column.
     *
     * @param string $tableName The name of table to query.
     * @param string $column Column name.
     * @return mixed|null Maximum value of column.
     */
    public function max(string $tableName, string $column): mixed;

    /**
     * Executes SQL query and returns the sum of column values.
     *
     * @param string $tableName The name of table to query.
     * @param string $column The name of column.
     * @return mixed|null Sum of column value.
     */
    public function sum(string $tableName, string $column): mixed;

    /**
     * Executes SQL query and returns the average value from column.
     *
     * @param string $tableName The name of table to query.
     * @param string $column Column name.
     * @return mixed|null Average value of column.
     */
    public function avg(string $tableName, string $column): mixed;

    /**
     * Retrieves column names from given table.
     *
     * @param string $tableName Table name.
     * @return array Array of column names.
     */
    public function getColumns(string $tableName): array;
}
