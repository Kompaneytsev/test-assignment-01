<?php declare(strict_types=1);
require_once dirname(__DIR__) . '/vendor/autoload.php';

header('Content-Type: application/json');

use App\Action\Action;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Router;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Routing\Loader\YamlFileLoader;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

try {
    $fileLocator = new FileLocator([dirname(__DIR__) . '/config']);

    $requestContext = new RequestContext();
    $requestContext->fromRequest(Request::createFromGlobals());

    $router = new Router(
        new YamlFileLoader($fileLocator),
        'routes.yml',
        ['cache_dir' => dirname(__DIR__).'/runtime/cache'],
        $requestContext
    );

    $parameters = $router->match($requestContext->getPathInfo());
    /** @var Action $instance */
    $instance = new $parameters['_controller']();
    $response = $instance->run();
    http_response_code($response->getStatusCode());
    echo $response->getContent();
} catch (ResourceNotFoundException $e) {
    echo $e->getMessage();
} catch (Exception $e) {
    echo $e->getMessage();
}
