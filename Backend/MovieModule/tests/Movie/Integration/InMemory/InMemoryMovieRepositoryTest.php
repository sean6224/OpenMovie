<?php
namespace App\Tests\Movie\Integration\InMemory;

use App\Movies\Infrastructure\InMemory\InMemoryMovieRepository;
use App\Tests\Movie\DummyFactory\DummyMovieFactory;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class InMemoryMovieRepositoryTest extends KernelTestCase
{
    private ?InMemoryMovieRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new InMemoryMovieRepository();
    }

    /**
     * Tests saving movie entity to repository.
     */
    public function testAdd(): void
    {
        $movie = DummyMovieFactory::createMovie();
        $this->repository->add($movie);

        $retrievedMovie = $this->repository->get($movie->id());
        static::assertEquals($movie, $retrievedMovie);
    }

    /**
     * Tests removing movie entity from repository.
     */
    public function testRemove(): void
    {
        $movie = DummyMovieFactory::createMovie();
        $this->repository->add($movie);

        static::assertSame(1, $this->repository->count(), 'Repository should contain 1 movie before removing.');
        $this->repository->remove($movie);
        static::assertSame(0, $this->repository->count(), 'Repository should be empty after removing the movie.');
    }

    /**
     * Tests retrieving movie entity by its ID from repository.
     */
    public function testGetId(): void
    {
        $movie = DummyMovieFactory::createMovie();
        $this->repository->add($movie);
        static::assertSame(1, $this->repository->count(), 'Repository should contain 1 movie after adding.');
        static::assertSame($movie, $this->repository->get($movie->id()), 'Retrieved movie should be the same as the one added.');
    }
}
