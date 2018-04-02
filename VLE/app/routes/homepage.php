<?php
/**
 * Created by PhpStorm.
 * User: alexmason
 * Date: 18/01/2018
 * Time: 12:51
 */

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;



$app->get('/', function(Request $request, Response $response)
{

    return $this->view->render($response,
        'homepage.html.twig',
        [
            /*'css_path' => CSS_PATH,*/
            'landing_page' => LANDING_PAGE,
            'method' => 'post',
            'action' => 'index.php/loginhome',
            'method2' => 'post',
            'action2' => 'index.php/passwordreset',
            'page_title' => APP_NAME,
            'page_heading_1' => APP_NAME,
            'page_heading_2' => 'Virtual Learning Environment',


        ]);
})->setName('homepage');