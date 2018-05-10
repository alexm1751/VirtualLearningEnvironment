<?php
/**
 * Created by PhpStorm.
 * User: alexmason
 * Date: 18/01/2018
 * Time: 12:41
 */

//Start the Sessions user enters the site
session_start();

if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 870) && $_SESSION['user']) {

    // last request was more than 15 minutes ago
    $_SESSION = array();    // unset $_SESSION variable for the run-time
    session_destroy();   // destroy session data in storage
    session_start();
    $_SESSION['activity'] = 1;
    header("location: /FinalYearProject/VLE_Public/");
    exit;
}
$_SESSION['LAST_ACTIVITY'] = time();


session_cache_expire(0);
session_cache_limiter('private_no_expire:');

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

$app->add($container->get('csrf'));



$app->run();

