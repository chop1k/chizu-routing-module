<?php

namespace Chizu\Routing;

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

    protected string $controller;

    /**
     * @return string
     */
    public function getController(): string
    {
        return $this->controller;
    }

    /**
     * @param string $controller
     */
    public function setController(string $controller): void
    {
        $this->controller = $controller;
    }

    public function __construct(string $name = "", string $pattern = "", string $controller = "")
    {
        $this->name = $name;
        $this->pattern = $pattern;
        $this->controller = $controller;
    }

    public function match(string $url): bool
    {
        return $url === $this->pattern;
    }
}