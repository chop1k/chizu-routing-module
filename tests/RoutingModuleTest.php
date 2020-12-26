<?php

namespace Tests;

use Chizu\DI\Container;
use Chizu\Event\Event;
use Chizu\Event\Events;
use Chizu\Routing\Route;
use Chizu\Routing\Routes;
use Chizu\Routing\RoutingModule;
use Ds\Map;
use PHPUnit\Framework\TestCase;

class RoutingModuleTest extends TestCase
{
    protected RoutingModule $module;

    protected function setUp(): void
    {
        $this->module = new RoutingModule(new Events(), new Container(), new Map());

        $this->module->getEvents()->get(RoutingModule::InitiationEvent)->execute();
    }

    public function getRoutes(): array
    {
        $routes = new Routes([
            new Route('route1', '/abc/', 'controller1'),
            new Route('route2', '/abc', 'controller2'),
            new Route('route3', '', 'controller3'),
        ]);

        return [
            [$routes, '/abc/', 'route1'],
            [$routes, '/abc', 'route2'],
            [$routes, '', 'route3']
        ];
    }

    /**
     * @dataProvider getRoutes
     *
     * @param mixed $routes
     * @param $url
     * @param $expected
     */
    public function testSearchEvent($routes, $url, $expected): void
    {
        $events = $this->module->getEvents();

        $events->set(RoutingModule::RouteFoundEvent, Event::createByCallback(function (Route $route) use ($expected) {
            self::assertEquals($expected, $route->getName());
        }));

        $events->set(RoutingModule::RouteNotFoundEvent, Event::createByMethod($this, 'onRouteNotFound'));

        $events->get(RoutingModule::SearchEvent)->execute($routes, $url);
    }

    protected function onRouteNotFound(): void
    {
        self::assertTrue(false);
    }
}