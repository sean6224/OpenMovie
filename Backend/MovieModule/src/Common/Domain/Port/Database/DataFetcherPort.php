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
     * @return array|null First record from the results.
     */
    public function first(): ?array;

    /**
     * Retrieves all records from results of SQL query.
     *
     * @return array An associative array with the results.
     */
    public function get(): array;

    /**
     * Retrieves the field value from first record of SQL query results.
     *
     * @param string $field The field whose value is to be retrieved.
     * @return mixed|null The value of the field from the first record.
     */
    public function value(string $field): mixed;

    /**
     * Retrieves the value of field from all records of SQL query results.
     *
     * @param string $field The field whose value is to be retrieved.
     * @return array An array of field values from each record.
     */
    public function pluck(string $field): array;

    /**
     * Checks if the record meets the conditions of SQL query.
     *
     * @return bool True if the record meets the conditions, false otherwise.
     */
    public function exists(): bool;

    /**
     * Executes SQL query and returns one column as an array.
     *
     * @param string $column Column name.
     * @return array An array of column values.
     */
    public function pluckColumn(string $column): array;

    /**
     * Executes SQL query and returns the first value from first record.
     *
     * @param string $column Column name.
     * @return mixed|null Value from the column.
     */
    public function pluckFirst(string $column): mixed;

    /**
     * Executes SQL query and returns number of records.
     *
     * @return int Number of records.
     */
    public function count(): int;

    /**
     * Executes SQL query and returns the minimum value from column.
     *
     * @param string $column Column name.
     * @return mixed|null Minimum value of the column.
     */
    public function min(string $column): mixed;

    /**
     * Executes SQL query and returns the maximum value from column.
     *
     * @param string $column Column name.
     * @return mixed|null Maximum value of the column.
     */
    public function max(string $column): mixed;

    /**
     * Executes SQL query and returns the sum of column values.
     *
     * @param string $column The name of the column.
     * @return mixed|null Sum of the column value.
     */
    public function sum(string $column): mixed;

    /**
     * Executes SQL query and returns the average value from column.
     *
     * @param string $column Column name.
     * @return mixed|null Average value of the column.
     */
    public function avg(string $column): mixed;

    /**
     * Retrieves column names from given table.
     *
     * @param string $table Table name.
     * @return array Array of column names.
     */
    public function getColumns(string $table): array;
}
