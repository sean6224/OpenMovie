<?php
declare(strict_types=1);
namespace App\Movies\Domain\Entity;

use App\Common\Domain\ValueObject\Id;
use App\Movies\Domain\ValueObject\MovieSubtitles;

class SubtitlesManager
{
    private Id $id;
    private MovieSubtitles $movieSubtitles;

    private function __construct(
        string $subtitles,
        private readonly Movie $movie,
    ) {
        $this->id = Id::generate();
        $this->movieSubtitles = MovieSubtitles::fromString($subtitles);
    }

    public static function create(
        string $subtitles,
        Movie $movie,
    ): self {
        return new self($subtitles, $movie);
    }

    /**
     * @return Id
     */
    public function getId(): Id
    {
        return $this->id;
    }

    /**
     * @return MovieSubtitles
     */
    public function getLanguage(): MovieSubtitles
    {
        return $this->movieSubtitles;
    }

    public function movie(): Movie
    {
        return $this->movie;
    }

    public function __toString(): string
    {
        return $this->movieSubtitles->__toString();
    }
}
