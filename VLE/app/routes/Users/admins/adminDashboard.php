<?php
/**
 * Created by PhpStorm.
 * User: alexmason
 * Date: 02/04/2018
 * Time: 13:51
 */
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
$app->get('/adminDashboard', function(Request $request, Response $response) {

/*    if($_SESSION['rank'] != 3 || $_SESSION['rank'] != 4){
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
    }*/
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
    $name = $userModel->getUserName($db_handle, $SQLQueries, $wrapper_mysql, $_SESSION['user']);
    $_SESSION['name'] = $name;

    $_SESSION['form_flag'] = 0;


    if ($_SESSION['logged_in'] == true){

                return $this->view->render($response,
                    'ad_admin.html.twig',
                    [
                        'page_title' => APP_NAME,
                        'page_heading_1' => APP_NAME,
                        'page_heading_2' => 'Virtual Learning Environment',
                        'logout_page' => LOGOUT_PAGE,
                        'name' => $name,
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




                    ]);}
    else {
        $this->flash->addMessage('info',"Oops! We aren't sure whats happened. Please try to login again.");

        return $response
            ->withHeader("Cache-Control", " no-store, no-cache, must-revalidate, max-age=0")
            ->withHeader("Cache-Control:", " post-check=0, pre-check=0, false")
            ->withHeader("Pragma:", "no-cache")
            ->withHeader('Expires', 'Sun, 02 Jan 1990 00:00:00 GMT')
            ->withRedirect(LANDING_PAGE);
        exit;

    }


})->setName('adminDashboard');