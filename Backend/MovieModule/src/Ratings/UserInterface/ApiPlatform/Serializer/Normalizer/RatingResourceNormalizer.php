<?php
declare(strict_types=1);
namespace App\Ratings\UserInterface\ApiPlatform\Serializer\Normalizer;

use App\Ratings\UserInterface\ApiPlatform\Resource\RatingResource;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * Normalizer for converting RatingResource objects to arrays.
 */
class RatingResourceNormalizer implements NormalizerInterface
{
    /**
     * Normalizes a RatingResource object into an array.
     *
     * @param RatingResource $object The RatingResource object to normalize
     * @param string|null $format The format being (de)serialized from or into
     * @param array $context Context options for the normalization process
     * @return array The normalized array
     */
    public function normalize($object, string $format = null, array $context = []): array
    {
        return [
            'id' => $object->id,
            'movieId' => $object->movieId,
            'userId' => $object->userId,
            'averageRating' => $object->averageRating,
        ];
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
        return $data instanceof RatingResource;
    }
}
