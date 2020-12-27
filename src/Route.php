<?php

namespace Chizu\Routing;

/**
 * Class Route represents route structure.
 *
 * @package Chizu\Routing
 */
class Route
{
    /**
     * Contains route name.
     *
     * @var string $name
     */
    protected string $name;

    /**
     * Returns route name.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Sets route name.
     *
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * Contains route pattern.
     *
     * @var string $pattern
     */
    protected string $pattern;

    /**
     * Returns route pattern.
     *
     * @return string
     */
    public function getPattern(): string
    {
        return $this->pattern;
    }

    /**
     * Sets route pattern.
     *
     * @param string $pattern
     */
    public function setPattern(string $pattern): void
    {
        $this->pattern = $pattern;
    }

    /**
     * Contains controller name.
     *
     * @var string $controller
     */
    protected string $controller;

    /**
     * Returns controller name.
     *
     * @return string
     */
    public function getController(): string
    {
        return $this->controller;
    }

    /**
     * Sets controller name.
     *
     * @param string $controller
     */
    public function setController(string $controller): void
    {
        $this->controller = $controller;
    }

    /**
     * Route constructor.
     *
     * @param string $name
     * @param string $pattern
     * @param string $controller
     */
    public function __construct(string $name = "", string $pattern = "", string $controller = "")
    {
        $this->name = $name;
        $this->pattern = $pattern;
        $this->controller = $controller;
    }

    /**
     * Matches given url with pattern and returns bool
     *
     * @param string $url
     * Url to match.
     *
     * @return bool
     */
    public function match(string $url): bool
    {
        return $url === $this->pattern;
    }
}