<?php
declare(strict_types=1);
namespace App\Movies\UserInterface\ApiPlatform\Resource;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Patch;

use App\Movies\Application\DTO\MovieBasicDTO;
use App\Movies\Application\DTO\MovieDetailsParameterDTO;
use App\Movies\Application\DTO\MovieDTO;
use App\Movies\UserInterface\ApiPlatform\Processor\CreateMovieProcessor;
use App\Movies\UserInterface\ApiPlatform\Processor\DeleteMovieProcessor;
use App\Movies\UserInterface\ApiPlatform\Processor\PatchMovieProcessor;
use App\Movies\UserInterface\ApiPlatform\Provider\MoviesCollectionProvider;
use App\Movies\UserInterface\ApiPlatform\Provider\SingleMovieProvider;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Represents a resource for movies.
 *
 * This class defines the API resource for managing movies, including endpoints for creating, retrieving, and listing movies.
 */
#[ApiResource(
    shortName: 'MovieResource',
    operations: [
        new Post(
            uriTemplate: 'movies/add',
            openapiContext: ['summary' => 'Create movies'],
            denormalizationContext: ['groups' => ['create']],
            validationContext: ['groups' => ['create']],
            processor: CreateMovieProcessor::class,
        ),
        new GetCollection(
            uriTemplate: 'movies/get',
            openapiContext: ['summary' => 'List all movies.'],
            provider: MoviesCollectionProvider::class,
        ),
        new Get(
            uriTemplate: 'movies/{id}',
            openapiContext: ['summary' => 'Get movie'],
            provider: SingleMovieProvider::class,
        ),
        new Delete(
            uriTemplate: 'movies/{id}',
            openapiContext: ['summary' => 'Delete Movie.'],
            provider: SingleMovieProvider::class,
            processor: DeleteMovieProcessor::class,
        ),
        new Patch(
            uriTemplate: 'movies/{id}',
            openapiContext: ['summary' => 'Update Movie.'],
            provider: SingleMovieProvider::class,
            processor: PatchMovieProcessor::class,
        )
    ]
)]

class MovieResource
{
    #[Groups(["create"])]
    public MovieInformation $movieInformation;

    public MovieBasicDTO $movieBasic;
    public MovieDetailsParameterDTO $movieDetailsParameters;

    /**
     * Constructs a new MovieResource instance.
     *
     * @param MovieBasicDTO $movieBasic The basic information about the movie.
     * @param MovieDetailsParameterDTO $movieDetailsParameters The detailed parameters of the movie.
     * @param string|null $id The ID of the movie resource.
     */
    public function __construct(
        MovieBasicDTO $movieBasic,
        MovieDetailsParameterDTO $movieDetailsParameters,
        public ?string $id = null
    ) {
        $this->movieBasic = $movieBasic;
        $this->movieDetailsParameters = $movieDetailsParameters;
    }

    /**
     * Creates a MovieResource instance from a MovieDTO object.
     *
     * @param MovieDTO $movieDTO The MovieDTO object containing movie information.
     * @return MovieResource The MovieResource instance created from the MovieDTO.
     */
    public static function fromMovieDTO(MovieDTO $movieDTO): MovieResource
    {
        $movieBasic = $movieDTO->movieBasic;
        $movieDetailsParameters = $movieDTO->movieDetailsParameters;

        $movieData = new MovieBasicDTO(
            movieName: $movieBasic->movieName,
            description: $movieBasic->description,
            releaseYear: $movieBasic->releaseYear,
            duration: $movieBasic->duration,
            ageRestriction: $movieBasic->ageRestriction,
        );

        $movieDetails = new MovieDetailsParameterDTO(
            productionCountry: $movieDetailsParameters->productionCountry,
            directors: $movieDetailsParameters->directors,
            actors: $movieDetailsParameters->actors,
            category: $movieDetailsParameters->category,
            tags: $movieDetailsParameters->tags,
            languages: $movieDetailsParameters->languages,
            subtitles: $movieDetailsParameters->subtitles,
        );

        return new self(
            movieBasic: $movieData,
            movieDetailsParameters: $movieDetails,
            id: $movieDTO->id,
        );
    }
}
