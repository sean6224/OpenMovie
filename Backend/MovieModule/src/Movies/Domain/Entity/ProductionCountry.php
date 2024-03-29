<?php
declare(strict_types=1);
namespace App\Movies\Domain\Entity;

use App\Common\Domain\ValueObject\Id;
use App\Movies\Domain\ValueObject\MovieProductionCountry;

class ProductionCountry
{
    private Id $id;
    private MovieProductionCountry $productionCountry;

    private function __construct(
        string $country,
        private readonly Movie $movie,
    ) {
        $this->id = Id::generate();
        $this->productionCountry = MovieProductionCountry::fromString($country);
    }

    public static function create(
        string $country,
        Movie $movie,
    ): self {
        return new self($country, $movie);
    }

    /**
     * @return Id
     */
    public function getId(): Id
    {
        return $this->id;
    }

    /**
     * @return MovieProductionCountry
     */
    public function getProductionCountry(): MovieProductionCountry
    {
        return $this->productionCountry;
    }

    public function movie(): Movie
    {
        return $this->movie;
    }

    public function __toString(): string
    {
        return $this->productionCountry->__toString();
    }
}
