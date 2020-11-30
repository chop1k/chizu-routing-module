<?php

namespace Chizu\Routing;

use Ds\Vector;

class Routes
{
    protected Vector $routes;

    public function push(Route ...$routes): void
    {
        $this->routes->push(...$routes);
    }

    public function count(): int
    {
        return $this->routes->count();
    }

    public function __construct($values = [])
    {
        $this->routes = new Vector($values);
    }

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