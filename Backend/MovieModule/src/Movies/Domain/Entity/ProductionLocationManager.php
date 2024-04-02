<?php
declare(strict_types=1);
namespace App\Movies\Domain\Entity;

use App\Common\Domain\ValueObject\Id;
use App\Movies\Domain\ValueObject\MovieProductionLocation;

class ProductionLocationManager
{
    private Id $id;
    private MovieProductionLocation $productionLocation;

    private function __construct(
        string $productionLocation,
        private readonly Movie $movie,
    ) {
        $this->id = Id::generate();
        $this->productionLocation = MovieProductionLocation::fromString($productionLocation);
    }

    public static function create(
        string $productionLocation,
        Movie $movie,
    ): self {
        return new self($productionLocation, $movie);
    }

    /**
     * @return Id
     */
    public function getId(): Id
    {
        return $this->id;
    }

    /**
     * @return MovieProductionLocation
     */
    public function getProductionCountry(): MovieProductionLocation
    {
        return $this->productionLocation;
    }

    public function movie(): Movie
    {
        return $this->movie;
    }

    public function __toString(): string
    {
        return $this->productionLocation->__toString();
    }
}
