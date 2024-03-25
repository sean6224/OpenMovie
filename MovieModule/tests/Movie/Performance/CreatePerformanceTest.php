<?php
declare(strict_types=1);
namespace App\Tests\Movie\Performance;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Tests\Movie\FakeDataMovie;
use Exception;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

/**
 * Performance test for creating movies in batches.
 *
 * This test measures the performance of creating movies in batches.
 */
class CreatePerformanceTest extends ApiTestCase
{
    private static FakeDataMovie $fakeDataMovie;
    private const ITERATIONS = 100;
    private const BATCH_SIZE = 10;
    private float $executionTime = 0.0;

    /**
     * @throws Exception
     */
    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
        static::$fakeDataMovie = new FakeDataMovie();
    }

    /**
     * Tests the performance of creating movies in batches.
     *
     * This test sends multiple requests to create movies in batches and measures the execution time.
     *
     * @throws TransportExceptionInterface
     */
    public function testCreateMovie(): void
    {
        $client = static::createClient();
        $startTime = microtime(true);

        for ($batch = 0; $batch < self::ITERATIONS; $batch += self::BATCH_SIZE) {
            $batchRequests = [];
            for ($i = $batch; $i < min($batch + self::BATCH_SIZE, self::ITERATIONS); $i++) {
                $batchRequests[] = [
                    'json' => $this->generateMovieData($i)
                ];
            }

            foreach ($batchRequests as $request) {
                $client->request('POST', '/movies/add', $request);
                self::assertResponseIsSuccessful();
            }
        }

        $endTime = microtime(true);
        $this->executionTime = $endTime - $startTime;
    }

    /**
     * Generates data for movie.
     *
     * @param int $index The index of movie.
     * @return array The movie data.
     */
    private function generateMovieData(int $index): array
    {
        $movieBasicData =  static::$fakeDataMovie->generateMovieBasicData()->toArray();
        $movieDetailsParamData = static::$fakeDataMovie->generateMovieDetailsParamData()->toArray();

        return [
            'movieInformation' => [
                'movieName' => 'Test Movie ' . $index,
                'description' => $movieBasicData['description'],
                'releaseYear' => $movieBasicData['releaseYear'],
                'productionCountry' => $movieDetailsParamData['productionCountry'],
                'directors' => $movieDetailsParamData['directors'],
                'actors' => $movieDetailsParamData['actors'],
                'category' => $movieDetailsParamData['category'],
                'tags' => $movieDetailsParamData['tags'],
                'languages' => $movieDetailsParamData['languages'],
                'subtitles' => $movieDetailsParamData['subtitles'],
                'duration' => $movieBasicData['duration'],
                'ageRestriction' => $movieBasicData['ageRestriction'],
                'averageRating' => $movieBasicData['averageRating']
            ]
        ];
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
