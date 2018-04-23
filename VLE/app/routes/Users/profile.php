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
    if ($_SESSION['logged_in'] == true){

        switch ($_SESSION['rank']){
            case "1":
                $home = studentDashboard;
                break;

            case "2":
                $home = teacherDashboard;

                break;

            case "3":
                $home = adminDashboard;

                break;

            case "4":
                $home = adminDashboard;

                break;
            default:
                $_SESSION = array();
                $this->flash->addMessage('info',"Oops! We aren't sure whats happened. Please try to login again.");
                return $response
                    ->withHeader("Cache-Control", " no-store, no-cache, must-revalidate, max-age=0")
                    ->withHeader("Cache-Control:", " post-check=0, pre-check=0, false")
                    ->withHeader("Pragma:", "no-cache")
                    ->withHeader('Expires', 'Sun, 02 Jan 1990 00:00:00 GMT')
                    ->withRedirect(LANDING_PAGE);
                exit;
        }
    }
    else {
        $_SESSION = array();
        $this->flash->addMessage('info',"Oops! We aren't sure whats happened. Please try to login again.");
        return $response
            ->withHeader("Cache-Control", " no-store, no-cache, must-revalidate, max-age=0")
            ->withHeader("Cache-Control:", " post-check=0, pre-check=0, false")
            ->withHeader("Pragma:", "no-cache")
            ->withHeader('Expires', 'Sun, 02 Jan 1990 00:00:00 GMT')
            ->withRedirect(LANDING_PAGE);
        exit;

    }
    $userModel = $this->get('user_model');


    $db_handle = $this->get('dbase');

    $SQLQueries = $this->get('SQLQueries');

    $wrapper_mysql = $this->get('MYSQLWrapper');

    $details= $userModel->get_profile_details($db_handle, $SQLQueries, $wrapper_mysql, $_SESSION['user']);


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
            'home' => $home,
            'details' => $details,
            'rank' => $_SESSION['rank'],
            'contact' => contact,
            'attendance' => attendance,
            'profile' => profile,
            'timetable' => timetable,
            'name' => $_SESSION['name'],
            'flag' => $_SESSION['form_flag'],
            'modules' =>  $_SESSION['modules'],
            'courses' =>  $_SESSION['courses'],
            'logout_page' => LOGOUT_PAGE,
            'course_edit' => course_edit,
            'module_edit' => module_edit,
            'module_content' => module_content,
            'course_announcement' => course_announcement,
            'module_announcement' => module_announcement,
            'user_edit' => user_edit,
            'class_schedule' => class_schedule,
            'timetables' => timetables,
            'admin_edit' => admin_edit,
            'attendance_form' => setAttendance,



        ]);

})->setName('profile');