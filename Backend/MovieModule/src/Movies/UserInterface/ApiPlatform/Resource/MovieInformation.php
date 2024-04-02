<?php
declare(strict_types=1);
namespace App\Movies\UserInterface\ApiPlatform\Resource;

use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Represents the parameters related to a movie resource in the API.
 */
class MovieInformation
{
    /**
     * @var string|null The ID of the movie.
     * @Groups({"read"})
     */
    public ?string $id = null;

    /**
     * @var string|null The name of the movie.
     * @Groups({"read", "create"})
     */
    public ?string $movieName = null;

    /**
     * @var string|null The description of the movie.
     * @Groups({"read", "create"})
     */
    public ?string $description = null;

    /**
     * @var string|null The release year of the movie.
     * @Groups({"read", "create"})
     */
    public ?string $releaseYear = null;

    /**
     * @var string|null The production countries of the movie.
     * @Groups({"read", "create"})
     */
    public ?string $productionCountry = null;

    /**
     * @var array The production locations of the movie.
     * @Groups({"read", "create"})
     */
    public array $productionLocations = [];

    /**
     * @var array The directors of the movie.
     * @Groups({"read", "create"})
     */
    public array $directors = [];

    /**
     * @var array The actors in the movie.
     * @Groups({"read", "create"})
     */
    public array $actors = [];

    /**
     * @var array The categories or genres of the movie.
     * @Groups({"read", "create"})
     */
    public array $category = [];

    /**
     * @var array The languages spoken in the movie.
     * @Groups({"read", "create"})
     */
    public array $languages = [];

    /**
     * @var array The available subtitles for the movie.
     * @Groups({"read", "create"})
     */
    public array $subtitles = [];

    /**
     * @var int The duration of the movie in minutes.
     * @Groups({"read", "create"})
     */
    public int $duration = 0;

    /**
     * @var int The age restriction or rating for the movie.
     * @Groups({"read", "create"})
     */
    public int $ageRestriction = 0;

    /**
     * @var float The average rating for the movie.
     * @Groups({"read", "create"})
     */
    public float $averageRating = 0.0;
}
