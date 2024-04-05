<?php
declare(strict_types=1);
namespace App\Common\Domain\Port;

/**
 * Interface representing port for interacting with cache system.
 */
interface AdapterCachePort
{
    /**
     * Retrieves an item from the cache based on the cache key.
     *
     * @param string $cacheKey The cache key.
     * @return mixed|null The value retrieved from the cache, or null if not found.
     */
    public function getItem(string $cacheKey): mixed;

    /**
     * Saves an item to the cache using the provided cache key.
     *
     * @param string $cacheKey The cache key.
     * @param mixed $value The value to save to the cache.
     * @param int|null $ttl The time-to-live (TTL) for the cached item in seconds. If null, the default TTL will be used.
     */
    public function saveItem(string $cacheKey, mixed $value, ?int $ttl = null): void;

    /**
     * Retrieves multiple items from the cache based on the provided cache keys.
     *
     * @param array $cacheKeys An array of cache keys.
     * @return array An associative array where keys are cache keys and values are corresponding cache values.
     */
    public function getMultiple(array $cacheKeys): array;

    /**
     * Saves multiple items to the cache using the provided cache keys and values.
     *
     * @param array $items An associative array where keys are cache keys and values are corresponding cache values.
     * @param int|null $ttl The time-to-live (TTL) for the cached items in seconds. If null, the default TTL will be used.
     */
    public function saveMultiple(array $items, ?int $ttl = null): void;

    /**
     * Deletes multiple items from the cache based on the provided cache keys.
     *
     * @param array $cacheKeys An array of cache keys.
     */
    public function deleteMultiple(array $cacheKeys): void;

    /**
     * Retrieves multiple items from the cache if they exist, or sets new values for missing items.
     *
     * @param array $cacheKeys An array of cache keys.
     * @param callable $callback The callback function to retrieve values for missing items.
     * @param int|null $ttl The time-to-live (TTL) for the cached items in seconds. If null, the default TTL will be used.
     * @return array An associative array where keys are cache keys and values are corresponding cache values.
     */
    public function getMultipleOrSet(array $cacheKeys, callable $callback, ?int $ttl = null): array;

    /**
     * Checks if an item exists in the cache based on the cache key.
     *
     * @param string $cacheKey The cache key.
     * @return bool True if the item exists in the cache, otherwise false.
     */
    public function hasItem(string $cacheKey): bool;

    /**
     * Deletes an item from the cache based on the cache key.
     *
     * @param string $cacheKey The cache key.
     */
    public function deleteItem(string $cacheKey): void;

    /**
     * Clears all items from the cache.
     */
    public function clear(): void;
}
