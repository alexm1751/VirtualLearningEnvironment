<?php
/**
 * Created by PhpStorm.
 * User: alexmason
 * Date: 09/04/2018
 * Time: 22:12
 */


use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->map(['GET', 'POST'],'/setTheory', function(Request $request, Response $response) use ($app)
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
    $teacher = $this->get('student_model');

    $db_handle = $this->get('dbase');

    $SQLQueries = $this->get('SQLQueries');

    $wrapper_mysql = $this->get('MYSQLWrapper');

    $moduleTitle = '';
    $moduleTitle = $request->getParam('module');
    $moduleTitle = filter_var($moduleTitle, FILTER_SANITIZE_STRING);
    //Get Module Data
    //Announcements
    //
    $home = teacherDashboard;
    return $this->view->render($response,
        'setTheoryContent.html.twig',
        [

            'page_title' => APP_NAME,
            'page_heading_1' => APP_NAME,
            'page_heading_2' => 'Virtual Learning Environment',
            'module' => $moduleTitle,
            'modules' =>  $_SESSION['modules'],
            'home' => $home,
            'rank' => $_SESSION['rank'],
            'timetable' => timetable,
            'name' => $_SESSION['name'],
            'logout_page' => LOGOUT_PAGE,
            'module_page' => module_page,
            'module_content' => module_content,
            'profile' => profile,
            'set_theory' => setTheory,
            'set_practical' => setPractical,
            'set_coursework' => setCoursework,
            'assignments'=> assignments,
            'action' => update,
            'method' => 'post',
            'action2' => update,
            'method2' => 'post',


        ]);

})->setName('theoryContent');