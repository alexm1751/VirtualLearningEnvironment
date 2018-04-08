<?php
/**
 * Created by PhpStorm.
 * User: alexmason
 * Date: 08/04/2018
 * Time: 02:17
 */

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
$app->map(['GET', 'POST'],'/profile', function(Request $request, Response $response) use ($app)
{
    $userModel = $this->get('user_model');
    $studentModel = $this->get('student_model');

    $db_handle = $this->get('dbase');

    $SQLQueries = $this->get('SQLQueries');

    $wrapper_mysql = $this->get('MYSQLWrapper');

    $modules = $studentModel->getModules($db_handle,$SQLQueries,$wrapper_mysql, $_SESSION['user']);

    //
    $name= $userModel->getUserName($db_handle, $SQLQueries, $wrapper_mysql, $_SESSION['user']);
    return $this->view->render($response,
        'profile.html.twig',
        [
            'method' => 'GET',
            'action' => update,
            'method2' => 'GET',
            'action2' => update,
            'page_title' => APP_NAME,
            'page_heading_1' => APP_NAME,
            'page_heading_2' => 'Virtual Learning Environment',
            'module_page' => module_page,
            'studentDashboard' => studentDashboard,
            'contact' => contact,
            'attendance' => attendance,
            'profile' => profile,
            'name' => $name,
            'modules' =>  $_SESSION['modules'],
            'logout_page' => LOGOUT_PAGE,



        ]);

})->setName('profile');