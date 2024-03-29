<?php
namespace App\Tests\Rating\Integration\InMemory;

use App\Tests\Rating\DummyFactory\DummyRatingFactory;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use App\Ratings\Infrastructure\InMemory\InMemoryRatingRepository;

class InMemoryRatingRepositoryTest extends KernelTestCase
{
    private ?InMemoryRatingRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new InMemoryRatingRepository();
    }

    /**
     * Tests saving rating entity to repository.
     */
    public function testAdd(): void
    {
        $rating = DummyRatingFactory::createRating();
        $this->repository->add($rating);

        $retrievedRating = $this->repository->get($rating->id());
        static::assertEquals($rating, $retrievedRating);
    }

    /**
     * Tests removing rating entity from repository.
     */
    public function testRemove(): void
    {
        $rating = DummyRatingFactory::createRating();
        $this->repository->add($rating);

        static::assertSame(1, $this->repository->count(), 'Repository should contain 1 rating before removing.');
        $this->repository->remove($rating);
        static::assertSame(0, $this->repository->count(), 'Repository should be empty after removing rating.');
    }

    /**
     * Tests retrieving rating entity by ID from repository.
     */
    public function testGetId(): void
    {
        $rating = DummyRatingFactory::createRating();
        $this->repository->add($rating);
        static::assertSame(1, $this->repository->count(), 'Repository should contain 1 rating after adding.');
        static::assertSame($rating, $this->repository->get($rating->id()), 'Retrieved movie should be same as one added.');
    }
}
