<?php

namespace Tests;

use Chizu\Event\Dispatcher;
use Chizu\Event\Event;
use Chizu\Routing\Route;
use Chizu\Routing\Routes;
use Chizu\Routing\RoutingModule;
use PHPUnit\Framework\TestCase;

class RoutingModuleTest extends TestCase
{
    protected RoutingModule $module;

    protected Dispatcher $dispatcher;

    protected function setUp(): void
    {
        $this->module = new RoutingModule();

        $this->dispatcher = $this->module->getDispatcher();

        $this->dispatcher->dispatch(RoutingModule::InitiationEvent);
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
        $this->dispatcher->set(RoutingModule::RouteFoundEvent, new Event([function (Route $route) use ($expected) {
            self::assertEquals($expected, $route->getName());
        }]));

        $this->dispatcher->set(RoutingModule::RouteNotFoundEvent, new Event([function () {
            self::assertTrue(false);
        }]));

        $this->dispatcher->dispatch(RoutingModule::SearchEvent, $routes, $url);
    }
}