<?php
/**
 * Created by PhpStorm.
 * User: alexmason
 * Date: 18/01/2018
 * Time: 12:51
 */

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;


session_unset();
session_destroy();


$app->get('/', function(Request $request, Response $response)
{


    return $this->view->render($response,
        'loggedOut.html.twig',
        [
            'css_path' => CSS_PATH,
            'landing_page' => LANDING_PAGE,
            'method' => 'post',
            'action' => 'index.php/loginhome',
            'method2' => 'post',
            'action2' => 'index.php/passwordreset',
            'initial_input_box_value' => null,
            'page_title' => APP_NAME,
            'page_heading_1' => APP_NAME,
            'page_heading_2' => 'Virtual Learning Environment',


        ]);
})->setName('logout');