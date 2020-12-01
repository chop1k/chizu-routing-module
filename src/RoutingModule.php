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

        $this->dispatcher->set(self::InitiationEvent, new Event([function () {
            $this->onInitiation();
        }]));
    }

    protected function onInitiation(): void
    {
        $this->dispatcher->set(self::SearchEvent, new Event([function (Routes $routes, string $url) {
            $this->onSearch($routes, $url);
        }]));

        $this->setInitiated(true);
    }

    protected function onSearch(Routes $routes, string $url): void
    {
        $result = $routes->search($url);

        if (is_null($result))
        {
            $this->dispatcher->dispatch(self::RouteNotFoundEvent, $url);
        }
        else
        {
            $this->dispatcher->dispatch(self::RouteFoundEvent, $result);
        }
    }
}