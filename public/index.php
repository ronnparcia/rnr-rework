<?php
// Ignore warnings
error_reporting(E_ALL ^ E_DEPRECATED);

// Require Composer's autoloader
require '../vendor/autoload.php';

// Create Slim container
$container = new \Slim\Container();

// Set-up view rendering with Twig
$container['view'] = function ($container) {
    $view = new \Slim\Views\Twig('../templates', [
        'cache' => false, // You can set to 'false' in development mode
        'debug' => true 
    ]);

    // Instantiate and add Slim specific extension
    $router = $container->get('router');
    $uri = \Slim\Http\Uri::createFromEnvironment(new \Slim\Http\Environment($_SERVER));
    $view->addExtension(new \Slim\Views\TwigExtension($router, $uri));

    return $view;
};

// Activating routes in a subfolder
$container['environment'] = function () {
    $scriptName = $_SERVER['SCRIPT_NAME'];
    $_SERVER['SCRIPT_NAME'] = dirname(dirname($scriptName)) . '/' . basename($scriptName);
    return new Slim\Http\Environment($_SERVER);
};

// Set-up 404 page
$container['notFoundHandler'] = function ($container) {
    return function ($request, $response) use ($container) {
        return $container['view']->render($response->withStatus(404), 'pages/404.twig');
    };
};

// Create Slim app
$app = new \Slim\App($container);

// Require helper functions such as getPosts()
require '../src/helpers/helpers.php';

// Require routes
require '../src/routes/routes.php';

$app->run();