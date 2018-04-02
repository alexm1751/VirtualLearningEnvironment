<?php
/**
 * Created by PhpStorm.
 * User: alexmason
 * Date: 02/04/2018
 * Time: 13:51
 */
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
$app->get('/adminDashboard', function(Request $request, Response $response) {

    if(($_SESSION['logged_in']) == false){

        return $response
            ->withHeader("Cache-Control"," no-store, no-cache, must-revalidate, max-age=0")
            ->withHeader("Cache-Control:"," post-check=0, pre-check=0, false")
            ->withHeader("Pragma:","no-cache")
            ->withHeader('Expires','Sun, 02 Jan 1990 00:00:00 GMT')
            ->withRedirect(LANDING_PAGE);
        exit;
    }

    return $this->view->render($response,
        'admin.html.twig',
        [
            'page_title' => APP_NAME,
            'page_heading_1' => APP_NAME,
            'page_heading_2' => 'Virtual Learning Environment',
            'logout_page' => LOGOUT_PAGE,


        ]);

})->setName('adminDashboard');