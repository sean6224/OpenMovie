<?php
declare(strict_types=1);
namespace App\Common\Domain\Port;

use App\Common\Domain\Port\Database\DataFetcherPort;
use App\Common\Domain\Port\Database\QueryBuilderPort;
use App\Common\Domain\Port\Database\QueryExecutorPort;
use App\Common\Domain\Port\Database\TransactionManagerPort;

/**
 * Interface representing port for interacting with database.
 */
interface DatabaseAdapterPort extends DataFetcherPort, QueryBuilderPort, QueryExecutorPort, TransactionManagerPort
{

}
