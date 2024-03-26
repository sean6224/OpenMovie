<?php
declare(strict_types=1);
namespace App\Tests\Movie\Performance;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Common\Application\Command\CommandBus;
use App\Common\Application\Query\QueryBus;
use App\Movies\Application\DTO\MovieDTO;
use App\Movies\Application\UseCase\Query\GetMovie\GetMovieQuery;
use App\Movies\Domain\Repository\MovieRepository;
use App\Tests\Movie\FakeDataMovie;
use Exception;

/**
 * Performance test for finding movies in batches.
 *
 * This test measures the performance of finding movies in batches.
 */
class FindPerformanceTest extends ApiTestCase
{
    private static CommandBus $commandBus;
    private static QueryBus $queryBus;
    private static MovieRepository $movieRepository;
    private static FakeDataMovie $fakeDataMovie;
    private const ITERATIONS = 100;
    private const BATCH_SIZE = 50;
    private float $executionTime = 0.0;

    /**
     * @throws Exception
     */
    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
        static::$commandBus = static::getContainer()->get(CommandBus::class);
        static::$queryBus = static::getContainer()->get(QueryBus::class);
        static::$movieRepository = static::getContainer()->get(MovieRepository::class);
        static::$fakeDataMovie = new FakeDataMovie(static::$commandBus, static::$movieRepository);
    }

    /**
     * Tests the performance of finding movies in batches.
     */
    public function testFindMovie(): void
    {
        $startTime = microtime(true);

        for ($batch = 0; $batch < self::ITERATIONS; $batch += self::BATCH_SIZE) {
            for ($i = $batch; $i < min($batch + self::BATCH_SIZE, self::ITERATIONS); $i++) {
                $movieId = static::$fakeDataMovie->createMovie(true);
                self::assertNotEmpty($movieId, 'The movie ID should not be empty.');
                $movieDTO = self::$queryBus->ask(new GetMovieQuery(movieId: $movieId));
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
        $formattedMessage = $border . "\n* Test execution time: " . $formattedTime . " *\n" . str_pad('*', $borderLength, ' ', STR_PAD_RIGHT) . "\n";
        echo $formattedMessage;
    }
}
