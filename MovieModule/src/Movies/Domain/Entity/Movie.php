<?php
declare(strict_types=1);
namespace App\Movies\Domain\Entity;

use App\Common\Domain\Entity\AggregateRoot;
use App\Common\Domain\ValueObject\DateTime;
use App\Common\Domain\ValueObject\Id;

use App\Movies\Domain\ValueObject\MovieName;
use App\Movies\Domain\ValueObject\Description;
use App\Movies\Domain\ValueObject\ReleaseYear;
use App\Movies\Domain\ValueObject\Duration;
use App\Movies\Domain\ValueObject\AgeRestriction;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
class Movie extends AggregateRoot
{
    private Id $id;
    private MovieName $movieName;
    private Description $description;
    private ReleaseYear $releaseYear;
    private Duration $duration;
    private AgeRestriction $ageRestriction;

    /** @var Collection<int, ProductionCountry> */
    private Collection $productionCountries;
    /** @var Collection<int, Directors> */
    private Collection $directors;
    /** @var Collection<int, Actors> */
    private Collection $actors;
    /** @var Collection<int, Category> */
    private Collection $category;
    /** @var Collection<int, Language> */
    private Collection $language;
    /** @var Collection<int, Subtitles> */
    private Collection $subtitles;

    private DateTime $createdAt;
    private function __construct(
        MovieName $movieName,
        Description $description,
        ReleaseYear $releaseYear,
        array $movieDetails,
        Duration $duration,
        AgeRestriction $ageRestriction,
    ) {

        $this->id = Id::generate();
        $this->createdAt = DateTime::now();

        $this->movieName = $movieName;
        $this->description = $description;
        $this->releaseYear = $releaseYear;

        $this->initializeCollections($movieDetails);
        $this->duration = $duration;
        $this->ageRestriction = $ageRestriction;
    }

    /**
     * Create a new instance of the class.
     *
     * @param MovieName $movieName The name of the movie.
     * @param Description $description The description of the movie.
     * @param ReleaseYear $releaseYear The release year of the movie.
     * @param Duration $duration The duration of the movie.
     * @param AgeRestriction $ageRestriction The age restriction of the movie.
     * @return self A new instance of the class with the specified parameters.
     */
    public static function create(
        MovieName $movieName,
        Description $description,
        ReleaseYear $releaseYear,
        array $movieDetails,
        Duration $duration,
        AgeRestriction $ageRestriction,
    ): self {
        return new self(
            movieName: $movieName,
            description: $description,
            releaseYear: $releaseYear,
            movieDetails: $movieDetails,
            duration: $duration,
            ageRestriction: $ageRestriction
        );
    }

    /**
     * Updates the movie entity with the provided data.
     *
     * @param MovieName|null $movieName The new movie name, or null to keep the existing one.
     * @param Description|null $description The new movie description, or null to keep the existing one.
     * @param ReleaseYear|null $releaseYear The new release year, or null to keep the existing one.
     * @param array|null $movieDetails The new movie details, or null to keep the existing ones.
     * @param Duration|null $duration The new movie duration, or null to keep the existing one.
     * @param AgeRestriction|null $ageRestriction The new age restriction, or null to keep the existing one.
     * @return void
     */
    public function update(
        ?MovieName $movieName = null,
        ?Description $description = null,
        ?ReleaseYear $releaseYear = null,
        ?array $movieDetails = null,
        ?Duration $duration = null,
        ?AgeRestriction $ageRestriction = null
    ): void {
        $this->movieName = $movieName ?? $this->movieName;
        $this->description = $description ?? $this->description;
        $this->releaseYear = $releaseYear ?? $this->releaseYear;
        $this->duration = $duration ?? $this->duration;
        $this->ageRestriction = $ageRestriction ?? $this->ageRestriction;

        if ($movieDetails !== null) {
            $this->initializeCollections($movieDetails);
        }
    }

    /**
     * Initialize collections for movie details.
     *
     * This method initializes various collections for movie details such as production country, directors, actors,
     * category, languages, and subtitles.
     *
     * @param array $movieDetails The array containing movie details.
     * @return void
     */
    private function initializeCollections(array $movieDetails): void
    {
        $this->productionCountries = new ArrayCollection();
        $this->directors = new ArrayCollection();
        $this->actors = new ArrayCollection();
        $this->category = new ArrayCollection();
        $this->language = new ArrayCollection();
        $this->subtitles = new ArrayCollection();

        $collectionMappings = [
            'productionCountry' => ProductionCountry::class,
            'directors' => Directors::class,
            'actors' => Actors::class,
            'category' => Category::class,
            'languages' => Language::class,
            'subtitles' => Subtitles::class,
        ];

        foreach ($collectionMappings as $collectionName => $class)
        {
            $this->initializeCollectionFor($collectionName, $class, $movieDetails);
        }
    }

