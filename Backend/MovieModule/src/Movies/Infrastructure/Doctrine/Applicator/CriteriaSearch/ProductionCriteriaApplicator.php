<?php
declare(strict_types=1);
namespace App\Movies\Infrastructure\Doctrine\Applicator\CriteriaSearch;

use Doctrine\ORM\QueryBuilder;

/**
 * Class ProductionCriteriaApplicator
 *
 * Implements CriteriaApplicatorInterface to apply production country criteria to query builder.
 */
class ProductionCriteriaApplicator implements CriteriaApplicatorInterface
{
    /**
     * Applies production country  criteria to provided query builder.
     *
     * @param QueryBuilder $queryBuilder The query builder instance.
     * @param array $criteria The criteria array containing duration filters.
     * @return void
     */
    public function apply(QueryBuilder $queryBuilder, array $criteria): void
    {
        if (!empty($criteria['productionCountry'])) {
            $queryBuilder
                ->andWhere('m.productionCountry = :productionCountry')
                ->setParameter('productionCountry', $criteria['productionCountry']);
        }
    }
}
