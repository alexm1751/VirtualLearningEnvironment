<?php
/**
 * Created by PhpStorm.
 * User: alexmason
 * Date: 02/04/2018
 * Time: 13:51
 */
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
$app->get('/teacherDashboard', function(Request $request, Response $response) {
    $validator = $this->get('validator');

    $userModel = $this->get('user_model');

    $db_handle = $this->get('dbase');

    $SQLQueries = $this->get('SQLQueries');

    $wrapper_mysql = $this->get('MYSQLWrapper');
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

   $name = $userModel->getUserName($db_handle, $SQLQueries, $wrapper_mysql, $_SESSION['user']);


    return $this->view->render($response,
        'teacher.html.twig',
        [
            'page_title' => APP_NAME,
            'page_heading_1' => APP_NAME,
            'page_heading_2' => 'Virtual Learning Environment',
            'logout_page' => LOGOUT_PAGE,
            'name' => $name

        ]);

})->setName('teacherDashboard');