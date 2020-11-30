<?php

namespace Chizu\Routing;

use InvalidArgumentException;

class Route
{
    protected string $name;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    protected string $pattern;

    /**
     * @return string
     */
    public function getPattern(): string
    {
        return $this->pattern;
    }

    /**
     * @param string $pattern
     */
    public function setPattern(string $pattern): void
    {
        $this->pattern = $pattern;
    }

    public function __construct(string $name = "", string $pattern = "")
    {
        $this->name = $name;
        $this->pattern = $pattern;
    }

    public function match(string $url): bool
    {
        $result = preg_match($this->pattern, $url);

        if ($result === false)
        {
            throw new InvalidArgumentException(sprintf('Cannot match given string "%s" and pattern "%s"', $url, $this->pattern));
        }

        return $result;
    }
}