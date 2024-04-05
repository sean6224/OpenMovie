<?php
declare(strict_types=1);
namespace App\Common\Domain\Port\Database;

/**
 * Interface representing a port for executing SQL queries and updates.
 */
interface QueryExecutorPort
{
    /**
     * Executes an SQL query and returns results as an associative array.
     *
     * @param string $query SQL query.
     * @param array $parameters Query parameters.
     * @return array An associative array with the results of the query.
     */
    public function executeQuery(string $query, array $parameters = []): array;

    /**
     * Executes database update query (INSERT, UPDATE, DELETE) and returns number of modified records.
     *
     * @param string $query SQL query.
     * @param array $parameters Query parameters.
     * @return int Number of modified records.
     */
    public function executeUpdate(string $query, array $parameters = []): int;
}
