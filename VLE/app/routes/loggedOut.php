<?php
/**
 * Created by PhpStorm.
 * User: alexmason
 * Date: 01/04/2018
 * Time: 22:41
 */

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->post( '/loggedOut', function(Request $request, Response $response) {
    $_SESSION = array();
    session_destroy();
    if((!$_SESSION['logged_in'])){
        $this->flash->addMessage('global',"Invalid Request! No Access!");
        echo time();
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
        'loggedOut.html.twig',
        [

        ]);


})->setName('loggedOut');


