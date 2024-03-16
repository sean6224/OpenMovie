<?php
declare(strict_types=1);
namespace App\Common\Infrastructure\InMemory;

use App\Common\Domain\Repository\PaginatorInterface;
use EmptyIterator;
use Exception;
use IteratorIterator;
use LimitIterator;
use Traversable;
use Webmozart\Assert\Assert;

/**
 * Represents a paginator for in-memory data.
 *
 * @template T Type of objects being paginated.
 *
 * @implements PaginatorInterface<T>
 */
final readonly class InMemoryPaginator implements PaginatorInterface
{
    /**
     * The offset for the current page.
     */
    private int $offset;
    /**
     * The limit for the current page.
     */
    private int $limit;
    /**
     * The last page number.
     */
    private int $lastPage;

    /**
     * Constructs the paginator.
     *
     * @param Traversable<T> $items The items to paginate.
     * @param int $totalItems The total number of items.
     * @param int $currentPage The current page number.
     * @param int $itemsPerPage The number of items per page.
     */
    public function __construct(
        private Traversable $items,
        private int $totalItems,
        private int $currentPage,
        private int $itemsPerPage,
    ) {
        Assert::greaterThanEq($totalItems, 0);
        Assert::positiveInteger($currentPage);
        Assert::positiveInteger($itemsPerPage);

        $this->offset = ($currentPage - 1) * $itemsPerPage;
        $this->limit = $itemsPerPage;
        $this->lastPage = (int) max(1, ceil($totalItems / $itemsPerPage));
    }

    /**
     * Gets the number of items per page.
     *
     * @return int The number of items per page.
     */
    public function getItemsPerPage(): int
    {
        return $this->itemsPerPage;
    }

    /**
     * Gets the current page number.
     *
     * @return int The current page number.
     */
    public function getCurrentPage(): int
    {
        return $this->currentPage;
    }

    /**
     * Gets the last page number.
     *
     * @return int The last page number.
     */
    public function getLastPage(): int
    {
        return $this->lastPage;
    }

    /**
     * Gets the total number of items.
     *
     * @return int The total number of items.
     */
    public function getTotalItems(): int
    {
        return $this->totalItems;
    }

    /**
     * Counts the number of items in the paginator.
     *
     * @throws Exception If an error occurs while counting the items.
     *
     * @return int The number of items.
     */
    public function count(): int
    {
        return iterator_count($this->getIterator());
    }

    /**
     * Gets the iterator for the current page.
     *
     * @return Traversable The iterator for the current page.
     */
    public function getIterator(): Traversable
    {
        if ($this->currentPage > $this->lastPage) {
            return new EmptyIterator();
        }

        return new LimitIterator(new IteratorIterator($this->items), $this->offset, $this->limit);
    }
}
