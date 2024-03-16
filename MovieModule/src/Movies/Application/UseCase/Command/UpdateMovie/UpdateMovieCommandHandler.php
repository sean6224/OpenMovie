<?php
declare(strict_types=1);
namespace App\Movies\Application\UseCase\Command\UpdateMovie;

use App\Common\Application\Command\CommandHandler;
use App\Movies\Application\DTO\MovieDTO;
use App\Movies\Application\Service\PatchMovie;

/**
 * Command handler responsible for updating a movie based on the provided command.
 */
final readonly class UpdateMovieCommandHandler implements CommandHandler
{
    /**
     * Constructs a new UpdateMovieCommandHandler instance.
     *
     * @param PatchMovie $patchMovie The service responsible for applying the patch to movie.
     */
    public function __construct(
        private PatchMovie $patchMovie,
    ) {
    }
    /**
     * Handles the update movie command.
     *
     * @param UpdateMovieCommand $command The command representing the update movie request.
     * @return MovieDTO The DTO representing the updated movie.
     */
    public function __invoke(UpdateMovieCommand $command): MovieDTO
    {
        return MovieDTO::fromEntity(
            $this->patchMovie->patchMovie($command->toDto())
        );
    }
}
