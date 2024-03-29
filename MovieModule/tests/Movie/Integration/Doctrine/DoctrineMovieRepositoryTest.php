<?php
namespace App\Tests\Movie\Integration\Doctrine;

use App\Movies\Infrastructure\Doctrine\Repository\DoctrineMovieRepository;
use App\Tests\Movie\DummyFactory\DummyMovieFactory;
use Doctrine\DBAL\Exception;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Exception\ExceptionInterface;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;

/**
 * Test case for testing the DoctrineMovieRepository class.
 */
class DoctrineMovieRepositoryTest extends KernelTestCase
{
    private static EntityManagerInterface $em;

    /**
     * Sets up the test environment before running test suite.
     *
     * @throws ExceptionInterface
     */
    public static function setUpBeforeClass(): void
    {
        static::bootKernel();

        (new Application(static::$kernel))
            ->find('doctrine:database:create')
            ->run(new ArrayInput(['--if-not-exists' => true]), new NullOutput());

        (new Application(static::$kernel))
            ->find('doctrine:schema:update')
            ->run(new ArrayInput(['--force' => true]), new NullOutput());
    }

    /**
     * Sets up test environment before each test case.
     *
     * @throws Exception
     * @throws \Exception
     */
    protected function setUp(): void
    {
        parent::setUp();

        static::$em = static::getContainer()->get(EntityManagerInterface::class);

        $connection = static::$em->getConnection();
        $platform = $connection->getDatabasePlatform();
        $connection->executeStatement($platform->getTruncateTableSQL('movies', true));
    }

    /**
     * Tests saving movie entity to repository.
     *
     * @throws \Exception
     */
    public function testSave(): void
    {
        /** @var DoctrineMovieRepository $repository */
        $repository = static::getContainer()->get(DoctrineMovieRepository::class);

        $movies = DummyMovieFactory::createMovie();
        $repository->add($movies);
        self::$em->flush();

        static::assertNotNull($repository->find($movies->id()));
    }

    /**
     * Tests removing movie entity from repository.
     *
     * @throws \Exception
     */
    public function testRemove(): void
    {
        /** @var DoctrineMovieRepository $repository */
        $repository = static::getContainer()->get(DoctrineMovieRepository::class);

        $movie = DummyMovieFactory::createMovie();
        $repository->add($movie);
        self::$em->flush();

        static::assertNotNull($repository->find($movie->id()));
        $repository->remove($movie);
        self::$em->flush();

        static::assertNull($repository->find($movie->id()));
    }

    /**
     * Tests retrieving movie entity by ID from repository.
     *
     * @throws \Exception
     */
    public function testGetId(): void
    {
        /** @var DoctrineMovieRepository $repository */
        $repository = static::getContainer()->get(DoctrineMovieRepository::class);

        $movie = DummyMovieFactory::createMovie();
        $repository->add($movie);
        self::$em->flush();
        self::$em->clear();

        $retrievedMovie = $repository->get($movie->id());
        static::assertEquals($movie->id(), $retrievedMovie->id());
    }
}
