<?php
declare(strict_types=1);
namespace App\Common\Domain\Port\Database;

/**
* Interface representing a port for managing transactions in the database.
*/
interface TransactionManagerPort
{
    /**
     * Starts transaction in database.
     */
    public function beginTransaction(): void;

    /**
     * Approves transaction.
     */
    public function commit(): void;

    /**
     * Withdraws transaction.
     */
    public function rollBack(): void;
}
