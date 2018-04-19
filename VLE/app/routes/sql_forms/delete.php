<?php
/**
 * Created by PhpStorm.
 * User: alexmason
 * Date: 08/04/2018
 * Time: 10:29
 */

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \Respect\Validation\Validator as v;

$app->map(['GET', 'POST'],'/delete', function(Request $request, Response $response) use($app){
    if (!$id = $request->getParam('id')){
        $_SESSION = array();
        $this->flash->addMessage('info',"Oops! We aren't sure whats happened. Would you mind logging again?.");
        return $response
            ->withHeader("Cache-Control", " no-store, no-cache, must-revalidate, max-age=0")
            ->withHeader("Cache-Control:", " post-check=0, pre-check=0, false")
            ->withHeader("Pragma:", "no-cache")
            ->withHeader('Expires', 'Sun, 02 Jan 1990 00:00:00 GMT')
            ->withRedirect(LANDING_PAGE);
        exit;
    }

    $id = $request->getParam('id');

    $validator = $this->get('validator');

    $studentModel = $this->get('student_model');
    $teacherModel = $this->get('teacher_model');


    $db_handle = $this->get('dbase');

    $SQLQueries = $this->get('SQLQueries');

    $wrapper_mysql = $this->get('MYSQLWrapper');


    $id = $request->getParam('id');


    switch ($id){
        case "2":
            $this->flash->addMessage('success',"Course Delete Success!");
            return $response->withRedirect(course_edit);
        case "3":
            $this->flash->addMessage('success',"Module Delete Success!");
            return $response->withRedirect(module_edit);
        case "4":
            $this->flash->addMessage('success',"User Delete Success!");
            return $response->withRedirect(user_edit);
        case "5":
            $this->flash->addMessage('success',"Delete Allocation Success!");
            return $response->withRedirect(user_edit);
        case "6":
            $this->flash->addMessage('success',"Class Delete Success!");
            return $response->withRedirect(class_schedule);
        case "7":
            $this->flash->addMessage('success',"Timetable Delete Success!");
            return $response->withRedirect(timetables);
        case "8":
            $this->flash->addMessage('success',"Admin Delete Success!");
            return $response->withRedirect(admin_edit);
        case "9":
            $checkID= $request->getParam('class_id');
            $check = $teacherModel->check_attendance($db_handle, $SQLQueries, $wrapper_mysql, $checkID);
            if($check != true){

                $teacherModel->deleteAttendance($db_handle, $SQLQueries, $wrapper_mysql, $checkID);
                $this->flash->addMessage('success', "Attendance Cleared for " .$checkID);
                return $response->withRedirect(setAttendance);
            }
            else{
                $this->flash->addMessage('info', $checkID ." is already clear. Please Create New.");
                return $response->withRedirect(setAttendance);
            }



    }
    
    
    // Check user rank and check id else kick back
    

})->setName('delete');