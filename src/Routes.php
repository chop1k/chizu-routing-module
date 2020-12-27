<?php

namespace Chizu\Routing;

use Ds\Vector;

/**
 * Class Routes represents wrapper for vector with routes.
 *
 * @package Chizu\Routing
 */
class Routes
{
    /**
     * Vector with routes.
     *
     * @var Vector $routes
     */
    protected Vector $routes;

    /**
     * Adds routes to vector.
     *
     * @param Route ...$routes
     */
    public function push(Route ...$routes): void
    {
        $this->routes->push(...$routes);
    }

    /**
     * Returns number of routes.
     *
     * @return int
     */
    public function count(): int
    {
        return $this->routes->count();
    }

    /**
     * Routes constructor.
     *
     * @param array $values
     */
    public function __construct($values = [])
    {
        $this->routes = new Vector($values);
    }

    /**
     * Searches given url in routes.
     *
     * @param string $url
     * Url to search.
     *
     * @return Route|null
     */
    public function search(string $url): ?Route
    {
        foreach ($this->routes->getIterator() as $value)
        {
            if ($value->match($url))
            {
                return $value;
            }
        }

        return null;
    }
}