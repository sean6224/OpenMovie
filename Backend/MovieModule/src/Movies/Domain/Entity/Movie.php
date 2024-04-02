<?php
declare(strict_types=1);
namespace App\Movies\Domain\Entity;

use App\Common\Domain\Entity\AggregateRoot;
use App\Common\Domain\ValueObject\DateTime;
use App\Common\Domain\ValueObject\Id;
use App\Movies\Domain\ValueObject\AgeRestriction;
use App\Movies\Domain\ValueObject\AverageRating;
use App\Movies\Domain\ValueObject\Description;
use App\Movies\Domain\ValueObject\Duration;
use App\Movies\Domain\ValueObject\MovieName;
use App\Movies\Domain\ValueObject\ProductionCountry;
use App\Movies\Domain\ValueObject\ReleaseYear;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * Class Movie
 *
 * Represents movie entity with basic information and associated details.
 */
class Movie extends AggregateRoot
{
    private Id $id;
    private MovieName $movieName;
    private Description $description;
    private ReleaseYear $releaseYear;
    private Duration $duration;
    private AgeRestriction $ageRestriction;
    private AverageRating $averageRating;
    private ProductionCountry $productionCountry;

    /** @var Collection<int, ProductionLocationManager> */
    private Collection $productionLocationsManager;
    /** @var Collection<int, DirectorsManager> */
    private Collection $directorsManager;
    /** @var Collection<int, ActorsManager> */
    private Collection $actorsManager;
    /** @var Collection<int, CategoryManager> */
    private Collection $categoryManager;
    /** @var Collection<int, LanguageManager> */
    private Collection $languageManager;
    /** @var Collection<int, SubtitlesManager> */
    private Collection $subtitlesManager;
    private DateTime $createdAt;

    private function __construct(
        array $movieBasic,
        array $movieDetails,
    ) {
        $this->id = Id::generate();
        $this->initialize($movieBasic);
        $this->createdAt = DateTime::now();
        $this->initializeCollection($movieDetails);
    }

    public static function create(
        array $movieBasic,
        array $movieDetails,
    ): self {
        return new self(
            movieBasic: $movieBasic,
            movieDetails: $movieDetails,
        );
    }

    private function initialize(array $movieBasic): void
    {
        $this->movieName = MovieName::fromString($movieBasic['movieName']);
        $this->description = Description::fromString($movieBasic['description']);
        $this->releaseYear = ReleaseYear::fromString($movieBasic['releaseYear']);
        $this->duration = Duration::fromInt($movieBasic['duration']);
        $this->ageRestriction = AgeRestriction::fromInt($movieBasic['ageRestriction']);
        $this->averageRating = AverageRating::fromFloat($movieBasic['averageRating']);
        $this->productionCountry = ProductionCountry::fromString($movieBasic['productionCountry']);
    }

    private function initializeCollection(array $movieDetails): void
    {
        $this->productionLocationsManager = new ArrayCollection();
        $this->directorsManager = new ArrayCollection();
        $this->actorsManager = new ArrayCollection();
        $this->categoryManager = new ArrayCollection();
        $this->languageManager = new ArrayCollection();
        $this->subtitlesManager = new ArrayCollection();

        $collectionMappings = [
            'productionLocations' => ProductionLocationManager::class,
            'directors' => DirectorsManager::class,
            'actors' => ActorsManager::class,
            'category' => CategoryManager::class,
            'languages' => LanguageManager::class,
            'subtitles' => SubtitlesManager::class,
        ];

        foreach ($collectionMappings as $detailKey => $managerClass) {
            $this->{$detailKey . 'Manager'} = $this->createCollection($movieDetails[$detailKey] ?? [], $managerClass);
        }
    }

    private function createCollection(array $items, string $managerClass): Collection
    {
        $collection = new ArrayCollection();
        foreach ($items as $item) {
            $manager = call_user_func([$managerClass, 'create'], $item, $this);
            $collection->add($manager);
        }
        return $collection;
    }

    /**
     * Retrieves the ID of object
     *
     * @return Id The ID of object
     */
    public function id(): Id
    {
        return $this->id;
    }

    /**
     * Returns name of movie.
     *
     * @return MovieName The name of movie.
     */
    public function getMovieName(): MovieName
    {
        return $this->movieName;
    }

    /**
     * Retrieves description of object.
     *
     * @return Description description of object.
     */
    public function getDescription(): Description
    {
        return $this->description;
    }

    /**
     * Get release year of movie.
     *
     * @return ReleaseYear release year of movie.
     */
    public function getReleaseYear(): ReleaseYear
    {
        return $this->releaseYear;
    }

    /**
     * Returns duration of movie.
     *
     * @return Duration duration of movie.
     */
    public function getDuration(): Duration
    {
        return $this->duration;
    }

    /**
     * Retrieve age restriction for movie.
     *
     * @return AgeRestriction age restriction of movie.
     */
    public function getAgeRestriction(): AgeRestriction
    {
        return $this->ageRestriction;
    }

    /**
     * Retrieve average rating for movie.
     *
     * @return AverageRating average rating of movie.
     */
    public function getAverageRating(): AverageRating
    {
        return $this->averageRating;
    }

    /**
     * Retrieve Production country for movie.
     *
     * @return ProductionCountry Production country of movie.
     */
    public function getProductionCountry(): ProductionCountry
    {
        return $this->productionCountry;
    }

    /**
     * Retrieve createdAt for movie.
     *
     * @return DateTime createdAt of movie.
     */
    public function getDateTime(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * Get the production locations associated with movie.
     *
     * @return array The production locations associated with movie.
     */
    public function getProductionLocationsManager(): array
    {
        return $this->productionLocationsManager->toArray();
    }

    /**
     * Get the directors of movie.
     *
     * @return array The directors of movie.
     */
    public function getDirectorsManager(): array
    {
        return $this->directorsManager->toArray();
    }

    /**
     * Get the actors of movie.
     *
     * @return array The actors of movie.
     */
    public function getActorsManager(): array
    {
        return $this->actorsManager->toArray();
    }

    /**
     * Get the category of movie.
     *
     * @return array The category of movie.
     */
    public function getCategoryManager(): array
    {
        return $this->categoryManager->toArray();
    }

    /**
     * Get the languages associated with movie.
     *
     * @return array The languages associated with movie.
     */
    public function getLanguagesManager(): array
    {
        return $this->languageManager->toArray();
    }

    /**
     * Get the subtitles associated with movie.
     *
     * @return array The subtitles associated with movie.
     */
    public function getSubtitlesManager(): array
    {
        return $this->subtitlesManager->toArray();
    }
}
