<?php

namespace Tests;

use Chizu\Event\Event;
use Chizu\Event\Events;
use Chizu\Routing\Route;
use Chizu\Routing\Routes;
use Chizu\Routing\RoutingModule;
use PHPUnit\Framework\TestCase;

class RoutingModuleTest extends TestCase
{
    protected RoutingModule $module;

    protected Events $events;

    protected function setUp(): void
    {
        $this->module = new RoutingModule();

        $this->events = $this->module->getEvents();

        $this->events->get(RoutingModule::InitiationEvent)->execute();
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
        $this->events->set(RoutingModule::RouteFoundEvent, Event::createByCallback(function (Route $route) use ($expected) {
            self::assertEquals($expected, $route->getName());
        }));

        $this->events->set(RoutingModule::RouteNotFoundEvent, Event::createByMethod($this, 'onRouteNotFound'));

        $this->events->get(RoutingModule::SearchEvent)->execute($routes, $url);
    }

    protected function onRouteNotFound(): void
    {
        self::assertTrue(false);
    }
}