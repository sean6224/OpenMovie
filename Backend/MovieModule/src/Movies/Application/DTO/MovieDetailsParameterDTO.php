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
     * @param array $productionLocations An array containing production locations information.
     * @param array $directors An array containing directors information.
     * @param array $actors An array containing actors information.
     * @param array $category An array containing category information.
     * @param array $languages An array containing languages information.
     * @param array $subtitles An array containing subtitles information.
     */
    public function __construct(
        public array $productionLocations,
        public array $directors,
        public array $actors,
        public array $category,
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
            'productionLocations' => $this->productionLocations,
            'directors' => $this->directors,
            'actors' => $this->actors,
            'category' => $this->category,
            'languages' => $this->languages,
            'subtitles' => $this->subtitles,
        ];
    }
}
