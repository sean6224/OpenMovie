<?php
declare(strict_types=1);
namespace App\Movies\Domain\Entity;

use App\Common\Domain\ValueObject\Id;
use App\Movies\Domain\ValueObject\MovieCategory;

class CategoryManager
{
    private Id $id;
    private MovieCategory $movieCategory;

    private function __construct(
        string $category,
        private readonly Movie $movie,
    ) {
        $this->id = Id::generate();
        $this->movieCategory = MovieCategory::fromString($category);
    }

    public static function create(
        string $category,
        Movie $movie,
    ): self {
        return new self($category, $movie);
    }

    /**
     * @return Id
     */
    public function getId(): Id
    {
        return $this->id;
    }

    /**
     * @return MovieCategory
     */
    public function getCategory(): MovieCategory
    {
        return $this->movieCategory;
    }

    public function movie(): Movie
    {
        return $this->movie;
    }

    public function __toString(): string
    {
        return $this->movieCategory->__toString();
    }
}