    /**
     * Initialize a specific collection for movie details.
     *
     * This method initializes a specific collection for movie details based on the provided collection name and class.
     *
     * @param string $collectionName The name of collection to initialize.
     * @param string $class The class name of collection.
     * @param array $movieDetails The array containing movie details.
     * @return void
     */
    private function initializeCollectionFor(string $collectionName, string $class, array $movieDetails): void
    {
        $addMethod = 'add' . ucfirst($collectionName);
        $objects = array_map(
            fn($item) => $class::create($item, $this),
            $movieDetails[$collectionName]
        );
        array_map([$this, $addMethod], $objects);
    }

    /**
     * Add a production country to the movie.
     *
     * @param ProductionCountry $productionCountry The production country to add.
     * @return void
     */
    public function addProductionCountry(ProductionCountry $productionCountry): void
    {
        $this->productionCountries->add($productionCountry);
    }

    /**
     * Add directors to the movie.
     *
     * @param Directors $directors The directors to add.
     * @return void
     */
    public function addDirectors(Directors $directors): void
    {
        $this->directors->add($directors);
    }

    /**
     * Add actors to the movie.
     *
     * @param Actors $actors The actors to add.
     * @return void
     */
    public function addActors(Actors $actors): void
    {
        $this->actors->add($actors);
    }

    /**
     * Add a category to the movie.
     *
     * @param Category $category The category to add.
     * @return void
     */
    public function addCategory(Category $category): void
    {
        $this->category->add($category);
    }

    /**
     * Add languages to the movie.
     *
     * @param Language $language The languages to add.
     * @return void
     */
    public function addLanguages(Language $language): void
    {
        $this->language->add($language);
    }

    /**
     * Add subtitles to the movie.
     *
     * @param Subtitles $subtitles The subtitles to add.
     * @return void
     */
    public function addSubtitles(Subtitles $subtitles): void
    {
        $this->subtitles->add($subtitles);
    }

    /**
     * Get the production countries associated with the movie.
     *
     * @return array The production countries associated with the movie.
     */
    public function productionCountry(): array
    {
        return $this->productionCountries->toArray();
    }

    /**
     * Get the directors of the movie.
     *
     * @return array The directors of the movie.
     */
    public function Directors(): array
    {
        return $this->directors->toArray();
    }

    /**
     * Get the actors of the movie.
     *
     * @return array The actors of the movie.
     */
    public function Actors(): array
    {
        return $this->actors->toArray();
    }

    /**
     * Get the category of the movie.
     *
     * @return array The category of the movie.
     */
    public function Category(): array
    {
        return $this->category->toArray();
    }

    /**
     * Get the languages associated with the movie.
     *
     * @return array The languages associated with the movie.
     */
    public function Languages(): array
    {
        return $this->language->toArray();
    }

    /**
     * Get the subtitles associated with the movie.
     *
     * @return array The subtitles associated with the movie.
     */
    public function Subtitles(): array
    {
        return $this->subtitles->toArray();
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
     * Returns name of the movie.
     *
     * @return MovieName The name of movie.
     */
    public function getMovieName(): MovieName
    {
        return $this->movieName;
    }

    /**
     * Retrieves the description of object.
     *
     * @return Description The description of object.
     */
    public function getDescription(): Description
    {
        return $this->description;
    }

    /**
     * Get the release year of movie.
     *
     * @return ReleaseYear The release year of movie.
     */
    public function getReleaseYear(): ReleaseYear
    {
        return $this->releaseYear;
    }

    /**
     * Returns the duration of a movie.
     *
     * @return Duration The duration of movie.
     */
    public function getDuration(): Duration
    {
        return $this->duration;
    }

    /**
     * Retrieve the age restriction for a movie.
     *
     * @return AgeRestriction The age restriction of movie.
     */
    public function getAgeRestriction(): AgeRestriction
    {
        return $this->ageRestriction;
    }

    /**
     * Retrieve the createdAt for a movie.
     *
     * @return DateTime The createdAt of movie.
     */
    public function getDateTime(): DateTime
    {
        return $this->createdAt;
    }
}
