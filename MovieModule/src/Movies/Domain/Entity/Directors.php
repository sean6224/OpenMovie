<?php
declare(strict_types=1);
namespace App\Movies\Domain\Entity;

use App\Common\Domain\ValueObject\Id;
use App\Movies\Domain\ValueObject\MovieDirectors;

class Directors
{
    private Id $id;
    private MovieDirectors $movieDirectors;

    private function __construct(
        string $directors,
        private readonly Movie $movie,
    ) {
        $this->id = Id::generate();
        $this->movieDirectors = MovieDirectors::fromString($directors);
    }

    public static function create(
        string $directors,
        Movie $movie,
    ): self {
        return new self($directors, $movie);
    }

    /**
     * @return Id
     */
    public function getId(): Id
    {
        return $this->id;
    }

    /**
     * @return MovieDirectors
     */
    public function getDirectors(): MovieDirectors
    {
        return $this->movieDirectors;
    }

    public function movie(): Movie
    {
        return $this->movie;
    }

    public function __toString(): string
    {
        return $this->movieDirectors->__toString();
    }
}
