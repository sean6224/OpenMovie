<?php
declare(strict_types=1);
namespace App\Movies\Infrastructure\Doctrine\Applicator\CriteriaSearch;

use Doctrine\ORM\QueryBuilder;

/**
 * Class DurationCriteriaApplicator
 *
 * Implements the CriteriaApplicatorInterface to apply duration criteria to query builder.
 */
class DurationCriteriaApplicator implements CriteriaApplicatorInterface
{
    /**
     * Applies duration criteria to provided query builder.
     *
     * @param QueryBuilder $queryBuilder The query builder instance.
     * @param array $criteria The criteria array containing duration filters.
     * @return void
     */
    public function apply(QueryBuilder $queryBuilder, array $criteria): void
    {
        if (isset($criteria['min-duration']) && $criteria['min-duration'] > 0) {
            $queryBuilder
                ->andWhere('m.duration >= :minDuration')
                ->setParameter('minDuration', $criteria['min-duration']);
        }

        if (isset($criteria['max-duration'])) {
            $queryBuilder
                ->andWhere('m.duration <= :maxDuration')
                ->setParameter('maxDuration', $criteria['max-duration']);
        }
    }
}
