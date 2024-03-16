<?php
declare(strict_types=1);
namespace App\Movies\Application\UseCase\Command\DeleteMovie;

use App\Common\Application\Command\Command;

/**
 * Command to delete a movie.
 */
final readonly class DeleteMovieCommand implements Command
{
    /**
     * Constructs a new DeleteMovieCommand instance.
     *
     * @param string $movieId The ID of the movie to delete.
     */
    public function __construct(
        public string $movieId,
    ) {
    }
}
