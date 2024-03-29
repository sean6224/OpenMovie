<?php
declare(strict_types=1);
namespace App\Movies\Application\UseCase\Command\DeleteMovie;

use App\Common\Application\Command\CommandHandler;
use App\Movies\Application\Service\DeleteMovie;
use App\Common\Domain\ValueObject\Id;

/**
 * Command handler for deleting a movie.
 */
final readonly class DeleteMovieCommandHandler implements CommandHandler
{
    /**
     * Constructs a new DeleteMovieCommandHandler instance.
     *
     * @param DeleteMovie $deleteMovie The service responsible for deleting a movie.
     */
    public function __construct(
        private DeleteMovie $deleteMovie,
    ) {
    }

    /**
     * Handles the DeleteMovieCommand.
     *
     * @param DeleteMovieCommand $command The command to delete a movie.
     * @return void
     */
    public function __invoke(DeleteMovieCommand $command): void
    {
        $this->deleteMovie->deleteMovie(
            Id::fromString($command->movieId)
        );
    }
}
