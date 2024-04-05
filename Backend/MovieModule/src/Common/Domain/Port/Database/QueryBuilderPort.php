<?php
declare(strict_types=1);
namespace App\Common\Domain\Port\Database;

/**
 * Interface representing port for interacting with database.
 */
interface QueryBuilderPort
{
    /**
     * Starts new SQL query.
     *
     * @param string|null $table Name of the table.
     * @param array|null $columns List of columns to retrieve.
     * @return QueryBuilderPort Instance of the database adapter.
     */
    public function startQuery(?string $table = null, ?array $columns = null): QueryBuilderPort;

    /**
     * Adds WHERE condition to SQL query.
     *
     * @param string $condition WHERE condition.
     * @param array $parameters Parameters of the condition.
     * @return QueryBuilderPort Instance of the database adapter.
     */
    public function where(string $condition, array $parameters = []): QueryBuilderPort;

    /**
     * Adds an AND condition to an SQL query.
     *
     * @param string $condition AND condition.
     * @param array $parameters Parameters of the condition.
     * @return QueryBuilderPort Instance of the database adapter.
     */
    public function andWhere(string $condition, array $parameters = []): QueryBuilderPort;

    /**
     * Adds an OR condition to an SQL query.
     *
     * @param string $condition OR condition.
     * @param array $parameters Parameters of the condition.
     * @return QueryBuilderPort Instance of the database adapter.
     */
    public function orWhere(string $condition, array $parameters = []): QueryBuilderPort;

    /**
     * Adds BETWEEN condition to the SQL query.
     *
     * @param string $field The field for which the BETWEEN condition is to be set.
     * @param mixed $value1 Initial value of the range.
     * @param mixed $value2 End value of the interval.
     * @return QueryBuilderPort Database adapter instance.
     */
    public function whereBetween(string $field, mixed $value1, mixed $value2): QueryBuilderPort;

    /**
     * Adds NOT BETWEEN condition to the SQL query.
     *
     * @param string $field The field for which the NOT BETWEEN condition is to be set.
     * @param mixed $value1 Initial value of the range.
     * @param mixed $value2 End value of the interval.
     * @return QueryBuilderPort Database adapter instance.
     */
    public function whereNotBetween(string $field, mixed $value1, mixed $value2): QueryBuilderPort;

    /**
     * Adds an IN condition to the SQL query.
     *
     * @param string $field The field for which the IN condition is to be set.
     * @param array $values Array of values.
     * @return QueryBuilderPort Database adapter instance.
     */
    public function whereIn(string $field, array $values): QueryBuilderPort;

    /**
     * Adds NOT IN condition to the SQL query.
     *
     * @param string $field The field for which the NOT IN condition is to be set.
     * @param array $values Array of values.
     * @return QueryBuilderPort Database adapter instance.
     */
    public function whereNotIn(string $field, array $values): QueryBuilderPort;


    /**
     * Adds GROUP BY condition to SQL query.
     *
     * @param string $groupBy The field by which results are grouped.
     * @return QueryBuilderPort Instance of the database adapter.
     */
    public function groupBy(string $groupBy): QueryBuilderPort;

    /**
     * Adds HAVING condition to SQL query.
     *
     * @param string $having HAVING condition.
     * @param array $parameters Parameters of the condition.
     * @return QueryBuilderPort Instance of the database adapter.
     */
    public function having(string $having, array $parameters = []): QueryBuilderPort;

    /**
     * Adds an ORDER BY condition to SQL query.
     *
     * @param string $orderBy The field by which results are sorted.
     * @param string $orderDirection The direction of sorting (ASC or DESC).
     * @return QueryBuilderPort Instance of the database adapter.
     */
    public function orderBy(string $orderBy, string $orderDirection = 'ASC'): QueryBuilderPort;

    /**
     * Sets result limit of SQL query.
     *
     * @param int $limit Result limit.
     * @return QueryBuilderPort Instance of the database adapter.
     */
    public function limit(int $limit): QueryBuilderPort;

    /**
     * Sets offset of SQL query results.
     *
     * @param int $offset Results offset.
     * @return QueryBuilderPort Instance of the database adapter.
     */
    public function offset(int $offset): QueryBuilderPort;

    /**
     * Checks if table exists in database.
     *
     * @param string $table Table name.
     * @return bool True if the table exists, otherwise false.
     */
    public function tableExists(string $table): bool;
}
