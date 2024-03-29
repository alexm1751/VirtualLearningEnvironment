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

    $validator = $this->get('validator');

    $userModel = $this->get('user_model');
    $studentModel = $this->get('student_model');

    $db_handle = $this->get('dbase');

    $SQLQueries = $this->get('SQLQueries');

    $wrapper_mysql = $this->get('MYSQLWrapper');
    if($_SESSION['rank'] != 1){
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
    $home = studentDashboard;
    $modules = $studentModel->getModules($db_handle,$SQLQueries,$wrapper_mysql, $_SESSION['user']);
    $_SESSION['modules'] = $modules;

    $course = $studentModel->getCourse($db_handle,$SQLQueries,$wrapper_mysql, $_SESSION['user']);

    $courseName = $course[0]['dbCourseName'];
    $announcements = $studentModel->getCourseAnnouncements($db_handle,$SQLQueries,$wrapper_mysql, $_SESSION['user'],$courseName);

    $_SESSION['form_flag'] = 0;


    $name= $userModel->getUserName($db_handle, $SQLQueries, $wrapper_mysql, $_SESSION['user']);
    $_SESSION['name'] = $name;
    return $this->view->render($response,
        'st_student.html.twig',
        [
            'page_title' => APP_NAME,
            'page_heading_1' => APP_NAME,
            'page_heading_2' => 'Virtual Learning Environment',
            'logout_page' => LOGOUT_PAGE,
            'timetable' => timetable,
            'rank' => $_SESSION['rank'],
            'name' => $_SESSION['name'],
            'modules' =>  $_SESSION['modules'],
            'module_page' => module_page,
            'course' => $course,
            'announcements' => $announcements,
            'home' => $home,
            'contact' => contact,
            'attendance' => attendance,
            'profile' => profile,
            'action' => update,
            'method' => 'post',
            'action2' => update,
            'method2' => 'post',


        ]);

})->setName('studentDashboard');