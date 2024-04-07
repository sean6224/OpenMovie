<?php
declare(strict_types=1);
namespace App\Common\Infrastructure\Adapter\Database\Postgres;

use App\Common\Domain\Port\Database\TransactionManagerPort;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;

/**
 * Transaction manager for managing transactions in PostgreSQL database.
 */
class PostgreSqlTransactionManager implements TransactionManagerPort
{
    private Connection $connection;
    private int $savepointCounter = 0;
    private array $savepoints = [];

    /**
     * Constructs new PostgreSqlTransactionManager instance.
     *
     * @param Connection $connection Doctrine DBAL connection.
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Starts transaction in database.
     *
     * @throws Exception
     */
    public function beginTransaction(): void
    {
        $this->connection->beginTransaction();
        $this->savepointCounter = 0;
        $this->savepoints = [];
    }

    /**
     * Creates savepoint within current transaction.
     *
     * @param string $name Savepoint name.
     * @throws Exception
     */
    public function createSavepoint(string $name): void
    {
        $savepointName = 'savepoint_' . ++$this->savepointCounter;
        $this->connection->createSavepoint($savepointName);
        $this->savepoints[$name] = $savepointName;
    }

    /**
     * Releases previously created savepoint.
     *
     * @param string $name Savepoint name.
     * @throws Exception
     */
    public function releaseSavepoint(string $name): void
    {
        if (isset($this->savepoints[$name])) {
            $this->connection->releaseSavepoint($this->savepoints[$name]);
            unset($this->savepoints[$name]);
        }
    }

    /**
     * Rolls back to previously created savepoint.
     *
     * @param string $name Savepoint name.
     * @throws Exception
     */
    public function rollBackToSavepoint(string $name): void
    {
        if (isset($this->savepoints[$name])) {
            $this->connection->rollbackSavepoint($this->savepoints[$name]);
            unset($this->savepoints[$name]);
        }
    }

    /**
     * Approves transaction.
     *
     * @throws Exception
     */
    public function commit(): void
    {
        $this->connection->commit();
        $this->savepointCounter = 0;
        $this->savepoints = [];
    }

    /**
     * Withdraws transaction.
     *
     * @throws Exception
     */
    public function rollBack(): void
    {
        $this->connection->rollBack();
        $this->savepointCounter = 0;
        $this->savepoints = [];
    }
}
