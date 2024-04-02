<?php
declare(strict_types=1);
namespace App\Movies\Domain\Entity;

use App\Common\Domain\ValueObject\Id;
use App\Movies\Domain\ValueObject\MovieLanguage;

class LanguageManager
{
    private Id $id;
    private MovieLanguage $movieLanguage;

    private function __construct(
        string $language,
        private readonly Movie $movie,
    ) {
        $this->id = Id::generate();
        $this->movieLanguage = MovieLanguage::fromString($language);
    }

    public static function create(
        string $language,
        Movie $movie,
    ): self {
        return new self($language, $movie);
    }

    /**
     * @return Id
     */
    public function getId(): Id
    {
        return $this->id;
    }

    /**
     * @return MovieLanguage
     */
    public function getLanguage(): MovieLanguage
    {
        return $this->movieLanguage;
    }

    public function movie(): Movie
    {
        return $this->movie;
    }

    public function __toString(): string
    {
        return $this->movieLanguage->__toString();
    }
}
