<?php

namespace Bitter\S3FileStorage\Provider;

use Bitter\S3FileStorage\File\StorageLocation\Configuration\S3FileStorageConfiguration;
use Concrete\Core\Application\Application;
use Concrete\Core\Foundation\Service\Provider;
use Concrete\Core\Routing\RouterInterface;
use Bitter\S3FileStorage\Routing\RouteList;

class ServiceProvider extends Provider
{
    protected RouterInterface $router;

    public function __construct(
        Application     $app,
        RouterInterface $router
    )
    {
        parent::__construct($app);

        $this->router = $router;
    }

    public function register()
    {
        $this->registerRoutes();
        $this->initializeFileStorageType();
    }

    private function registerRoutes()
    {
        $this->router->loadRouteList(new RouteList());
    }

    private function initializeFileStorageType()
    {
        class_alias(
            S3FileStorageConfiguration::class,
            'Concrete\Package\S3FileStorage\File\StorageLocation\Configuration\S3FileStorageConfiguration'
        );
    }
}