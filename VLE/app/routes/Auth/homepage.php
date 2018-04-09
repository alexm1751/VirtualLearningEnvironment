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


if($_SESSION['activity'] == 1){
    $_SESSION['activity'] = 0;
    header("Refresh:0");
    return $this->view->render($response,
        'homepage.html.twig',
        [
            'landing_page' => LANDING_PAGE,
            'method' => 'post',
            'action' => 'index.php/loginhome',
            'reset' => RESET_FORM,
            'page_title' => APP_NAME,
            'page_heading_1' => APP_NAME,
            'page_heading_2' => 'Virtual Learning Environment',
            'flash' => $this->flash->addMessage('warning',"You were logged out due to inactivity.")
        ]);}
    else{
    return $this->view->render($response,
        'homepage.html.twig',
        [
            'landing_page' => LANDING_PAGE,
            'method' => 'post',
            'action' => 'index.php/loginhome',
            'reset' => RESET_FORM,
            'page_title' => APP_NAME,
            'page_heading_1' => APP_NAME,
            'page_heading_2' => 'Virtual Learning Environment',
        ]);
}
})->setName('homepage');

