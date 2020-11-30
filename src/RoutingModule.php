<?php

namespace Chizu\Routing;

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

        $this->dispatcher->listen(self::InitiationEvent, function () {
            $this->onInitiation();
        });
    }

    protected function onInitiation(): void
    {
        $this->dispatcher->listen(self::SearchEvent, function (Routes $routes, string $url) {
            $this->onSearch($routes, $url);
        });
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