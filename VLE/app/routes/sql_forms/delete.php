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

/*
 * This Controller handles all Delete calls from all users of the web application
 * Each user form has an associated hidden ID value which corresponds to an action on this controller
 * Default value is set to fail and kick user and request authentication.
 * Using post method for this with hidden value protects the value to some extent
 * If ID is not set initially the user will be redirected to login again.
 * Only Teachers and Admins have access to remove things from the Database
 */

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


    $teacherModel = $this->get('teacher_model');
    $adminModel = $this->get('admin_model');



    $db_handle = $this->get('dbase');

    $SQLQueries = $this->get('SQLQueries');

    $wrapper_mysql = $this->get('MYSQLWrapper');


    $id = $request->getParam('id');


    switch ($id){
        //Course Delete
        case "2":
            $array = $request->getParsedBody();

            try{
                $course_id = filter_var($array['course_id'], FILTER_SANITIZE_NUMBER_INT);

              $check= $adminModel->removeCourses($db_handle,$SQLQueries,$wrapper_mysql,$course_id);
                if ($check === true){
                    $this->flash->addMessage('success',"Course Delete Success!");
                    session_regenerate_id();
                    return $response->withRedirect(course_edit);
                }
                else{
                    $this->flash->addMessage('danger',"There was an error Deleting the Course.");
                    return $response->withRedirect(course_edit);
                }

            } catch (Exception $e){
                $this->flash->addMessage('danger',"There was an error Deleting the Course.");
                return $response->withRedirect(course_edit);

            }
        break;
            //Module Delete
        case "3":
            $array = $request->getParsedBody();

            try{
                $module_id = filter_var($array['module_id'], FILTER_SANITIZE_NUMBER_INT);

                $check= $adminModel->removeModules($db_handle,$SQLQueries,$wrapper_mysql,$module_id);
                if ($check === true){
                    $this->flash->addMessage('success',"Module Delete Success!");
                    session_regenerate_id();
                    return $response->withRedirect(module_edit);
                }
                else{
                    $this->flash->addMessage('danger',"There was an error Deleting the Module.");
                    return $response->withRedirect(module_edit);
                }

            } catch (Exception $e){
                $this->flash->addMessage('danger',"There was an error Deleting the Module.");
                return $response->withRedirect(module_edit);

            }
            break;
            //User Delete
        case "4":
            $array = $request->getParsedBody();

            try{
                $user_id = filter_var($array['user_id'], FILTER_SANITIZE_NUMBER_INT);

                $check= $adminModel->removeUsers($db_handle,$SQLQueries,$wrapper_mysql,$user_id);
                if ($check === true){
                    $this->flash->addMessage('success',"User Delete Success!");
                    session_regenerate_id();
                    return $response->withRedirect(user_edit);
                }
                else{
                    $this->flash->addMessage('danger',"There was an error Deleting the User.");
                    return $response->withRedirect(user_edit);
                }

            } catch (Exception $e){
                $this->flash->addMessage('danger',"There was an error Deleting the User.");
                return $response->withRedirect(user_edit);

            }
            break;
            //User Allocation Delete
        case "5":

            $array = $request->getParsedBody();

            try{
                $user_id = filter_var($array['user_id'], FILTER_SANITIZE_NUMBER_INT);
                $course_id = filter_var($array['course_id'], FILTER_SANITIZE_NUMBER_INT);


                $check= $adminModel->removeAllocation($db_handle,$SQLQueries,$wrapper_mysql,$user_id,$course_id);
                if ($check === true){
                    $this->flash->addMessage('success',"Delete Allocation Success!");
                    session_regenerate_id();
                    return $response->withRedirect(user_edit);
                }
                else{
                    $this->flash->addMessage('danger',"There was an error Deleting the Allocation.");
                    return $response->withRedirect(user_edit);
                }

            } catch (Exception $e){
                $this->flash->addMessage('danger',"There was an error Deleting the Allocation.");
                return $response->withRedirect(user_edit);

            }
            break;
            //Class Delete
        case "6":
            $array = $request->getParsedBody();

            try{
                $class_id = filter_var($array['class_id'], FILTER_SANITIZE_NUMBER_INT);


                $check= $adminModel->removeClasses($db_handle,$SQLQueries,$wrapper_mysql,$class_id);
                if ($check === true){
                    $this->flash->addMessage('success',"Class Delete Success!");
                    session_regenerate_id();
                    return $response->withRedirect(class_schedule);
                }
                else{
                    $this->flash->addMessage('danger',"There was an error Deleting the Class.");
                    return $response->withRedirect(class_schedule);
                }

            } catch (Exception $e){
                $this->flash->addMessage('danger',"There was an error Deleting the Class.");
                return $response->withRedirect(class_schedule);

            }
            break;
            //Timetable delete
        case "7":
            try{
                $array = $request->getParsedBody();

                $filename = $array['delete_file'];
                $table_id = $array['table_id'];
                $base = base_url;
                $filename = ($base . $filename);
                if(file_exists($filename)){
                    unlink($filename);
                    $check= $adminModel->removeTimetables($db_handle,$SQLQueries,$wrapper_mysql,$table_id);
                    if ($check === true){
                        $this->flash->addMessage('success',"Timetable Delete Success!");
                        session_regenerate_id();
                        return $response->withRedirect(timetables);
                    }
                    else{
                        $this->flash->addMessage('danger',"There was an error Deleting the Timetable.");
                        return $response->withRedirect(timetables);
                    }
                }
                else{
                    $this->flash->addMessage('danger',"There was an error Deleting the Timetable.");
                    return $response->withRedirect(timetables);
                }

            } catch (Exception $e){
                $this->flash->addMessage('danger',"There was an error Deleting the Timetable.");
                return $response->withRedirect(timetables);

            }
            break;
            //Admin Delete
        case "8":
            $array = $request->getParsedBody();

            $email = filter_var($array['email'], FILTER_SANITIZE_EMAIL);

            if($email === $_SESSION['user']){
                $this->flash->addMessage('danger',"You are not able to delete yourself while signed in.");
                return $response->withRedirect(admin_edit);
            }

            try{
                $user_id = filter_var($array['user_id'], FILTER_SANITIZE_NUMBER_INT);

                $check= $adminModel->removeUsers($db_handle,$SQLQueries,$wrapper_mysql,$user_id);
                if ($check === true){
                    $this->flash->addMessage('success',"Admin Delete Success!");
                    session_regenerate_id();
                    return $response->withRedirect(admin_edit);
                }
                else{
                    $this->flash->addMessage('danger',"There was an error Deleting the Admin.");
                    return $response->withRedirect(admin_edit);
                }

            } catch (Exception $e){
                $this->flash->addMessage('danger',"There was an error Deleting the Admin.");
                return $response->withRedirect(admin_edit);

            }
            break;
            //Teacher Clear attendance
        case "9":
            $checkID= $request->getParam('class_id');
            $check = $teacherModel->check_attendance($db_handle, $SQLQueries, $wrapper_mysql, $checkID);
            if($check != true){

                $teacherModel->deleteAttendance($db_handle, $SQLQueries, $wrapper_mysql, $checkID);
                $this->flash->addMessage('success', "Attendance Cleared for " .$checkID);
                session_regenerate_id();
                return $response->withRedirect(setAttendance);
            }
            else{
                $this->flash->addMessage('info', $checkID ." is already clear. Please Create New.");
                return $response->withRedirect(setAttendance);
            }
             break;
            //Delete Course Announcement
        case "10":
            $array = $request->getParsedBody();

            try{
                $announcement_id = filter_var($array['announcement_id'], FILTER_SANITIZE_NUMBER_INT);


                $check= $teacherModel->removeCourseAnnouncement($db_handle,$SQLQueries,$wrapper_mysql,$announcement_id);
                if ($check === true){
                    $this->flash->addMessage('success',"Announcement Delete Success!");
                    session_regenerate_id();
                    return $response->withRedirect(course_announcement);
                }
                else{
                    $this->flash->addMessage('danger',"There was an error Deleting the Announcement.");
                    return $response->withRedirect(course_announcement);
                }

            } catch (Exception $e){
                $this->flash->addMessage('danger',"There was an error Deleting the Announcement.");
                return $response->withRedirect(course_announcement);

            }
            break;
            //Delete Module Announcement
        case "11":
            $array = $request->getParsedBody();

            try{
                $announcement_id = filter_var($array['announcement_id'], FILTER_SANITIZE_NUMBER_INT);


                $bool= $teacherModel->removeCourseAnnouncement($db_handle,$SQLQueries,$wrapper_mysql,$announcement_id);
                if ($bool === true){
                    $this->flash->addMessage('success',"Announcement Delete Success!");
                    session_regenerate_id();
                    return $response->withRedirect(module_announcement);
                }
                else{
                    $this->flash->addMessage('danger',"There was an error Deleting the Announcement.");
                    return $response->withRedirect(module_announcement);
                }

            } catch (Exception $e){
                $this->flash->addMessage('danger',"There was an error Deleting the Announcement.");
                return $response->withRedirect(module_announcement);

            }
            break;
            //Delete Coursework
        case "12":
            try{
                $array = $request->getParsedBody();

                $filename = $array['delete_file'];
                $table_id = $array['table_id'];
                $base = base_url;
                $filename = ($base . $filename);
                if(file_exists($filename)){
                    unlink($filename);
                    $check= $teacherModel->removeCoursework($db_handle,$SQLQueries,$wrapper_mysql,$table_id);
                    if ($check === true){
                        $this->flash->addMessage('success',"Coursework Delete Success!");
                        session_regenerate_id();
                        return $response->withRedirect(setCoursework);
                    }
                    else{
                        $this->flash->addMessage('danger',"There was an error Deleting the Coursework.");
                        return $response->withRedirect(setCoursework);
                    }
                }
                else{
                    $this->flash->addMessage('danger',"There was an error Deleting the Coursework.");
                    return $response->withRedirect(setCoursework);
                }

            } catch (Exception $e){
                $this->flash->addMessage('danger',"There was an error Deleting the Coursework.");
                return $response->withRedirect(setCoursework);

            }
            break;
            //Delete Practical Work
        case "13":
            try{
                $array = $request->getParsedBody();

                $filename = $array['delete_file'];
                $table_id = $array['table_id'];
                $base = base_url;
                $filename = ($base . $filename);
                if(file_exists($filename)){
                    unlink($filename);
                    $check= $teacherModel->removeLearning($db_handle,$SQLQueries,$wrapper_mysql,$table_id);
                    if ($check === true){
                        $this->flash->addMessage('success'," Practical Work Delete Success!");
                        session_regenerate_id();
                        return $response->withRedirect(setPractical);
                    }
                    else{
                        $this->flash->addMessage('danger',"There was an error Deleting the Practical Work.");
                        return $response->withRedirect(setPractical);
                    }
                }
                else{
                    $this->flash->addMessage('danger',"There was an error Deleting the Practical Work.");
                    return $response->withRedirect(setPractical);
                }

            } catch (Exception $e){
                $this->flash->addMessage('danger',"There was an error Deleting the Practical Work.");
                return $response->withRedirect(setPractical);

            }
            break;
            //Delete Theory Work
        case "14":
            try{
                $array = $request->getParsedBody();

                $filename = $array['delete_file'];
                $table_id = $array['table_id'];
                $base = base_url;
                $filename = ($base . $filename);
                if(file_exists($filename)){
                    unlink($filename);
                    $check= $teacherModel->removeLearning($db_handle,$SQLQueries,$wrapper_mysql,$table_id);
                    if ($check === true){
                        $this->flash->addMessage('success',"Theory Work Delete Success!");
                        session_regenerate_id();
                        return $response->withRedirect(setTheory);
                    }
                    else{
                        $this->flash->addMessage('danger',"There was an error Deleting the Theory Work.");
                        return $response->withRedirect(setTheory);
                    }
                }
                else{
                    $this->flash->addMessage('danger',"There was an error Deleting the Theory Work.");
                    return $response->withRedirect(setTheory);
                }

            } catch (Exception $e){
                $this->flash->addMessage('danger',"There was an error Deleting the Theory Work.");
                return $response->withRedirect(setTheory);

            }
            break;
            //Delete Assignment
        case "15":
            try{
                $array = $request->getParsedBody();

                $filename = $array['delete_file'];
                $table_id = $array['table_id'];
                $base = base_url;
                $filename = ($base . $filename);
                if(file_exists($filename)){
                    unlink($filename);
                    $check= $teacherModel->removeSubmissions($db_handle,$SQLQueries,$wrapper_mysql,$table_id);
                    if ($check === true){
                        $this->flash->addMessage('success',"Assignment Delete Success!");
                        session_regenerate_id();
                        return $response->withRedirect(assignments);
                    }
                    else{
                        $this->flash->addMessage('danger',"There was an error Deleting the  Assignment.");
                        return $response->withRedirect(assignments);
                    }
                }
                else{
                    $this->flash->addMessage('danger',"There was an error Deleting the Assignment.");
                    return $response->withRedirect(assignments);
                }

            } catch (Exception $e){
                $this->flash->addMessage('danger',"There was an error Deleting the  Assignment.");
                return $response->withRedirect(assignments);

            }
            break;
            //If unknown ID is passed or random parameter
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
    
    
    // Check user rank and check id else kick back
    

})->setName('delete');