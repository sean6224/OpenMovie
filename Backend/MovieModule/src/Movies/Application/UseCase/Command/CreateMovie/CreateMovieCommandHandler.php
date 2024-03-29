<?php
declare(strict_types=1);

namespace App\Movies\Application\UseCase\Command\CreateMovie;

use App\Common\Application\Command\CommandHandler;
use App\Movies\Application\DTO\MovieDTO;
use App\Movies\Application\Service\MovieCreator;

/**
 * Command handler for creating a movie.
 */
final readonly class CreateMovieCommandHandler implements CommandHandler
{
    /**
     * Constructs a new CreateMovieCommandHandler instance.
     *
     * @param MovieCreator $movieCreator The service responsible for creating movies.
     */
    public function __construct(
        private MovieCreator $movieCreator,
    ) {
    }

    /**
     * Handles the CreateMovieCommand to create a new movie.
     *
     * @param CreateMovieCommand $command The command object containing movie information.
     * @return MovieDTO Returns the DTO representation of the created movie.
     */
    public function __invoke(CreateMovieCommand $command): MovieDTO
    {
        return MovieDTO::fromEntity(
            $this->movieCreator->createMovie($command->toDto())
        );
    }
}
