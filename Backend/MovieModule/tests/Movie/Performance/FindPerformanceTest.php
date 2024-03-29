<?php
declare(strict_types=1);
namespace App\Tests\Movie\Performance;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Common\Application\Query\QueryBus;
use App\Movies\Application\DTO\MovieDTO;
use App\Movies\Application\UseCase\Query\GetMovie\GetMovieQuery;
use App\Movies\Domain\Repository\MovieRepository;
use App\Tests\Movie\DummyFactory\DummyMovieFactory;
use Exception;

/**
 * Performance test for finding movies in batches.
 *
 * This test measures the performance of finding movies in batches.
 */
class FindPerformanceTest extends ApiTestCase
{
    private const ITERATIONS = 100;
    private const BATCH_SIZE = 50;
    private float $executionTime = 0.0;

    /**
     * Tests the performance of finding movies in batches.
     * @throws Exception
     */
    public function testFindMovie(): void
    {
        $movieRepository = static::getContainer()->get(MovieRepository::class);
        $queryBus = static::getContainer()->get(QueryBus::class);

        $startTime = microtime(true);

        for ($batch = 0; $batch < self::ITERATIONS; $batch += self::BATCH_SIZE) {
            for ($i = $batch; $i < min($batch + self::BATCH_SIZE, self::ITERATIONS); $i++) {
                $movie = DummyMovieFactory::createMovie();
                $movieRepository->add($movie);
                self::assertNotEmpty($movie->id()->value(), 'The movie ID should not be empty.');
                $movieDTO = $queryBus->ask(new GetMovieQuery(movieId: $movie->id()->value()));
                static::assertInstanceOf(MovieDTO::class, $movieDTO);
            }
        }

        $endTime = microtime(true);
        $this->executionTime = $endTime - $startTime;
    }

    /**
     * Tears down after running test.
     *
     * Outputs the execution time of test.
     */
    protected function tearDown(): void
    {
        parent::tearDown();
        $executionTime = sprintf("%.2f", $this->executionTime);
        $formattedTime = "\e[1;32m" . $executionTime . " seconds\e[0m";
        $borderLength = strlen("Test execution time: ") + strlen($executionTime) + 4;
        $border = str_repeat("*", $borderLength);
        $formattedMessage = $border . "\n* Test execution time: " . $formattedTime . " *\n" . str_pad('*', $borderLength) . "\n";
        echo $formattedMessage;
    }
}
