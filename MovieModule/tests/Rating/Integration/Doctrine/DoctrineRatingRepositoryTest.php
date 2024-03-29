<?php
namespace App\Tests\Rating\Integration\Doctrine;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Exception\ExceptionInterface;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;
use Doctrine\DBAL\Exception;
use App\Ratings\Infrastructure\Doctrine\Repository\DoctrineRatingRepository;
use App\Tests\Rating\DummyFactory\DummyRatingFactory;

/**
 * Test case for testing the DoctrineRatingRepositoryTest class.
 */
class DoctrineRatingRepositoryTest extends KernelTestCase
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
        $connection->executeStatement($platform->getTruncateTableSQL('rating', true));
    }

    /**
     * Tests saving rating entity to repository.
     *
     * @throws \Exception
     */
    public function testSave(): void
    {
        /** @var DoctrineRatingRepository $repository */
        $repository = static::getContainer()->get(DoctrineRatingRepository::class);

        $rating = DummyRatingFactory::createRating();
        $repository->add($rating);
        self::$em->flush();

        static::assertNotNull($repository->find($rating->id()));
    }

    /**
     * Tests removing rating entity from repository.
     *
     * @throws \Exception
     */
    public function testRemove(): void
    {
        /** @var DoctrineRatingRepository $repository */
        $repository = static::getContainer()->get(DoctrineRatingRepository::class);

        $rating = DummyRatingFactory::createRating();
        $repository->add($rating);
        self::$em->flush();

        static::assertNotNull($repository->find($rating->id()));
        $repository->remove($rating);
        self::$em->flush();

        static::assertNull($repository->find($rating->id()));
    }

    /**
     * Tests retrieving rating entity by ID from repository.
     *
     * @throws \Exception
     */
    public function testGetId(): void
    {
        /** @var DoctrineRatingRepository $repository */
        $repository = static::getContainer()->get(DoctrineRatingRepository::class);

        $rating = DummyRatingFactory::createRating();
        $repository->add($rating);
        self::$em->flush();
        self::$em->clear();

        $retrievedMovie = $repository->get($rating->id());
        static::assertEquals($rating->id(), $retrievedMovie->id());
    }
}
