<?php
declare(strict_types=1);
namespace App\Common\Domain\Port\Database;

/**
 * Interface representing port for managing transactions and savepoints in database.
 */
interface TransactionManagerPort
{
    /**
     * Starts transaction in database.
     */
    public function beginTransaction(): void;

    /**
     * Creates savepoint within current transaction.
     *
     * @param string $name Savepoint name.
     */
    public function createSavepoint(string $name): void;

    /**
     * Releases previously created savepoint.
     *
     * @param string $name Savepoint name.
     */
    public function releaseSavepoint(string $name): void;

    /**
     * Rolls back to previously created savepoint.
     *
     * @param string $name Savepoint name.
     */
    public function rollBackToSavepoint(string $name): void;

    /**
     * Approves transaction.
     */
    public function commit(): void;

    /**
     * Withdraws transaction.
     */
    public function rollBack(): void;
}
