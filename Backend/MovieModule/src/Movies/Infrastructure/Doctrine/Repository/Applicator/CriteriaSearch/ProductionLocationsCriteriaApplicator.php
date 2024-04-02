<?php
declare(strict_types=1);
namespace App\Movies\Infrastructure\Doctrine\Repository\Applicator\CriteriaSearch;

use Doctrine\ORM\QueryBuilder;

/**
 * Class ProductionLocationsCriteriaApplicator
 *
 * Implements CriteriaApplicatorInterface to apply duration criteria to query builder.
 */
class ProductionLocationsCriteriaApplicator implements CriteriaApplicatorInterface
{
    /**
     * Applies production locations  criteria to provided query builder.
     *
     * @param QueryBuilder $queryBuilder The query builder instance.
     * @param array $criteria The criteria array containing duration filters.
     * @return void
     */
    public function apply(QueryBuilder $queryBuilder, array $criteria): void
    {
        if (!empty($criteria['productionLocations'])) {
            $queryBuilder
                ->leftJoin('m.productionLocationsManager', 'pc')
                ->andWhere($queryBuilder->expr()->in('pc.productionLocation', ':productionLocations'))
                ->setParameter('productionLocations', $criteria['productionLocations']);
        }
    }
}
