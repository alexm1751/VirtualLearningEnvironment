<?php
/**
 * Created by PhpStorm.
 * User: alexmason
 * Date: 18/01/2018
 * Time: 13:47
 */

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->map(['GET', 'POST'], '/passwordreset', function(Request $request, Response $response) use ($app) {


    return $this->view->render($response,
        'reset.html.twig',
        [
            'page_title' => APP_NAME,
            'method' => 'post',
            'action' => PASS_RESET,
        ]);
})->setName('passwordreset');