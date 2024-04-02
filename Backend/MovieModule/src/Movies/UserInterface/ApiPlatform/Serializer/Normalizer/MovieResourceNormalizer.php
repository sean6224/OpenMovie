<?php
declare(strict_types=1);
namespace App\Movies\UserInterface\ApiPlatform\Serializer\Normalizer;

use App\Movies\UserInterface\ApiPlatform\Resource\MovieResource;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * Normalizer for converting MovieResource objects to arrays.
 */
class MovieResourceNormalizer implements NormalizerInterface
{
    /**
     * Normalizes a MovieResource object into an array.
     *
     * @param MovieResource $object The MovieResource object to normalize
     * @param string|null $format The format being (de)serialized from or into
     * @param array $context Context options for the normalization process
     * @return array The normalized array
     */
    public function normalize($object, string $format = null, array $context = []): array
    {
        // Extracting basic movie information and details parameters
        $movieBasic = $object->movieBasic;
        $movieDetailsParameters = $object->movieDetailsParameters;
        $propertiesToNormalize = [
            'id' => $object->id,
            'movieName' => $movieBasic->movieName,
            'description' => $movieBasic->description,
            'releaseYear' => $movieBasic->releaseYear,
            'duration' => $movieBasic->duration,
            'ageRestriction' => $movieBasic->ageRestriction,
            'averageRating' => $movieBasic->averageRating,
            'productionCountry' => $movieBasic->productionCountry,
        ];

        // Normalizing collection properties from movie details parameters
        $propertiesToNormalize += $this->normalizeCollectionProperties($movieDetailsParameters);
        return $propertiesToNormalize;
    }

    /**
     * Normalizes collection properties from movie details parameters.
     *
     * @param object $movieDetailsParameters The movie details parameters object
     * @return array The normalized collection properties
     */
    private function normalizeCollectionProperties(object $movieDetailsParameters): array
    {
        // List of collection properties to normalize
        $propertiesToNormalize = [
            'productionLocations',
            'directors',
            'actors',
            'category',
            'languages',
            'subtitles',
        ];

        // Normalizing each collection property
        $normalizedData = [];
        foreach ($propertiesToNormalize as $property) {
            $normalizedData[$property] = $this->normalizeCollection($movieDetailsParameters->{$property});
        }
        return $normalizedData;
    }

    /**
     * Normalizes a collection to an array of string values.
     *
     * @param array $collection The collection to normalize
     * @return array The normalized collection
     */
    private function normalizeCollection(array $collection): array
    {
        return array_map('strval', $collection);
    }

    /**
     * Checks if the given data is supported for normalization.
     *
     * @param mixed $data The data to check for normalization support
     * @param string|null $format The format being (de)serialized from or into
     * @param array $context Context options for the normalization process
     * @return bool Whether the normalization is supported or not
     */
    public function supportsNormalization(mixed $data, string $format = null, array $context = []): bool
    {
        return $data instanceof MovieResource;
    }
}
