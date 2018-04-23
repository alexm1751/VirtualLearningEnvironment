<?php
/**
 * Created by PhpStorm.
 * User: alexmason
 * Date: 08/04/2018
 * Time: 10:30
 */

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \Respect\Validation\Validator as v;
use Slim\Http\UploadedFile;

/*
 * This Controller handles all new insertion calls from all users of the web application
 * Each user form has an associated hidden ID value which corresponds to an action on this controller
 * Default value is set to fail and kick user and request authentication.
 * Using post method for this with hidden value protects the value to some extent
 * If ID is not set initially the user will be redirected to login again.
 * All users can insert into the database
 * Form Flag is a global used to provide twig information on which form failed and then reopens the form for the user.
 */

$app->map(['GET', 'POST'], '/insert', function(Request $request, Response $response) use ($app){

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

    $userModel = $this->get('user_model');

    $studentModel = $this->get('student_model');
    $teacherModel = $this->get('teacher_model');
    $adminModel = $this->get('admin_model');
    $bcryptwrapper = $this->get('BcryptWrapper');


    $db_handle = $this->get('dbase');

    $SQLQueries = $this->get('SQLQueries');

    $wrapper_mysql = $this->get('MYSQLWrapper');




    switch ($id){
        //Submit Assignment - Student
        case "2":
            if($_SESSION['rank'] != 1){
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
            try{
                $user_id = $request->getParam('user');
                $cw_id = $request->getParam('cwID');
                $exists = $studentModel->check_submission($db_handle,$SQLQueries,$wrapper_mysql, $user_id,$cw_id);

            }catch (Exception $e){
                $this->flash->addMessage('info',"Oops! We aren't sure whats happened. Please Check Your Coursework");
                return $response->withRedirect(assessment);
            }

            if($exists == false){
                $this->flash->addMessage('info',"You have already submitted this assignment. Contact your lecturer to change this.");
                return $response->withRedirect(assessment);
            }
            else{
                //Check file is not empty then check certain size and file type.
            try {
                $directory = directory;
                $m_directory = m_directory;
                $uploadedFiles = $request->getUploadedFiles();
                if (!empty($uploadedFile = $uploadedFiles['file'])) {
                    $fileSize = $uploadedFile->getSize();
                    $fileName = $uploadedFile->getClientFilename();


                    $fileExt = explode('.', $fileName);
                    $fileActualExt = strtolower(end($fileExt));

                    $allowed = array('pdf');

                    if (in_array($fileActualExt, $allowed)) {
                        if ($fileSize < 500000) {

                            if ($uploadedFile->getError() === UPLOAD_ERR_OK) {
                                $filename = moveUploadedFile($directory, $uploadedFile);
                                try{
                                    $filename = ($m_directory . DIRSEP . $filename);
                                    $studentModel->submitAssessments($db_handle,$SQLQueries,$wrapper_mysql,$user_id,$cw_id,$filename);
                                    $this->flash->addMessage('success', "You Successfully Submitted Your Assignment!");
                                    session_regenerate_id();
                                    return $response->withRedirect(assessment);
                                }catch (Exception $e){
                                    $this->flash->addMessage('danger', "There was an Error Uploading the File!");
                                    return $response->withRedirect(assessment);
                                }


                            } else {
                                $this->flash->addMessage('danger', "There was an Error Uploading the File!");
                                return $response->withRedirect(assessment);
                            }
                        } else {

                            $this->flash->addMessage('danger', "Invalid File Size!");
                            return $response->withRedirect(assessment);
                        }
                    } else {

                        $this->flash->addMessage('danger', "Invalid File Type Uploaded!");
                        return $response->withRedirect(assessment);

                    }

                } else {
                    $this->flash->addMessage('danger', "Empty File Detected");
                    return $response->withRedirect(assessment);
                }
                // handle single input with single file upload
            } catch (Exception $e) {
                var_dump($e);

            }

        }
        break;
            //Create Course
        case "3":
            $_SESSION['form_flag'] = 0;
            $array = $request->getParsedBody();

            $validator->validate($request,[
                'course_name' => v::stringType()->notEmpty(),
                "course_description"=> v::stringType()->notEmpty(),
                "credits"=> v::digit()->notEmpty(),
                "years"=> v::digit()->notEmpty(),
                "degree"=> v::stringType()->notEmpty()
            ]);
            if ($validator->failed()){
                $_SESSION['form_flag'] = 3;
                return $response->withRedirect(course_edit);
            }
            try{
                $course_name = filter_var($array['course_name'], FILTER_SANITIZE_STRING);
                $course_description = filter_var($array['course_description'], FILTER_SANITIZE_STRING);
                $credits = filter_var($array['credits'], FILTER_SANITIZE_NUMBER_INT);
                $years = filter_var($array['years'], FILTER_SANITIZE_NUMBER_INT);
                $degree = filter_var($array['degree'], FILTER_SANITIZE_STRING);

                $adminModel->setCourses($db_handle,$SQLQueries,$wrapper_mysql,$course_name,$course_description,$credits,$years,$degree);
                $this->flash->addMessage('success',"New Course Created!");
                $_SESSION['form_flag'] = 0;
                session_regenerate_id();
                return $response->withRedirect(course_edit);
            } catch (Exception $e){
                $this->flash->addMessage('danger',"There was an error creating a new Course.");
                return $response->withRedirect(course_edit);

            }
            break;
            //Create Module
        case "4":
            $_SESSION['form_flag'] = 0;
            $array = $request->getParsedBody();

            $validator->validate($request,[
                'module_title' => v::stringType()->notEmpty(),
                "module_description"=> v::stringType()->notEmpty(),
                "credits"=> v::digit()->notEmpty(),
                "course_id"=> v::digit()->noWhitespace()->notEmpty()
            ]);
            if ($validator->failed()){
                $_SESSION['form_flag'] = 3;

                return $response->withRedirect(module_edit);
            }
            try{
                $module_title = filter_var($array['module_title'], FILTER_SANITIZE_STRING);
                $module_description = filter_var($array['module_description'], FILTER_SANITIZE_STRING);
                $credits = filter_var($array['credits'], FILTER_SANITIZE_NUMBER_INT);
                $course_id = filter_var($array['course_id'], FILTER_SANITIZE_NUMBER_INT);

                try{
                    $adminModel->setModules($db_handle,$SQLQueries,$wrapper_mysql, $module_title,$module_description,$credits,$course_id);

                } catch (Exception $e){
                    $this->flash->addMessage('danger',"There was an error creating a new Module.");
                    return $response->withRedirect(module_edit);
                }

                $this->flash->addMessage('success',"New Module Created!");
                $_SESSION['form_flag'] = 0;
                session_regenerate_id();
                return $response->withRedirect(module_edit);
            } catch (Exception $e){
                $this->flash->addMessage('danger',"There was an error creating a new Module.");
                return $response->withRedirect(module_edit);

            }
            break;
            //Create User
        case "5":
            $_SESSION['form_flag'] = 0;
            $array = $request->getParsedBody();

            $validator->validate($request,[
                'name' => v::stringType()->notEmpty(),
                "email"=> v::email()->notEmpty()->noWhitespace(),
                "address"=> v::stringType()->notEmpty(),
                "number"=> v::digit()->notEmpty(),
                "gender"=> v::stringType()->notEmpty(),
                "rank"=> v::digit()->notEmpty()->noWhitespace()->intVal()->between(1, 2, true),
                "password"=> v::notEmpty()->noWhitespace()->stringType(),
            ]);
            if ($validator->failed()){
                $_SESSION['form_flag'] = 3;

                return $response->withRedirect(user_edit);
            }
            try{
                $name = filter_var($array['name'], FILTER_SANITIZE_STRING);
                $email = filter_var($array['email'], FILTER_SANITIZE_EMAIL);
                $address = filter_var($array['address'], FILTER_SANITIZE_STRING);
                $number = filter_var($array['number'], FILTER_SANITIZE_NUMBER_INT);
                $gender = filter_var($array['gender'], FILTER_SANITIZE_STRING);
                $rank = filter_var($array['rank'], FILTER_SANITIZE_NUMBER_INT);
                $password = filter_var($array['password'], FILTER_SANITIZE_STRING);
                $password = $bcryptwrapper->create_hashed_string($password);
                $check = $userModel->check_db_user($db_handle,$SQLQueries,$wrapper_mysql, $email);
                try{
                    if($rank > 2){
                        $this->flash->addMessage('danger',"Users do not have access to this rank. Please use 1(Student) or 2(Teacher)");
                        return $response->withRedirect(user_edit);
                     }
                    elseif($check == false){
                        $adminModel->setUsers($db_handle,$SQLQueries,$wrapper_mysql, $password,$email,$name,$address,$number,$rank,$gender);
                        $this->flash->addMessage('success',"New User Created!");
                        $_SESSION['form_flag'] = 0;
                        session_regenerate_id();
                        return $response->withRedirect(user_edit);
                    }
                    else{
                        $this->flash->addMessage('danger',"The Email is already being used. Please check your details");
                        return $response->withRedirect(user_edit);
                    }

                } catch (Exception $e){
                    $this->flash->addMessage('danger',"There was an error creating a new User.");
                    return $response->withRedirect(user_edit);
                }


            } catch (Exception $e){
                $this->flash->addMessage('danger',"There was an error creating a new User.");
                return $response->withRedirect(user_edit);

            }
            break;
            //Create User Allocation
        case "6":
            $_SESSION['form_flag'] = 0;
            $array = $request->getParsedBody();

            $validator->validate($request,[
                'user_id' => v::digit()->notEmpty()->noWhitespace(),
                "course_id"=> v::digit()->notEmpty()->noWhitespace(),

            ]);
            if ($validator->failed()){
                $_SESSION['form_flag'] = 4;
//                $_SESSION['form_id'] =
                return $response->withRedirect(user_edit);
            }
            try{
                $user_id = filter_var($array['user_id'], FILTER_SANITIZE_STRING);
                $course_id = filter_var($array['course_id'], FILTER_SANITIZE_STRING);
                $rank= $adminModel->get_rank_id($db_handle,$SQLQueries,$wrapper_mysql, $user_id);


                if($rank == 1){
                    if($adminModel->check_user_allocation($db_handle,$SQLQueries,$wrapper_mysql, $user_id)) {
                        //Add Allocation
                        $teacher = 0;
                        $modules = $adminModel->getCourseModules($db_handle, $SQLQueries, $wrapper_mysql, $course_id);
                        foreach ($modules as $module) {
                            $adminModel->setAllocation($db_handle, $SQLQueries, $wrapper_mysql,$teacher,$user_id,$course_id,$module['dbModuleID']);

                        }
                        $this->flash->addMessage('success',"New User Allocation Created!");
                        $_SESSION['form_flag'] = 0;
                        session_regenerate_id();
                        return $response->withRedirect(user_edit);
                    }
                    else{
                        $this->flash->addMessage('danger',"Students can only have one Course Allocation");
                        return $response->withRedirect(user_edit);
                    }

                }
                elseif($rank == 2){
                    $teacher = 1;
                    $modules= $adminModel->getCourseModules($db_handle,$SQLQueries,$wrapper_mysql, $course_id);
                    foreach ($modules as $module) {
                        $adminModel->setAllocation($db_handle, $SQLQueries, $wrapper_mysql,$teacher,$user_id,$course_id,$module['dbModuleID']);
                    }
                    $this->flash->addMessage('success',"New User Allocation Created!");
                    $_SESSION['form_flag'] = 0;
                    session_regenerate_id();
                    return $response->withRedirect(user_edit);

                }
                else{
                    $this->flash->addMessage('danger',"This User is not eligible for course Allocation" . $rank);
                    return $response->withRedirect(user_edit);
                }


            } catch (Exception $e){
                $this->flash->addMessage('danger',"There was an error creating Allocation.");
                return $response->withRedirect(user_edit);

            }
            break;
            //Create New Class
        case "7":
            $_SESSION['form_flag'] = 0;
            $array = $request->getParsedBody();

            $validator->validate($request,[
                'module_id' => v::digit()->notEmpty()->noWhitespace(),
                "date"=> v::notEmpty()->stringType(),
                "description" => v::stringType()->notEmpty(),

            ]);
            if ($validator->failed()){
                $_SESSION['form_flag'] = 3;

                return $response->withRedirect(class_schedule);
            }
            try{
                $module_id = filter_var($array['module_id'], FILTER_SANITIZE_NUMBER_INT);
                $date = filter_var($array['date'], FILTER_SANITIZE_STRING);
                $description = filter_var($array['description'], FILTER_SANITIZE_STRING);
                $date = date("Y-m-d H:i:s",strtotime($date));
                $check = $adminModel->setClasses($db_handle, $SQLQueries, $wrapper_mysql,$module_id,$date,$description);

                if($check == true){
                    $this->flash->addMessage('success',"New Class Created!");
                    $_SESSION['form_flag'] = 0;
                    session_regenerate_id();
                    return $response->withRedirect(class_schedule);
                }
                else{
                    $this->flash->addMessage('danger',"There was an error creating the Class.");
                    return $response->withRedirect(class_schedule);
                }

            } catch (Exception $e){
                $this->flash->addMessage('danger',"There was an error creating the Class.");
                return $response->withRedirect(class_schedule);

            }
            break;
            //Create Timetable
        case "8":
            $_SESSION['form_flag'] = 0;
            $uploadedFiles = $request->getUploadedFiles();

            $course_id = $request->getParam('course_id');


            $validator->validate($request,[
                'course_id' => v::digit()->notEmpty()->noWhitespace(),

            ]);
            if ($validator->failed()){
                $_SESSION['form_flag'] = 3;

                return $response->withRedirect(timetables);
            }

                $course_id = filter_var($course_id, FILTER_SANITIZE_NUMBER_INT);


            $exists = $adminModel->check_timetable($db_handle,$SQLQueries,$wrapper_mysql, $course_id);


            if($exists != true){
                $this->flash->addMessage('danger', "Timetable already exists for this Course $course_id");
                return $response->withRedirect(timetables);
            }
            else {
                try {
                $directory = directory;
                $m_directory = m_directory;
                if (!empty($uploadedFile = $uploadedFiles['file'])) {
                    $fileSize = $uploadedFile->getSize();
                    $fileName = $uploadedFile->getClientFilename();


                    $fileExt = explode('.', $fileName);
                    $fileActualExt = strtolower(end($fileExt));

                    $allowed = array('pdf');

                    if (in_array($fileActualExt, $allowed)) {
                        if ($fileSize < 500000) {

                            if ($uploadedFile->getError() === UPLOAD_ERR_OK) {
                                $filename = moveUploadedFile($directory, $uploadedFile);
                                try{
                                    $filename = ($m_directory . DIRSEP . $filename);
                                    $adminModel->setTimetables($db_handle,$SQLQueries,$wrapper_mysql,$filename, $course_id);
                                    $this->flash->addMessage('success', "You Successfully Submitted a Timetable!");
                                    session_regenerate_id();
                                    return $response->withRedirect(timetables);
                                }catch (Exception $e){
                                    $this->flash->addMessage('danger', "There was an Error Uploading the File!");
                                    return $response->withRedirect(timetables);
                                }


                            } else {
                                $this->flash->addMessage('danger', "There was an Error Uploading the File!");
                                return $response->withRedirect(timetables);
                            }
                        } else {

                            $this->flash->addMessage('danger', "Invalid File Size!");
                            return $response->withRedirect(timetables);
                        }
                    } else {

                        $this->flash->addMessage('danger', "Invalid File Type Uploaded!");
                        return $response->withRedirect(timetables);

                    }

                } else {
                    $this->flash->addMessage('danger', "Empty File Detected");
                    return $response->withRedirect(timetables);
                }
                // handle single input with single file upload
            } catch (Exception $e) {
                throwException($e);
                    $this->flash->addMessage('danger', "Empty File Detected");
                    return $response->withRedirect(timetables);
            }
            }
            break;
            //Create Admin
        case "9":
            $_SESSION['form_flag'] = 0;
            $array = $request->getParsedBody();

            $validator->validate($request,[
                'name' => v::stringType()->notEmpty(),
                "email"=> v::email()->notEmpty()->noWhitespace(),
                "address"=> v::stringType()->notEmpty(),
                "number"=> v::digit()->notEmpty(),
                "gender"=> v::stringType()->notEmpty(),
                "rank"=> v::digit()->notEmpty()->noWhitespace()->intVal()->between(3, 4, true),
                "password"=> v::notEmpty()->noWhitespace()->stringType(),
            ]);
            if ($validator->failed()){
                $_SESSION['form_flag'] = 3;

                return $response->withRedirect(admin_edit);
            }
            try{
                $name = filter_var($array['name'], FILTER_SANITIZE_STRING);
                $email = filter_var($array['email'], FILTER_SANITIZE_EMAIL);
                $address = filter_var($array['address'], FILTER_SANITIZE_STRING);
                $number = filter_var($array['number'], FILTER_SANITIZE_NUMBER_INT);
                $gender = filter_var($array['gender'], FILTER_SANITIZE_STRING);
                $rank = filter_var($array['rank'], FILTER_SANITIZE_NUMBER_INT);
                $password = filter_var($array['password'], FILTER_SANITIZE_STRING);
                $password = $bcryptwrapper->create_hashed_string($password);
                $check = $userModel->check_db_user($db_handle,$SQLQueries,$wrapper_mysql, $email);
                try{
                    if($rank > 4 || $rank < 3){
                        $this->flash->addMessage('danger',"Users do not have access to this rank. Please use 3(Admin) or 4(Super Admin)");
                        return $response->withRedirect(admin_edit);
                    }
                    elseif($check == false){
                        $adminModel->setAdmins($db_handle,$SQLQueries,$wrapper_mysql, $password,$email,$name,$address,$number,$rank,$gender);
                        $this->flash->addMessage('success',"New Admin Created!");
                        $_SESSION['form_flag'] = 0;
                        session_regenerate_id();
                        return $response->withRedirect(admin_edit);
                    }
                    else{
                        $this->flash->addMessage('danger',"The Email is already being used. Please check your details");
                        return $response->withRedirect(admin_edit);
                    }

                } catch (Exception $e){
                    $this->flash->addMessage('danger',"There was an error creating a new Admin.");
                    return $response->withRedirect(admin_edit);
                }


            } catch (Exception $e){
                $this->flash->addMessage('danger',"There was an error creating a new Admin.");
                return $response->withRedirect(admin_edit);

            }
            break;
            //Insert Attendance - Teacher
        case "10":
            $checkID= $request->getParam('class_id');
            $checkID = $checkID[0];
            $check = $teacherModel->check_attendance($db_handle, $SQLQueries, $wrapper_mysql, $checkID);
            if($check != true){
                $this->flash->addMessage('info', "Attendance for ClassID: ". $checkID ." is already set please clear before resubmitting.");
                return $response->withRedirect(setAttendance);
            }
            else{
                try{
                    $classID= $request->getParam('class_id');
                    $uniqueID= $request->getParam('unique_id');
                    $present = $request->getParam('present');


                    for ($i = 0; $i<count($uniqueID); $i++) {
                        $n_cid = $classID[$i];
                        $n_uid = $uniqueID[$i];
                        $n_present = $present[$i];

                        $teacherModel->setAttendance($db_handle, $SQLQueries, $wrapper_mysql, $n_cid, $n_uid, $n_present);

                    }
                    $this->flash->addMessage('success',"Attendance Recorded!");
                    session_regenerate_id();
                    return $response->withRedirect(setAttendance);
                }catch (Exception $e){
                    $this->flash->addMessage('warning', "Oops There was an Error please try again.");
                    return $response->withRedirect(setAttendance);
                }
            }
            break;
            //Create Course Announcement
        case "11":
            $_SESSION['form_flag'] = 0;
            $array = $request->getParsedBody();

            $validator->validate($request,[
                'announcement_title' => v::notEmpty()->stringType(),
                "announcement_description"=> v::notEmpty()->stringType(),

            ]);
            if ($validator->failed()){
                $_SESSION['form_flag'] = 3;

                return $response->withRedirect(course_announcement);
            }
            try{
                $module_id = 'NULL';
                $course_id = $array['course_id'];
                $title = filter_var($array['announcement_title'], FILTER_SANITIZE_STRING);
                $description = filter_var($array['announcement_description'], FILTER_SANITIZE_STRING);

                $check = $teacherModel->setAnnouncements($db_handle, $SQLQueries, $wrapper_mysql,$title,$course_id,$module_id,$description);

                if($check == true){
                    $this->flash->addMessage('success',"New Announcement Created!");
                    $_SESSION['form_flag'] = 0;
                    session_regenerate_id();
                    return $response->withRedirect(course_announcement);
                }
                else{
                    $this->flash->addMessage('danger',"There was an error creating the Announcement.");
                    return $response->withRedirect(course_announcement);
                }

            } catch (Exception $e){
                $this->flash->addMessage('danger',"There was an error creating the Announcement.");
                return $response->withRedirect(course_announcement);

            }
            break;
        case "12";
        //Create Module Announcement
            $_SESSION['form_flag'] = 0;
            $array = $request->getParsedBody();

            $validator->validate($request,[
                'announcement_title' => v::notEmpty()->stringType(),
                "announcement_description"=> v::notEmpty()->stringType(),

            ]);
            if ($validator->failed()){
                $_SESSION['form_flag'] = 3;

                return $response->withRedirect(module_announcement);
            }
            try{
                $module_id = filter_var($array['module_id'], FILTER_SANITIZE_NUMBER_INT);
                $course_id = filter_var($array['course_id'],FILTER_SANITIZE_NUMBER_INT);
                $title = filter_var($array['announcement_title'], FILTER_SANITIZE_STRING);
                $description = filter_var($array['announcement_description'], FILTER_SANITIZE_STRING);

                if($teacherModel->setAnnouncements($db_handle, $SQLQueries, $wrapper_mysql,$title,$course_id,$module_id,$description)){
                    $this->flash->addMessage('success',"New Announcement Created!");
                    $_SESSION['form_flag'] = 0;
                    session_regenerate_id();
                    return $response->withRedirect(module_announcement);
                }
                else{
                    $this->flash->addMessage('danger',"There was an error creating the Announcement.");
                    return $response->withRedirect(module_announcement);
                }

            } catch (Exception $e){
                $this->flash->addMessage('danger',"There was an error creating the Announcement.");
                return $response->withRedirect(module_announcement);

            }
            break;
            //Create Coursework
        case "13":
            $_SESSION['form_flag'] = 0;

            $uploadedFiles = $request->getUploadedFiles();
            $array = $request->getParsedBody();



            $validator->validate($request,[
                'module_id' => v::digit()->notEmpty()->noWhitespace(),
                'description'=> v::notEmpty()->stringType(),
                'deadline'=> v::notEmpty()->stringType(),

            ]);
            if ($validator->failed()){
                $_SESSION['form_flag'] = 3;

                return $response->withRedirect(setCoursework);
            }

            $module_id = filter_var($array['module_id'], FILTER_SANITIZE_NUMBER_INT);
            $description = filter_var($array['description'], FILTER_SANITIZE_STRING);
            $date = date("Y-m-d H:i:s",strtotime($array['deadline']));

                try {
                    $directory = directory;
                    $m_directory = m_directory;
                    if (!empty($uploadedFile = $uploadedFiles['file'])) {
                        $fileSize = $uploadedFile->getSize();
                        $fileName = $uploadedFile->getClientFilename();


                        $fileExt = explode('.', $fileName);
                        $fileActualExt = strtolower(end($fileExt));

                        $allowed = array('pdf');

                        if (in_array($fileActualExt, $allowed)) {
                            if ($fileSize < 500000) {

                                if ($uploadedFile->getError() === UPLOAD_ERR_OK) {
                                    $filename = moveUploadedFile($directory, $uploadedFile);
                                    try{
                                        $filename = ($m_directory . DIRSEP . $filename);
                                        $teacherModel->setCoursework($db_handle,$SQLQueries,$wrapper_mysql,$module_id,$description,$date,$filename);
                                        $this->flash->addMessage('success',"New Coursework Created!");
                                        session_regenerate_id();
                                        return $response->withRedirect(setCoursework);
                                    }catch (Exception $e){
                                        $this->flash->addMessage('danger', "There was an Error Uploading the File!");
                                        return $response->withRedirect(setCoursework);
                                    }


                                } else {
                                    $this->flash->addMessage('danger', "There was an Error Uploading the File!");
                                    return $response->withRedirect(setCoursework);
                                }
                            } else {

                                $this->flash->addMessage('danger', "Invalid File Size!");
                                return $response->withRedirect(setCoursework);
                            }
                        } else {

                            $this->flash->addMessage('danger', "Invalid File Type Uploaded!");
                            return $response->withRedirect(setCoursework);

                        }

                    } else {
                        $this->flash->addMessage('danger', "Empty File Detected");
                        return $response->withRedirect(setCoursework);
                    }
                    // handle single input with single file upload
                } catch (Exception $e) {
                    throwException($e);
                    $this->flash->addMessage('danger', "There was an Error Uploading the File!");
                    return $response->withRedirect(setCoursework);

                }
            break;
                //Create Practical Work
        case "14":
            $_SESSION['form_flag'] = 0;

            $uploadedFiles = $request->getUploadedFiles();
            $array = $request->getParsedBody();


            $validator->validate($request,[
                'title'=> v::notEmpty()->stringType(),
                'description'=> v::notEmpty()->stringType(),

            ]);
            if ($validator->failed()){
                $_SESSION['form_flag'] = 3;

                return $response->withRedirect(setPractical);
            }

            $module_id = $array['module_id'];
            $title = filter_var($array['title'], FILTER_SANITIZE_STRING);
            $description = filter_var($array['description'], FILTER_SANITIZE_STRING);


            try {
                $directory = directory;
                $m_directory = m_directory;
                if (!empty($uploadedFile = $uploadedFiles['file'])) {
                    $fileSize = $uploadedFile->getSize();
                    $fileName = $uploadedFile->getClientFilename();


                    $fileExt = explode('.', $fileName);
                    $fileActualExt = strtolower(end($fileExt));

                    $allowed = array('pdf');

                    if (in_array($fileActualExt, $allowed)) {
                        if ($fileSize < 500000) {

                            if ($uploadedFile->getError() === UPLOAD_ERR_OK) {
                                $filename = moveUploadedFile($directory, $uploadedFile);
                                try{
                                    $filename = ($m_directory . DIRSEP . $filename);

                                    $teacherModel->setPractical($db_handle,$SQLQueries,$wrapper_mysql,$module_id,$title,$description,$filename);
                                    $this->flash->addMessage('success',"New Practical Work Created!");
                                    session_regenerate_id();
                                    return $response->withRedirect(setPractical);
                                }catch (Exception $e){
                                    $this->flash->addMessage('danger', "There was an Error Uploading the File!");
                                    return $response->withRedirect(setPractical);
                                }


                            } else {
                                $this->flash->addMessage('danger', "There was an Error Uploading the File!");
                                return $response->withRedirect(setPractical);
                            }
                        } else {

                            $this->flash->addMessage('danger', "Invalid File Size!");
                            return $response->withRedirect(setPractical);
                        }
                    } else {

                        $this->flash->addMessage('danger', "Invalid File Type Uploaded!");
                        return $response->withRedirect(setPractical);

                    }

                } else {
                    $this->flash->addMessage('danger', "Empty File Detected");
                    return $response->withRedirect(setPractical);
                }
                // handle single input with single file upload
            } catch (Exception $e) {
                throwException($e);
                $this->flash->addMessage('danger', "There was an Error Uploading the File!");
                return $response->withRedirect(setPractical);
            }
            break;


        case "15":
            //Create Theory Work

        $_SESSION['form_flag'] = 0;

            $uploadedFiles = $request->getUploadedFiles();
            $array = $request->getParsedBody();


            $validator->validate($request,[
                'title'=> v::notEmpty()->stringType(),
                'description'=> v::notEmpty()->stringType(),

            ]);
            if ($validator->failed()){
                $_SESSION['form_flag'] = 3;
//                $_SESSION['form_id'] =
                return $response->withRedirect(setTheory);
            }

            $module_id = $array['module_id'];
            $title = filter_var($array['title'], FILTER_SANITIZE_STRING);
            $description = filter_var($array['description'], FILTER_SANITIZE_STRING);


            try {
                $directory = directory;
                $m_directory = m_directory;
                if (!empty($uploadedFile = $uploadedFiles['file'])) {
                    $fileSize = $uploadedFile->getSize();
                    $fileName = $uploadedFile->getClientFilename();


                    $fileExt = explode('.', $fileName);
                    $fileActualExt = strtolower(end($fileExt));

                    $allowed = array('pdf');

                    if (in_array($fileActualExt, $allowed)) {
                        if ($fileSize < 500000) {

                            if ($uploadedFile->getError() === UPLOAD_ERR_OK) {
                                $filename = moveUploadedFile($directory, $uploadedFile);
                                try{
                                    $filename = ($m_directory . DIRSEP . $filename);

                                    $teacherModel->setTheory($db_handle,$SQLQueries,$wrapper_mysql,$module_id,$title,$description,$filename);
                                    $this->flash->addMessage('success',"New Practical Work Created!");
                                    session_regenerate_id();
                                    return $response->withRedirect(setTheory);
                                }catch (Exception $e){
                                    $this->flash->addMessage('danger', "There was an Error Uploading the File!");
                                    return $response->withRedirect(setTheory);
                                }


                            } else {
                                $this->flash->addMessage('danger', "There was an Error Uploading the File!");
                                return $response->withRedirect(setTheory);
                            }
                        } else {

                            $this->flash->addMessage('danger', "Invalid File Size!");
                            return $response->withRedirect(setTheory);
                        }
                    } else {

                        $this->flash->addMessage('danger', "Invalid File Type Uploaded!");
                        return $response->withRedirect(setTheory);

                    }

                } else {
                    $this->flash->addMessage('danger', "Empty File Detected");
                    return $response->withRedirect(setTheory);
                }
                // handle single input with single file upload
            } catch (Exception $e) {
                throwException($e);
                $this->flash->addMessage('danger', "There was an Error Uploading the File!");
                return $response->withRedirect(setPractical);

            }
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




    // Change the files name and produce a file location file name. Move file to this location



})->setName('insert');

function moveUploadedFile($directory, $uploadedFile)
{
    $extension = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);
    $basename = bin2hex(random_bytes(8)); // see http://php.net/manual/en/function.random-bytes.php
    $filename = sprintf('%s.%0.8s', $basename, $extension);

    $uploadedFile->moveTo($directory . DIRECTORY_SEPARATOR . $filename);

    return $filename;
}