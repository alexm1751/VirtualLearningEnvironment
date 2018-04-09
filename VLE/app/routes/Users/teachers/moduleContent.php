<?php
/**
 * Created by PhpStorm.
 * User: alexmason
 * Date: 09/04/2018
 * Time: 20:30
 */

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
$app->get('/moduleContent', function(Request $request, Response $response) {

    if($_SESSION['rank'] != 2){
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
    $courseName = '';
    $moduleTitle = '';
    $courseName = $request->getParam('course');
    $courseName = filter_var($courseName, FILTER_SANITIZE_STRING);
    $moduleTitle = $request->getParam('module');
    $moduleTitle = filter_var($moduleTitle, FILTER_SANITIZE_STRING);

    $validator = $this->get('validator');

    $userModel = $this->get('user_model');
    $teacherModel = $this->get('teacher_model');

    $db_handle = $this->get('dbase');

    $SQLQueries = $this->get('SQLQueries');

    $wrapper_mysql = $this->get('MYSQLWrapper');


    $home = teacherDashboard;

    return $this->view->render($response,
        'moduleForm.html.twig',
        [
            'page_title' => APP_NAME,
            'page_heading_1' => APP_NAME,
            'home' => $home,
            'page_heading_2' => 'Virtual Learning Environment',
            'logout_page' => LOGOUT_PAGE,
            'name' => $_SESSION['name'],
            'modules' =>  $_SESSION['modules'],
            'courses' =>  $_SESSION['courses'],
            'rank' => $_SESSION['rank'],
            'contact' => contact,
            'profile' => profile,
            'module_content' => module_content,
            'assignments'=> assignments,
            'module'=> $moduleTitle,
            'course'=> $courseName,
            'set_theory' => setTheory,
            'set_practical' => setPractical,
            'set_coursework' => setCoursework,
            'action' => update,
            'method' => 'post',
            'action2' => update,
            'method2' => 'post',


        ]);

})->setName('moduleContent');