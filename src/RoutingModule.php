<?php

namespace Chizu\Routing;

use Chizu\DI\Container;
use Chizu\Event\Event;
use Chizu\Event\Events;
use Chizu\Module\Module;
use Ds\Map;

/**
 * Class RoutingModule represents module which provides routing functionality.
 *
 * @package Chizu\Routing
 */
class RoutingModule extends Module
{
    /**
     * @inheritdoc
     */
    public const InitiationEvent = 'routing.initiation';

    /**
     * Executes to search route in routes.
     */
    public const SearchEvent = 'routing.search';

    /**
     * Executes after search event.
     */
    public const ResultEvent = 'routing.result';

    /**
     * RoutingModule constructor.
     *
     * @param Events $events
     * @param Container $container
     * @param Map $modules
     */
    public function __construct(Events $events, Container $container, Map $modules)
    {
        parent::__construct($events, $container, $modules);

        $this->events->set(self::InitiationEvent, Event::createByMethod($this, 'onInitiation'));
    }

    /**
     * Executes when initiation event dispatched.
     */
    protected function onInitiation(): void
    {
        $this->events->set(self::SearchEvent, Event::createByMethod($this, 'onSearch'));

        $this->setInitiated(true);
    }

    /**
     * Executes to search route in routes.
     *
     * @param Routes $routes
     * Routes to search.
     *
     * @param string $url
     * Route to search.
     */
    protected function onSearch(Routes $routes, string $url): void
    {
        if ($this->events->has(self::ResultEvent))
        {
            $this->events->get(self::ResultEvent)->execute($routes->search($url));
        }
    }
}