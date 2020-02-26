<?php

declare(strict_types=1);

use Framework\Registry;
use Framework\Command\registerConfigsCommand;
use Framework\Command\registerRoutesCommand;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouteCollection;

class Kernel
{
    /**
     * @var RouteCollection
     */
    protected $routeCollection;

    /**
     * @var ContainerBuilder
     */
    protected $containerBuilder;

    public function __construct(ContainerBuilder $containerBuilder)
    {
        $this->containerBuilder = $containerBuilder;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function handle(Request $request): Response
    {
        $this->registerConfigs();
        $this->registerRoutes();

        return $this->process($request);
    }

    /**
     * @return void
     */
    protected function registerConfigs(): void
    {
        (new registerConfigsCommand())->execute();
    }

    /**
     * @return void
     */
    protected function registerRoutes(): void
    {
        (new registerRoutesCommand())->execute();
    }

    /**
     * @param Request $request
     * @return Response
     */
    protected function process()
    {
        (new ProcessCommand(Request $request): Response)->execute();
    }
}
