<?php
/**
 * Created by PhpStorm.
 * User: alexmason
 * Date: 07/04/2018
 * Time: 22:56
 */

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->map(['GET', 'POST'],'/modules', function(Request $request, Response $response) use ($app)
{
    $userModel = $this->get('user_model');
    $studentModel = $this->get('student_model');

    $db_handle = $this->get('dbase');

    $SQLQueries = $this->get('SQLQueries');

    $wrapper_mysql = $this->get('MYSQLWrapper');

    $moduleTitle = '';
    $moduleTitle = $request->getParam('module');
    $moduleTitle = filter_var($moduleTitle, FILTER_SANITIZE_STRING);
    //Get Module Data
    //Announcements
    //
    $name= $userModel->getUserName($db_handle, $SQLQueries, $wrapper_mysql, $_SESSION['user']);
    return $this->view->render($response,
        'module.html.twig',
        [
            'method' => 'post',
            'action' => '/FinalYearProject/VLE_Public/loggedOut',
            'page_title' => APP_NAME,
            'page_heading_1' => APP_NAME,
            'page_heading_2' => 'Virtual Learning Environment',
            'module' => $moduleTitle,
            'module_page' => module_page,
            'studentDashboard' => studentDashboard,
            'name' => $name,

        ]);

})->setName('Module');