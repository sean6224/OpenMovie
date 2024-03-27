<?php
declare(strict_types=1);
namespace App\Tests\Movie\Acceptance;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Common\Application\Command\CommandBus;
use App\Common\Application\Query\QueryBus;
use App\Movies\Domain\Repository\MovieRepository;
use App\Movies\UserInterface\ApiPlatform\Resource\MovieResource;
use App\Tests\Movie\DummyFactory\DummyMovieFactory;
use Exception;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

/**
 * Class MovieCrudTest
 *
 * This class contains acceptance tests for Movie CRUD operations.
 */
class MovieCrudTest extends ApiTestCase
{
    private static CommandBus $commandBus;
    private static QueryBus $queryBus;
    private static MovieRepository $movieRepository;

    /**
     * Sets up the test class before running tests.
     *
     * @throws Exception
     */
    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
        static::$commandBus = static::getContainer()->get(CommandBus::class);
        static::$queryBus = static::getContainer()->get(QueryBus::class);
        static::$movieRepository = static::getContainer()->get(MovieRepository::class);
    }

    /**
     * Test case to retrieve paginated movies.
     *
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function testReturnPaginatedMovies(): void
    {
        /*
         * Note to repair
         */
        $client = static::createClient();
         DummyMovieFactory::createMovie();

        $client->request('GET', '/movies/get/all_list');

        static::assertResponseIsSuccessful();
        static::assertMatchesResourceCollectionJsonSchema(MovieResource::class);

        static::assertJsonContains([
            'hydra:totalItems' => 30,
            'hydra:view' => [
                'hydra:first' => '/movies/get/all_list?page=1',
                'hydra:next' => '/movies/get/all_list?page=2',
                'hydra:last' => '/movies/get/all_list?page=5',
            ],
        ]);
    }

    /**
     * Test case to retrieve single movie.
     *
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function testReturnMovie(): void
    {
        $client = static::createClient();
        $movies = DummyMovieFactory::createMovie();
        $client->request('GET', sprintf('/movies/single/%s', $movies->id()->value()));
        static::assertResponseIsSuccessful();
        static::assertMatchesResourceItemJsonSchema(MovieResource::class);
    }

    /**
     * Test case to delete movie.
     *
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function testDeleteMovie(): void
    {
        $client = static::createClient();
        $movies = DummyMovieFactory::createMovie();
        $response = $client->request('DELETE', sprintf('/movies/%s', $movies->id()->value()));
        static::assertResponseIsSuccessful();
        static::assertEmpty($response->getContent());
    }
}
