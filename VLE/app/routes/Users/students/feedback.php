<?php
/**
 * Created by PhpStorm.
 * User: alexmason
 * Date: 09/04/2018
 * Time: 14:45
 */

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->map(['GET', 'POST'],'/feedback', function(Request $request, Response $response) use ($app)
{

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
    $userModel = $this->get('user_model');
    $studentModel = $this->get('student_model');

    $db_handle = $this->get('dbase');

    $SQLQueries = $this->get('SQLQueries');

    $wrapper_mysql = $this->get('MYSQLWrapper');

    $moduleTitle = '';
    $moduleTitle = $request->getParam('module');
    $moduleTitle = filter_var($moduleTitle, FILTER_SANITIZE_STRING);
    $feedback = $studentModel->getFeedback($db_handle,$SQLQueries,$wrapper_mysql,$moduleTitle, $_SESSION['user']);
    //Get Module Data
    //Announcements
    //
    $home = studentDashboard;
    return $this->view->render($response,
        'st_feedback.html.twig',
        [

            'page_title' => APP_NAME,
            'page_heading_1' => APP_NAME,
            'page_heading_2' => 'Virtual Learning Environment',
            'module' => $moduleTitle,
            'rank' => $_SESSION['rank'],
            'home' => $home,
            'timetable' => timetable,
            'feedback' => $feedback,
            'name' => $_SESSION['name'],
            'logout_page' => LOGOUT_PAGE,
            'profile' => profile,
            'module_feedback' => feedback,
            'staff_info' => staffinfo,
            'module_content' => learning,
            'module_assessment' => assessment,
            'module_page' => module_page,


        ]);

})->setName('feedback');