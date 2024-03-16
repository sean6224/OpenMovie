<?php
declare(strict_types=1);
namespace App\Common\Infrastructure\InMemory;

use App\Common\Domain\Repository\PaginatorInterface;
use App\Common\Domain\Repository\Repository;
use ArrayIterator;
use Iterator;
use Webmozart\Assert\Assert;

/**
 * Abstract class InMemoryRepository represents an in-memory repository that stores objects in an array.
 * It implements the Repository interface, which defines basic repository operations.
 *
 * @template T Type of the object stored in the repository.
 *
 * @implements Repository<T>
 */
abstract class InMemoryRepository implements Repository
{
    /**
     * The array storing objects, indexed by identifiers.
     *
     * @var array<string, T>
     */
    protected array $entities = [];

    protected ?int $page = null;
    protected ?int $itemsPerPage = null;

    /**
     * Returns an iterator allowing iteration over objects stored in the repository.
     *
     * @return Iterator
     */
    public function getIterator(): Iterator
    {
        if (null !== $paginator = $this->paginator()) {
            yield from $paginator;

            return;
        }

        yield from $this->entities;
    }

    /**
     * Sets pagination for the repository.
     *
     * @param int $page The page number.
     * @param int $itemsPerPage The number of items per page.
     *
     * @return static
     */
    public function withPagination(int $page, int $itemsPerPage): static
    {
        Assert::positiveInteger($page);
        Assert::positiveInteger($itemsPerPage);

        $cloned = clone $this;
        $cloned->page = $page;
        $cloned->itemsPerPage = $itemsPerPage;

        return $cloned;
    }

    /**
     * Disables pagination for the repository.
     *
     * @return static
     */
    public function withoutPagination(): static
    {
        $cloned = clone $this;
        $cloned->page = null;
        $cloned->itemsPerPage = null;

        return $cloned;
    }

    /**
     * Returns a paginator object if the repository is used with pagination.
     *
     * @return PaginatorInterface|null
     */
    public function paginator(): ?PaginatorInterface
    {
        if (null === $this->page || null === $this->itemsPerPage) {
            return null;
        }

        return new InMemoryPaginator(
            new ArrayIterator($this->entities),
            count($this->entities),
            $this->page,
            $this->itemsPerPage,
        );
    }

    /**
     * Returns the number of objects stored in the repository.
     *
     * @return int
     */
    public function count(): int
    {
        if (null !== $paginator = $this->paginator()) {
            return count($paginator);
        }

        return count($this->entities);
    }

    /**
     * Filters objects in the repository using the specified filter.
     *
     * @param callable(mixed, mixed=): bool $filter The filtering function to be applied to each object.
     *
     * @return static
     */
    protected function filter(callable $filter): static
    {
        $cloned = clone $this;
        $cloned->entities = array_filter($cloned->entities, $filter);

        return $cloned;
    }
}
