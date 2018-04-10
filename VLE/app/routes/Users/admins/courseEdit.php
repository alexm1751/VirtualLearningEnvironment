<?php
/**
 * Created by PhpStorm.
 * User: alexmason
 * Date: 09/04/2018
 * Time: 23:23
 */

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
$app->get('/courseEdit', function(Request $request, Response $response) {

    if((!$_SESSION['logged_in'])){
        session_destroy();
        session_start();
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

    $validator = $this->get('validator');

    $userModel = $this->get('user_model');
    $adminModel = $this->get('admin_model');

    $db_handle = $this->get('dbase');

    $SQLQueries = $this->get('SQLQueries');

    $wrapper_mysql = $this->get('MYSQLWrapper');


    //if Rank 4 super admin, delete or add new admins!! :D
    $home = adminDashboard;






    return $this->view->render($response,
        'ad_courseEdit.html.twig',
        [
            'page_title' => APP_NAME,
            'page_heading_1' => APP_NAME,
            'page_heading_2' => 'Virtual Learning Environment',
            'logout_page' => LOGOUT_PAGE,
            'name' => $_SESSION['name'],
            'rank' => $_SESSION['rank'],
            'home' => $home,
            'course_edit' => course_edit,
            'module_edit' => module_edit,
            'user_edit' => user_edit,
            'class_schedule' => class_schedule,
            'timetables' => timetables,
            'admin_edit' => admin_edit,
            'contact' => contact,
            'profile' => profile,




        ]);



})->setName('courseEdit');