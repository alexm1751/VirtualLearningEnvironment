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
      session_destroy();
    session_start();
    $this->flash->addMessage('danger',"You were logged out due to inactivity.");
    return $response
        ->withHeader("Cache-Control"," no-store, no-cache, must-revalidate, max-age=0")
        ->withHeader("Cache-Control"," post-check=0, pre-check=0, false")
        ->withHeader("Pragma","no-cache")
        ->withHeader('Expires','Sun, 02 Jan 1990 00:00:00 GMT')
        ->withHeader('Expires','0')
        ->withRedirect(LANDING_PAGE);
    exit;
    }
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

