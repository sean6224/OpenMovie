<?php
declare(strict_types=1);
namespace App\Movies\Infrastructure\Doctrine\Repository\Applicator;

use App\Movies\Infrastructure\Doctrine\Repository\Applicator\CriteriaSearch\DurationCriteriaApplicator;
use App\Movies\Infrastructure\Doctrine\Repository\Applicator\CriteriaSearch\ProductionLocationsCriteriaApplicator;
use Doctrine\ORM\QueryBuilder;

/**
 * Class MovieCriteriaApplicator
 *
 * Applies various criteria to query builder.
 */
class MovieCriteriaApplicator
{
    private ?DurationCriteriaApplicator $durationApplicator = null;
    private ?ProductionLocationsCriteriaApplicator $locationsApplicator = null;

    /**
     * Applies various criteria to given query builder.
     *
     * @param QueryBuilder $queryBuilder The query builder instance.
     * @param array $criteria The criteria array containing various filters.
     * @return void
     */
    public function applyCriteria(QueryBuilder $queryBuilder, array $criteria): void
    {
        if (!empty($criteria['min-duration']) || !empty($criteria['max-duration'])) {
            $this->getDurationApplicator()->apply($queryBuilder, $criteria);
        }

        if (!empty($criteria['productionLocations'])) {
            $this->getLocationsApplicator()->apply($queryBuilder, $criteria);
        }
    }

    /**
     * Retrieves or initializes the DurationCriteriaApplicator.
     *
     * @return DurationCriteriaApplicator
     */
    private function getDurationApplicator(): DurationCriteriaApplicator
    {
        if ($this->durationApplicator === null) {
            $this->durationApplicator = new DurationCriteriaApplicator();
        }
        return $this->durationApplicator;
    }

    /**
     * Retrieves or initializes the ProductionLocationsCriteriaApplicator.
     *
     * @return ProductionLocationsCriteriaApplicator
     */
    private function getLocationsApplicator(): ProductionLocationsCriteriaApplicator
    {
        if ($this->locationsApplicator === null) {
            $this->locationsApplicator = new ProductionLocationsCriteriaApplicator();
        }
        return $this->locationsApplicator;
    }

}
