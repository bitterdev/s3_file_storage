<?php

namespace Bitter\S3FileStorage\Routing;

use Bitter\S3FileStorage\API\V1\Middleware\FractalNegotiatorMiddleware;
use Bitter\S3FileStorage\API\V1\Configurator;
use Concrete\Core\Routing\RouteListInterface;
use Concrete\Core\Routing\Router;

class RouteList implements RouteListInterface
{
    public function loadRoutes(Router $router)
    {
        $router
            ->buildGroup()
            ->setNamespace('Concrete\Package\S3FileStorage\Controller\Dialog\Support')
            ->setPrefix('/ccm/system/dialogs/s3_file_storage')
            ->routes('dialogs/support.php', 's3_file_storage');
    }
}