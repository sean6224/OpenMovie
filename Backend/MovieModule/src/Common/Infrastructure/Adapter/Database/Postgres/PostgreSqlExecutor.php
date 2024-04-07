<?php
declare(strict_types=1);
namespace App\Common\Infrastructure\Adapter\Database\Postgres;

use App\Common\Domain\Port\Database\QueryExecutorPort;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
/**
 * PostgreSQL adapter for executing SQL queries and updates using Doctrine DBAL.
 */
class PostgreSqlExecutor implements QueryExecutorPort
{
    private Connection $connection;

    /**
     * Constructs new PostgreSqlExecutor instance.
     *
     * @param Connection $connection Doctrine DBAL connection.
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Executes an SQL query and returns results as an associative array.
     *
     * @param string $query SQL query.
     * @param array $parameters Query parameters.
     * @return array An associative array with the results of the query.
     * @throws Exception
     */
    public function executeQuery(string $query, array $parameters = []): array
    {
        $this->connection->beginTransaction();
        try {
            $statement = $this->connection->prepare($query);
            $statement->executeStatement($parameters);
            $results = $statement->fetchAllAssociative();
            $this->connection->commit();
            return $results;
        } catch (Exception $exception) {
            $this->connection->rollBack();
            throw $exception;
        }
    }

    /**
     * Executes database update query (INSERT, UPDATE, DELETE) and returns number of modified records.
     *
     * @param string $query SQL query.
     * @param array $parameters Query parameters.
     * @return int Number of modified records.
     * @throws Exception
     */
    public function executeUpdate(string $query, array $parameters = []): int
    {
        $this->connection->beginTransaction();
        try {
            $statement = $this->connection->prepare($query);
            $statement->executeStatement($parameters);
            $affectedRows = $statement->rowCount();
            $this->connection->commit();
            return $affectedRows;
        } catch (Exception $exception) {
            $this->connection->rollBack();
            throw $exception;
        }
    }
}
