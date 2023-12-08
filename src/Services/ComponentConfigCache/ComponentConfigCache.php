<?php

declare(strict_types=1);

namespace App\Services\ComponentConfigCache;

use App\Utils\InitializedProjectProxy;
use Psr\Cache\CacheItemPoolInterface;

class ComponentConfigCache
{
    /**
     * @param \Psr\Cache\CacheItemPoolInterface  $cache
     * @param \App\Utils\InitializedProjectProxy $initializedProjectProxy
     */
    public function __construct(
        protected CacheItemPoolInterface $cache,
        protected InitializedProjectProxy $initializedProjectProxy
    ) {
    }

    /**
     * @param string $componentId
     * @param array  $configuration
     *
     * @return bool
     * @throws \Psr\Cache\InvalidArgumentException
     */
    public function set(string $componentId, array $configuration): bool
    {
        $item = $this->cache->getItem($this->getIdentifier($componentId));

        $item->set($configuration);

        return $this->cache->save($item);
    }

    /**
     * @param string $componentId
     *
     * @return array|null
     * @throws \Psr\Cache\InvalidArgumentException
     */
    public function get(string $componentId): ?array
    {
        $item = $this->cache->getItem($this->getIdentifier($componentId));

        return $item->get();
    }

    /**
     * @param string $componentId
     *
     * @return bool
     * @throws \Psr\Cache\InvalidArgumentException
     */
    public function unset(string $componentId): bool
    {
        return $this->cache->deleteItem($this->getIdentifier($componentId));
    }

    /**
     * @param string $componentId
     *
     * @return string
     */
    protected function getIdentifier(string $componentId): string
    {
        $projectId = $this->initializedProjectProxy->getProject()?->getId() ?? '_';

        return "configuration-$projectId-$componentId";
    }
}
