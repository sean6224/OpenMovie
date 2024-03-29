<?php
namespace App\Tests\Rating\DummyFactory;

use App\Common\Domain\ValueObject\UserId;
use App\Ratings\Domain\Entity\Rating;
use App\Ratings\Domain\ValueObject\AverageRating;
use App\Ratings\Domain\ValueObject\MovieId;
use Faker\Factory;

class DummyRatingFactory
{
    private function __construct() {
    }


    public static function createRating(): Rating
    {
        $faker = Factory::create();
        $value = $faker->randomFloat(null, 1, 5);
        $roundedValue = round($value, 1);
        return Rating::create(
            MovieId::fromString($faker->uuid()),
            UserId::fromString($faker->uuid()),
            AverageRating::fromFloat($roundedValue)
        );
    }
}
