<?php
/**
 * Created by PhpStorm.
 * User: alexmason
 * Date: 18/01/2018
 * Time: 12:41
 */




require '../vendor/autoload.php';

$settings = require __DIR__ . '/app/settings.php';

$container = new \Slim\Container($settings);

require __DIR__ . '/app/dependencies.php';

$app = new \Slim\App($container);

require __DIR__ . '/app/routes.php';

require __DIR__ . '/app/middleware/middleware.php';

require __DIR__ . '/app/middleware/validationErrors.php';

require __DIR__ . '/app/middleware/csrfView.php';

$app->add(new \App\middleware\validationErrors($container));
$app->add(new \App\middleware\csrfView($container));

$container['csrf'] = function ($container){
    return new \Slim\Csrf\Guard;
};

$app->add($container->csrf);

$app->run();

