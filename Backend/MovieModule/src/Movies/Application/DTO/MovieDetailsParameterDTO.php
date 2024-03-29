<?php
declare(strict_types=1);

namespace App\Movies\Application\DTO;

/**
 * Represents the details parameters of a movie.
 */
final class MovieDetailsParameterDTO
{
    /**
     * Constructs a new MovieDetailsParameterDTO instance.
     *
     * @param array $productionCountry An array containing production country information.
     * @param array $directors An array containing directors information.
     * @param array $actors An array containing actors information.
     * @param array $category An array containing category information.
     * @param array $tags An array containing tags information.
     * @param array $languages An array containing languages information.
     * @param array $subtitles An array containing subtitles information.
     */
    public function __construct(
        public array $productionCountry,
        public array $directors,
        public array $actors,
        public array $category,
        public array $tags,
        public array $languages,
        public array $subtitles
    ) {
    }

    /**
     * Convert the movie details parameters to an associative array.
     *
     * @return array An array containing movie details parameters.
     */
    public function toArray(): array
    {
        return [
            'productionCountry' => $this->productionCountry,
            'directors' => $this->directors,
            'actors' => $this->actors,
            'category' => $this->category,
            'tags' => $this->tags,
            'languages' => $this->languages,
            'subtitles' => $this->subtitles,
        ];
    }
}
