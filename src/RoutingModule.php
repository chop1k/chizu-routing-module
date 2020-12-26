<?php

namespace Chizu\Routing;

use Chizu\DI\Container;
use Chizu\Event\Event;
use Chizu\Event\Events;
use Chizu\Module\Module;
use Ds\Map;

class RoutingModule extends Module
{
    public const InitiationEvent = 'routing.initiation';
    public const RegisterRoutesEvent = 'routing.register';
    public const RouteNotFoundEvent = 'routing.notFound';
    public const RouteFoundEvent = 'routing.found';
    public const SearchEvent = 'routing.search';

    public function __construct(Events $events, Container $container, Map $modules)
    {
        parent::__construct($events, $container, $modules);

        $this->events->set(self::InitiationEvent, Event::createByMethod($this, 'onInitiation'));
    }

    protected function onInitiation(): void
    {
        $this->events->set(self::SearchEvent, Event::createByMethod($this, 'onSearch'));

        $this->setInitiated(true);
    }

    protected function onSearch(Routes $routes, string $url): void
    {
        $result = $routes->search($url);

        if (is_null($result))
        {
            $this->events->get(self::RouteNotFoundEvent)->execute();
        }
        else
        {
            $this->events->get(self::RouteFoundEvent)->execute($result);
        }
    }
}