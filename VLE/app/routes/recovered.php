<?php
/**
 * Created by PhpStorm.
 * User: alexmason
 * Date: 03/04/2018
 * Time: 04:36
 */

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;



$app->map(['GET', 'POST'],'/recovered', function(Request $request, Response $response) use ($app)
{

    return $this->view->render($response,
        'resetPassword.html.twig',
        [
            /*'css_path' => CSS_PATH,*/
            'landing_page' => LANDING_PAGE,
            'action' => LANDING_PAGE,
            'page_title' => APP_NAME,
            'page_heading_1' => APP_NAME,
            'page_heading_2' => 'Virtual Learning Environment',


        ]);
})->setName('recovered');