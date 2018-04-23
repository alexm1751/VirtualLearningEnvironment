<?php
/**
 * Created by PhpStorm.
 * User: alexmason
 * Date: 08/04/2018
 * Time: 10:04
 */

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \Respect\Validation\Validator as v;

$app->map(['GET', 'POST'],'/update', function(Request $request, Response $response) use ($app) {

//Needs auth Check
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


    $validator = $this->get('validator');

    $userModel = $this->get('user_model');

    $studentModel = $this->get('student_model');
    $teacherModel = $this->get('teacher_model');
    $adminModel = $this->get('admin_model');
    $bcryptwrapper = $this->get('BcryptWrapper');
    $db_handle = $this->get('dbase');

    $SQLQueries = $this->get('SQLQueries');

    $wrapper_mysql = $this->get('MYSQLWrapper');


    $id = $request->getParam('id');


    switch ($id){
        case "2":
            if(!$_SESSION['rank']){
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
                $additionalChars="-";
                $additionalChars2="-,";
                $validator->validate($request,[

                    'name' => v::alpha($additionalChars)->stringType()->notEmpty(),
                    'address' => v::alnum($additionalChars2)->stringType()->notEmpty(),
                    'number' => v::phone()->notEmpty()

                ]);

                if ($validator->failed()){
                    $_SESSION['form_flag'] = 1;
                    return $response->withRedirect(profile);
                }

                $name = $request->getParam('name');
                $name = filter_var($name, FILTER_SANITIZE_STRING);
                $address = $request->getParam('address');
                $address = filter_var($address, FILTER_SANITIZE_STRING);
                $number = $request->getParam('number');
                $number = filter_var($number, FILTER_SANITIZE_NUMBER_INT);

                $userModel->update_profile_details($db_handle,$SQLQueries,$wrapper_mysql, $name,$address,$number,$_SESSION['user']);

                $this->flash->addMessage('success',"Your details have been updated");
                $_SESSION['form_flag'] = 0;
                 $_SESSION['name'] = $name;
                 session_regenerate_id();
                return $response->withRedirect(profile);


            }
            catch (Exception $e){
                $this->flash->addMessage('info',"Oops! We aren't sure whats happened. Please Check Your Details");
                $response->withRedirect(profile);
                return $e;
            }
            break;
        case "3":
            try{
                $pass = $request->getParam('password');

                $validator->validate($request,[

                    'old_password' => v::noWhitespace()->stringType()->notEmpty(),
                    'password' => v::noWhitespace()->stringType()->notEmpty(),
                    'password_confirm' => v:: noWhitespace()->notEmpty()->stringType()->equals($pass)

                ]);

                if ($validator->failed()){
                    $_SESSION['form_flag'] = 2;
                    return $response->withRedirect(profile);
                }

                $old_pass = $request->getParam('old_password');
                $old_pass = filter_var($old_pass, FILTER_SANITIZE_STRING);
                $pass = filter_var($pass, FILTER_SANITIZE_STRING);


                if($userModel->check_pass($db_handle,$SQLQueries,$wrapper_mysql,$_SESSION['user'],$old_pass ) === true){
                    $userModel->update_pass( $db_handle,$SQLQueries,$wrapper_mysql,$bcryptwrapper,$_SESSION['user'],$pass);
                    $this->flash->addMessage('success',"Your Password has been reset");
                    $_SESSION['form_flag'] = 0;
                    session_regenerate_id();
                    return $response->withRedirect(profile);
                }
                else{
                    $this->flash->addMessage('danger',"There was an error whilst updating your password please check your details.");
                    return $response->withRedirect(profile);
                }
            } catch (Exception $e) {
                $this->flash->addMessage('danger',"There was an issue resetting your password. Please try again.");
                return $response->withRedirect(profile);
            }
        case "4":
            $_SESSION['form_flag'] = 0;
            $_SESSION['value'] = 0;

            $array = $request->getParsedBody();
            $value = $array['value'];

            $validator->validate($request,[
                'course_name' => v::stringType()->notEmpty(),
                "course_description"=> v::stringType()->notEmpty(),
                "credits"=> v::digit()->notEmpty(),
                "years"=> v::digit()->notEmpty(),
                "degree"=> v::stringType()->notEmpty()
            ]);
            if ($validator->failed()){
                $_SESSION['form_flag'] = 5;
                $_SESSION['value'] = $value;
                return $response->withRedirect(course_edit);
            }
            try{
                $course_name = filter_var($array['course_name'], FILTER_SANITIZE_STRING);
                $course_description = filter_var($array['course_description'], FILTER_SANITIZE_STRING);
                $credits = filter_var($array['credits'], FILTER_SANITIZE_NUMBER_INT);
                $years = filter_var($array['years'], FILTER_SANITIZE_NUMBER_INT);
                $degree = filter_var($array['degree'], FILTER_SANITIZE_STRING);

              $check= $adminModel->updateCourses($db_handle,$SQLQueries,$wrapper_mysql,$course_name,$course_description,$credits,$years,$degree,$value);
                if ($check === true){
                    $this->flash->addMessage('success',"Course Edit Success!");
                    $_SESSION['form_flag'] = 0;
                    $_SESSION['value'] = 0;
                    session_regenerate_id();
                    return $response->withRedirect(course_edit);
                }
                else{
                    $this->flash->addMessage('danger',"There was an error Editing the Course.");
                    return $response->withRedirect(course_edit);
                }

            } catch (Exception $e){
                $this->flash->addMessage('danger',"There was an error Editing the Course.");
                return $response->withRedirect(course_edit);

            }
            break;
        case "5":
            $_SESSION['form_flag'] = 0;
            $_SESSION['value'] = 0;

            $array = $request->getParsedBody();
            $value = $array['value'];

            $validator->validate($request,[
                'module_title' => v::stringType()->notEmpty(),
                "module_description"=> v::stringType()->notEmpty(),
                "credits"=> v::digit()->notEmpty(),
                "course_id"=> v::digit()->noWhitespace()->notEmpty()
            ]);
            if ($validator->failed()){
                $_SESSION['form_flag'] = 5;
                $_SESSION['value'] = $value;
                return $response->withRedirect(module_edit);
            }
            try{
                $module_title = filter_var($array['module_title'], FILTER_SANITIZE_STRING);
                $module_description = filter_var($array['module_description'], FILTER_SANITIZE_STRING);
                $credits = filter_var($array['credits'], FILTER_SANITIZE_NUMBER_INT);
                $course_id = filter_var($array['course_id'], FILTER_SANITIZE_NUMBER_INT);

                $check= $adminModel->updateModules($db_handle,$SQLQueries,$wrapper_mysql, $module_title,$module_description,$credits,$course_id,$value);
                if ($check === true){
                    $this->flash->addMessage('success',"Module Edit Success!");
                    $_SESSION['form_flag'] = 0;
                    $_SESSION['value'] = 0;
                    session_regenerate_id();
                    return $response->withRedirect(module_edit);
                }
                else{
                    $this->flash->addMessage('danger',"There was an error Editing the Course.");
                    return $response->withRedirect(module_edit);
                }

            } catch (Exception $e){
                $this->flash->addMessage('danger',"There was an error Editing the Course.");
                return $response->withRedirect(module_edit);

            }
            break;
        case "6":
            $_SESSION['form_flag'] = 0;
            $_SESSION['value'] = 0;

            $array = $request->getParsedBody();
            $value = $array['value'];

            $validator->validate($request,[
                'name' => v::stringType()->notEmpty(),
                "email"=> v::email()->notEmpty()->noWhitespace(),
                "address"=> v::stringType()->notEmpty(),
                "number"=> v::digit()->notEmpty(),
                "gender"=> v::stringType()->notEmpty(),
                "rank"=> v::digit()->notEmpty()->noWhitespace()->intVal()->between(1, 2, true),
            ]);
            if ($validator->failed()){
                $_SESSION['form_flag'] = 5;
                $_SESSION['value'] = $value;
                return $response->withRedirect(user_edit);
            }
            try{
                $name = filter_var($array['name'], FILTER_SANITIZE_STRING);
                $email = filter_var($array['email'], FILTER_SANITIZE_EMAIL);
                $address = filter_var($array['address'], FILTER_SANITIZE_STRING);
                $number = filter_var($array['number'], FILTER_SANITIZE_NUMBER_INT);
                $gender = filter_var($array['gender'], FILTER_SANITIZE_STRING);
                $rank = filter_var($array['rank'], FILTER_SANITIZE_NUMBER_INT);

                $check= $adminModel->updateUsers($db_handle,$SQLQueries,$wrapper_mysql,$email,$name,$address,$number,$rank,$gender,$value);
                if ($check === true){
                    $this->flash->addMessage('success',"User Edit Success!");
                    $_SESSION['form_flag'] = 0;
                    $_SESSION['value'] = 0;
                    session_regenerate_id();
                    return $response->withRedirect(user_edit);
                }
                else{
                    $this->flash->addMessage('danger',"There was an error Editing the Course.");
                    return $response->withRedirect(user_edit);
                }

            } catch (Exception $e){
                $this->flash->addMessage('danger',"There was an error Editing the Course.");
                return $response->withRedirect(user_edit);

            }
            break;
        case "7":
            $_SESSION['form_flag'] = 0;
            $_SESSION['value'] = 0;

            $array = $request->getParsedBody();
            $value = $array['value'];

            $validator->validate($request,[
                'module_id' => v::digit()->notEmpty()->noWhitespace(),
                "date"=> v::notEmpty()->stringType(),
                "description" => v::stringType()->notEmpty(),

            ]);
            if ($validator->failed()){
                $_SESSION['form_flag'] = 5;
                $_SESSION['value'] = $value;
                return $response->withRedirect(class_schedule);
            }
            try{
                $module_id = filter_var($array['module_id'], FILTER_SANITIZE_NUMBER_INT);
                $date = filter_var($array['date'], FILTER_SANITIZE_STRING);
                $description = filter_var($array['description'], FILTER_SANITIZE_STRING);
                $date = date("Y-m-d H:i:s",strtotime($date));
                $check = $adminModel->updateClasses($db_handle, $SQLQueries, $wrapper_mysql,$value,$module_id,$date,$description);


                if ($check === true){
                    $this->flash->addMessage('success',"Class Edit Success!");
                    $_SESSION['form_flag'] = 0;
                    $_SESSION['value'] = 0;
                    session_regenerate_id();
                    return $response->withRedirect(class_schedule);
                }
                else{
                    $this->flash->addMessage('danger',"There was an error Editing the Class.");
                    return $response->withRedirect(class_schedule);
                }

            } catch (Exception $e){
                $this->flash->addMessage('danger',"There was an error Editing the Class.");
                return $response->withRedirect(class_schedule);

            }
            break;
        case "9":
            $_SESSION['form_flag'] = 0;
            $_SESSION['value'] = 0;

            $array = $request->getParsedBody();
            $value = $array['value'];

            $validator->validate($request,[
                'name' => v::stringType()->notEmpty(),
                "email"=> v::email()->notEmpty()->noWhitespace(),
                "address"=> v::stringType()->notEmpty(),
                "number"=> v::digit()->notEmpty(),
                "gender"=> v::stringType()->notEmpty(),
                "rank"=> v::digit()->notEmpty()->noWhitespace()->intVal()->between(3, 4, true),
            ]);
            if ($validator->failed()){
                $_SESSION['form_flag'] = 5;
                $_SESSION['value'] = $value;
                return $response->withRedirect(admin_edit);
            }
            try{
                $name = filter_var($array['name'], FILTER_SANITIZE_STRING);
                $email = filter_var($array['email'], FILTER_SANITIZE_EMAIL);
                $address = filter_var($array['address'], FILTER_SANITIZE_STRING);
                $number = filter_var($array['number'], FILTER_SANITIZE_NUMBER_INT);
                $gender = filter_var($array['gender'], FILTER_SANITIZE_STRING);
                $rank = filter_var($array['rank'], FILTER_SANITIZE_NUMBER_INT);

                $check= $adminModel->updateUsers($db_handle,$SQLQueries,$wrapper_mysql,$email,$name,$address,$number,$rank,$gender,$value);
                if ($check === true){
                    $this->flash->addMessage('success',"Admin Edit Success!");
                    $_SESSION['form_flag'] = 0;
                    $_SESSION['value'] = 0;
                    session_regenerate_id();
                    return $response->withRedirect(admin_edit);
                }
                else{
                    $this->flash->addMessage('danger',"There was an error Editing the Admin.");
                    return $response->withRedirect(admin_edit);
                }

            } catch (Exception $e){
                $this->flash->addMessage('danger',"There was an error Editing the Admin.");
                return $response->withRedirect(admin_edit);

            }
            break;
        case "10":
            $_SESSION['form_flag'] = 0;
            $_SESSION['value'] = 0;

            $array = $request->getParsedBody();
            $value = $array['value'];

            $validator->validate($request,[
                'announcement_title' => v::stringType()->notEmpty(),
                "description"=> v::stringType()->notEmpty(),

            ]);
            if ($validator->failed()){
                $_SESSION['form_flag'] = 5;
                $_SESSION['value'] = $value;
                return $response->withRedirect(course_announcement);
            }
            try{
                $title = filter_var($array['announcement_title'], FILTER_SANITIZE_STRING);
                $description = filter_var($array['description'], FILTER_SANITIZE_STRING);


                $check= $teacherModel->updateAnnouncements($db_handle,$SQLQueries,$wrapper_mysql,$title,$description,$value);
                if ($check === true){
                    $this->flash->addMessage('success',"Attendance Edit Success!");
                    $_SESSION['form_flag'] = 0;
                    $_SESSION['value'] = 0;
                    session_regenerate_id();
                    return $response->withRedirect(course_announcement);
                }
                else{
                    $this->flash->addMessage('danger',"There was an error Editing the Admin.");
                    return $response->withRedirect(course_announcement);
                }

            } catch (Exception $e){
                $this->flash->addMessage('danger',"There was an error Editing the Admin.");
                return $response->withRedirect(course_announcement);

            }
            break;
        case "11":
            $_SESSION['form_flag'] = 0;
            $_SESSION['value'] = 0;

            $array = $request->getParsedBody();
            $value = $array['value'];

            $validator->validate($request,[
                'announcement_title' => v::stringType()->notEmpty(),
                "description"=> v::stringType()->notEmpty(),

            ]);
            if ($validator->failed()){
                $_SESSION['form_flag'] = 5;
                $_SESSION['value'] = $value;
                return $response->withRedirect(module_announcement);
            }
            try{
                $title = filter_var($array['announcement_title'], FILTER_SANITIZE_STRING);
                $description = filter_var($array['description'], FILTER_SANITIZE_STRING);


                $check= $teacherModel->updateAnnouncements($db_handle,$SQLQueries,$wrapper_mysql,$title,$description,$value);
                if ($check === true){
                    $this->flash->addMessage('success',"Attendance Edit Success!");
                    $_SESSION['form_flag'] = 0;
                    $_SESSION['value'] = 0;
                    session_regenerate_id();
                    return $response->withRedirect(module_announcement);
                }
                else{
                    $this->flash->addMessage('danger',"There was an error Editing the Admin.");
                    return $response->withRedirect(module_announcement);
                }

            } catch (Exception $e){
                $this->flash->addMessage('danger',"There was an error Editing the Admin.");
                return $response->withRedirect(module_announcement);

            }
            break;
        case "12":
            $_SESSION['form_flag'] = 0;
            $_SESSION['value'] = 0;

            $array = $request->getParsedBody();
            $value = $array['value'];

            $validator->validate($request,[
                'feedback' => v::stringType()->notEmpty(),
            ]);
            if ($validator->failed()){
                $_SESSION['form_flag'] = 5;
                $_SESSION['value'] = $value;
                return $response->withRedirect(assignments);
            }
            try{

                $feedback = filter_var($array['feedback'], FILTER_SANITIZE_STRING);


                $check= $teacherModel->updateSubmissions($db_handle,$SQLQueries,$wrapper_mysql,$feedback,$value);
                if ($check === true){
                    $this->flash->addMessage('success',"Marking Success!");
                    $_SESSION['form_flag'] = 0;
                    $_SESSION['value'] = 0;
                    session_regenerate_id();
                    return $response->withRedirect(assignments);
                }
                else{
                    $this->flash->addMessage('danger',"There was an error marking the submission.");
                    return $response->withRedirect(assignments);
                }

            } catch (Exception $e){
                $this->flash->addMessage('danger',"There was an error marking the submission.");
                return $response->withRedirect(assignments);

            }
            break;
        case "13";
            $_SESSION['form_flag'] = 0;
            $_SESSION['value'] = 0;

            $array = $request->getParsedBody();
            $value = $array['value'];

            $validator->validate($request,[
                'feedback' => v::stringType()->notEmpty(),
            ]);
            if ($validator->failed()){
                $_SESSION['form_flag'] = 6;
                $_SESSION['value'] = $value;
                return $response->withRedirect(assignments);
            }
            try{

                $feedback = filter_var($array['feedback'], FILTER_SANITIZE_STRING);


                $check= $teacherModel->updateSubmissions($db_handle,$SQLQueries,$wrapper_mysql,$feedback,$value);
                if ($check === true){
                    $this->flash->addMessage('success',"Feedback Edit Success!");
                    $_SESSION['form_flag'] = 0;
                    $_SESSION['value'] = 0;
                    session_regenerate_id();
                    return $response->withRedirect(assignments);
                }
                else{
                    $this->flash->addMessage('danger',"There was an error editing the submission.");
                    return $response->withRedirect(assignments);
                }

            } catch (Exception $e){
                $this->flash->addMessage('danger',"There was an error editing the submission.");
                return $response->withRedirect(assignments);

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


    // Check user rank and check id else kick back

})->setName('update');