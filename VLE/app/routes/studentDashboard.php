<?php
/**
 * Created by PhpStorm.
 * User: alexmason
 * Date: 02/04/2018
 * Time: 13:50
 */
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
$app->get('/studentDashboard', function(Request $request, Response $response) {



    if((!$_SESSION['logged_in'])){
        $this->flash->addMessage('danger',"Invalid Request! No Access!");
        return $response
            ->withHeader("Cache-Control"," no-store, no-cache, must-revalidate, max-age=0")
            ->withHeader("Cache-Control"," post-check=0, pre-check=0, false")
            ->withHeader("Pragma","no-cache")
            ->withHeader('Expires','Sun, 02 Jan 1990 00:00:00 GMT')
            ->withHeader('Expires','0')
            ->withRedirect(LANDING_PAGE);
        exit;

    }

    return $this->view->render($response,
        'student.html.twig',
        [
            'page_title' => APP_NAME,
            'page_heading_1' => APP_NAME,
            'page_heading_2' => 'Virtual Learning Environment',
            'logout_page' => LOGOUT_PAGE,


        ]);

})->setName('studentDashboard');