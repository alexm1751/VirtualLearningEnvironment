<?php
/**
 * Created by PhpStorm.
 * User: alexmason
 * Date: 09/04/2018
 * Time: 22:12
 */


use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->map(['GET', 'POST'],'/setPractical', function(Request $request, Response $response) use ($app)
{

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
    $userModel = $this->get('user_model');
    $teacherModel = $this->get('teacher_model');

    $db_handle = $this->get('dbase');

    $SQLQueries = $this->get('SQLQueries');

    $wrapper_mysql = $this->get('MYSQLWrapper');

    $moduleTitle = '';
    $moduleTitle = $request->getParam('module');
    $moduleTitle = filter_var($moduleTitle, FILTER_SANITIZE_STRING);
    if($moduleTitle != null){
        $_SESSION['module_name']= $moduleTitle;
    }
    $practical = $teacherModel->getPractical($db_handle,$SQLQueries,$wrapper_mysql, $_SESSION['module_name']);

    $home = teacherDashboard;
    return $this->view->render($response,
        'te_setPracticalContent.html.twig',
        [
            'flag' => $_SESSION['form_flag'],

            'value' => $_SESSION['value'],
            'page_title' => APP_NAME,
            'page_heading_1' => APP_NAME,
            'page_heading_2' => 'Virtual Learning Environment',
            'modules' =>  $_SESSION['modules'],
            'home' => $home,
            'rank' => $_SESSION['rank'],
            'timetable' => timetable,
            'name' => $_SESSION['name'],
            'practical' => $practical,
            'logout_page' => LOGOUT_PAGE,
            'module_page' => module_page,
            'module_content' => module_content,
            'profile' => profile,
            'set_theory' => setTheory,
            'set_practical' => setPractical,
            'assignments'=> assignments,
            'set_coursework' => setCoursework,
            'action' => update,
            'action2' => delete,
            'action3' => insert,
            'module'=> $_SESSION['module_name'],
            'module_id' => $_SESSION['module_id'],


        ]);

})->setName('practicalContent');