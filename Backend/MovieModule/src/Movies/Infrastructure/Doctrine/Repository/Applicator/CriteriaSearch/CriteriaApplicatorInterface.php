<?php
declare(strict_types=1);
namespace App\Movies\Infrastructure\Doctrine\Repository\Applicator\CriteriaSearch;

use Doctrine\ORM\QueryBuilder;

/**
 * Interface CriteriaApplicatorInterface
 *
 * Represents an interface for applying criteria to query builder.
 */
interface CriteriaApplicatorInterface
{
    /**
     * Applies criteria to query builder.
     *
     * @param QueryBuilder $queryBuilder The query builder instance.
     * @param array $criteria The criteria array to be applied.
     * @return void
     */
    public function apply(QueryBuilder $queryBuilder, array $criteria): void;
}
