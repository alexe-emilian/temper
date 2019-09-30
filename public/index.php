<?php

use DI\Container;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Temper\Controller\UserProgressController;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

require_once __DIR__ . '/../vendor/autoload.php';

/** Create Container using PHP-DI **/
$container = new Container();
$container->set('Twig\Environment', function () {
    $loader = new FilesystemLoader('templates');
    $twig = new Environment($loader);

    return $twig;
});

/** INSTANTIATE APP **/
AppFactory::setContainer($container);
$app = AppFactory::create();

/** ADD ERROR MIDDLEWARE **/
$app->addErrorMiddleware(true, true, true);

/** ADD ROUTES **/
$app->get('/', function(Request $request, Response $response, $args) use ($container)  {
    $response->getBody()->write(
        $container->get('Twig\Environment')->render('index.html')
    );

    return $response;
});

$app->get('/api/users/retention-chart', function (Request $request, Response $response, $args) {
    /** @var UserProgressController $controller */
    $controller = $this->get('Temper\Controller\UserProgressController');

    return $controller->getRetentionChartDataAction($request, $response, $args);
});

$app->run();
