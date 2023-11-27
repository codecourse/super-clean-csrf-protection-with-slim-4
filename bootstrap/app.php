<?php

use Slim\Csrf\Guard;
use App\Views\CsrfExtension;

session_start();

require_once __DIR__ . '/../vendor/autoload.php';

try {
    (new Dotenv\Dotenv(__DIR__ . '/../'))->load();
} catch (Dotenv\Exception\InvalidPathException $e) {
    //
}

$container = new DI\Container();

Slim\Factory\AppFactory::setContainer($container);

$app = Slim\Factory\AppFactory::create();

$container->set('settings', function () {
    return [
        'displayErrorDetails' => getenv('APP_DEBUG') === 'true',

        'app' => [
            'name' => getenv('APP_NAME')
        ],

        'views' => [
            'cache' => getenv('VIEW_CACHE_DISABLED') === 'true' ? false : __DIR__ . '/../storage/views'
        ]
    ];
});

$container->set('csrf', function () use ($app) {
    return new Guard($app->getResponseFactory());
});

$twig = new Slim\Views\Twig(__DIR__ . '/../resources/views', [
    'cache' => $container->get('settings')['views']['cache']
]);

$twig->addExtension(
    new CsrfExtension($container->get('csrf'))
);

$twigMiddleware = new Slim\Views\TwigMiddleware(
    $twig,
    $container,
    $app->getRouteCollector()->getRouteParser()
);

$app->add($twigMiddleware);

$app->add('csrf');

require_once __DIR__ . '/../routes/web.php';
