<?php
declare(strict_types=1);
namespace App\Movies\Domain\Entity;

use App\Common\Domain\ValueObject\Id;
use App\Movies\Domain\ValueObject\MovieActors;

class Actors
{
    private Id $id;
    private MovieActors $movieActor;

    private function __construct(
        string $actor,
        private readonly Movie $movie,
    ) {
        $this->id = Id::generate();
        $this->movieActor = MovieActors::fromString($actor);
    }

    public static function create(
        string $actor,
        Movie $movie,
    ): self {
        return new self($actor, $movie);
    }

    /**
     * @return Id
     */
    public function getId(): Id
    {
        return $this->id;
    }

    /**
     * @return MovieActors
     */
    public function getActors(): MovieActors
    {
        return $this->movieActor;
    }

    public function movie(): Movie
    {
        return $this->movie;
    }

    public function __toString(): string
    {
        return $this->movieActor->__toString();
    }
}
