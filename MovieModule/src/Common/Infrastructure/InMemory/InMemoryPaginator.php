<?php
declare(strict_types=1);
namespace App\Common\Infrastructure\InMemory;

use App\Common\Domain\Repository\PaginatorInterface;
use EmptyIterator;
use Exception;
use IteratorIterator;
use LimitIterator;
use ReturnTypeWillChange;
use Webmozart\Assert\Assert;

/**
 * Represents a paginator for in-memory data.
 *
 * @template T Type of objects being paginated.
 *
 * @implements PaginatorInterface<T>
 */
final class InMemoryPaginator implements PaginatorInterface
{
    /**
     * The offset for current page.
     */
    private int $offset;
    /**
     * The limit for current page.
     */
    private int $limit;
    /**
     * The last page number.
     */
    private int $lastPage;

    /**
     * Constructs the paginator.
     *
     * @param array<T> $items The items to paginate.
     * @param int $totalItems The total number of items.
     * @param int $currentPage The current page number.
     * @param int $itemsPerPage The number of items per page.
     */
    public function __construct(
        private readonly array $items,
        private readonly int $totalItems,
        private readonly int $currentPage,
        private readonly int $itemsPerPage,
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
     * Counts the number of items in paginator.
     *
     * @throws Exception If an error occurs while counting items.
     *
     * @return int The number of items.
     */
    public function count(): int
    {
        return count($this->items);
    }

    /**
     * Gets the iterator for current page.
     *
     * @return iterable The iterator for current page.
     */
    #[ReturnTypeWillChange] public function getIterator(): iterable
    {
        if ($this->currentPage > $this->lastPage) {
            return new EmptyIterator();
        }
        return new LimitIterator(new IteratorIterator($this->items), $this->offset, $this->limit);
    }
}
