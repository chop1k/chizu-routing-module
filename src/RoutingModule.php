<?php

namespace Chizu\Routing;

use Chizu\Event\Event;
use Chizu\Module\Module;

class RoutingModule extends Module
{
    public const RegisterRoutesEvent = 'routing.register';
    public const RouteNotFoundEvent = 'routing.notFound';
    public const RouteFoundEvent = 'routing.found';
    public const SearchEvent = 'routing.search';

    public function __construct()
    {
        parent::__construct();

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