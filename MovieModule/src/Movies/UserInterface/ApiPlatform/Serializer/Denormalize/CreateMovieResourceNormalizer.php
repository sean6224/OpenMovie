<?php
declare(strict_types=1);

namespace App\Movies\UserInterface\ApiPlatform\Serializer\Denormalize;

use App\Movies\Application\DTO\MovieBasicDTO;
use App\Movies\Application\DTO\MovieDetailsParameterDTO;
use App\Movies\UserInterface\ApiPlatform\Resource\MovieInformation;
use App\Movies\UserInterface\ApiPlatform\Resource\MovieResource;
use InvalidArgumentException;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

/**
 * Class CreateMovieResourceNormalizer
 *
 * Normalizes array data into a MovieResource object.
 */
class CreateMovieResourceNormalizer implements DenormalizerInterface
{
    /**
     * Denormalizes array data into a MovieResource object.
     *
     * @param mixed $data The data to denormalize
     * @param string $type The type of the normalized object
     * @param string|null $format The format being (de)serialized from or into
     * @param array $context Context options for the denormalization process
     * @return MovieResource The denormalized MovieResource object
     * @throws InvalidArgumentException if movie information is missing in the data
     */
    public function denormalize(mixed $data, string $type, ?string $format = null, array $context = []): MovieResource
    {
        if (!isset($data['movieInformation'])) {
            throw new InvalidArgumentException('Missing movie information');
        }

        $movieInformationData = $data['movieInformation'];

        $movieInformation = new MovieInformation();
        $movieInformation->movieName = $movieInformationData['movieName'] ?? '';
        $movieInformation->description = $movieInformationData['description'] ?? '';
        $movieInformation->releaseYear = $movieInformationData['releaseYear'] ?? '';
        $movieInformation->duration = $movieInformationData['duration'] ?? 0;
        $movieInformation->ageRestriction = $movieInformationData['ageRestriction'] ?? 0;
        $movieInformation->averageRating = $movieInformationData['averageRating'] ?? 0.0;

        $movieDetailsParameters = new MovieDetailsParameterDTO(
            productionCountry: $movieInformationData['productionCountry'] ?? [],
            directors: $movieInformationData['directors'] ?? [],
            actors: $movieInformationData['actors'] ?? [],
            category: $movieInformationData['category'] ?? [],
            tags: $movieInformationData['tags'] ?? [],
            languages: $movieInformationData['languages'] ?? [],
            subtitles: $movieInformationData['subtitles'] ?? []
        );

        return new MovieResource(
            movieBasic: new MovieBasicDTO(
                movieName: $movieInformation->movieName,
                description: $movieInformation->description,
                releaseYear: $movieInformation->releaseYear,
                duration: $movieInformation->duration,
                ageRestriction: $movieInformation->ageRestriction,
                averageRating: $movieInformation->averageRating
            ),
            movieDetailsParameters: $movieDetailsParameters
        );
    }

    /**
     * Checks if the given data is supported for denormalization.
     *
     * @param mixed $data The data to check for denormalization support
     * @param string $type The type of the normalized object
     * @param string|null $format The format being (de)serialized from or into
     * @param array $context Context options for the denormalization process
     * @return bool Whether the denormalization is supported or not
     */
    public function supportsDenormalization(mixed $data, string $type, ?string $format = null, array $context = []): bool
    {
        return $type === MovieResource::class;
    }
}
