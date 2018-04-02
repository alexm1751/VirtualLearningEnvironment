<?php
/**
 * Created by PhpStorm.
 * User: alexmason
 * Date: 18/01/2018
 * Time: 13:37
 */

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \Respect\Validation\Validator as v;

//var_dump($_SESSION['user']);




$app->map(['GET', 'POST'], '/loginhome', function(Request $request, Response $response) use ($app) {


    $validator = $this->get('validator');

    $userModel = $this->get('user_model');

    $db_handle = $this->get('dbase');

    $SQLQueries = $this->get('SQLQueries');

    $wrapper_mysql = $this->get('MYSQLWrapper');


    $validator->validate($request,[
        'email' => v::email()->noWhitespace()->notEmpty(),
        'password' => v::noWhitespace()->notEmpty()
    ]);

    if ($validator->failed()){
        return $response->withRedirect(LANDING_PAGE);
    }

    $email = $request->getParam('email');
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    $password = $request->getParam('password');
    try{
        $userModel->check_db_login($db_handle,$SQLQueries,$wrapper_mysql, $email, $password);
       // var_dump($userModel);
    } catch (Exception $e){
        $app->flash('global', "$e");
        return $response->withRedirect(LANDING_PAGE);
   }


   // var_dump($_SESSION['user']);

//    || (time() - $_SESSION['timestamp'] > 900)){
//        unset($_SESSION['user'], $_SESSION['timestamp']);
//        header("location: /FinalYearProject/VLE_Public/");
//        exit;
//
//    }
//    else {
//        $_SESSION['timestamp'] = time(); //set new timestamp
//    }



if ($_SESSION['logged_in'] == true){

        switch ($_SESSION['rank']){
            case "1":
                return $response->withRedirect(studentDashboard);
                   // $response->withRedirect('/FinalYear/Project/VLE_Public/index.php/studentDashboard.php');
                /*return $this->view->render($response,
                    'student.html.twig',[
                        'logout_page' => LOGOUT_PAGE,
                    ]);*/
                break;

            case "2":
                return $response->withRedirect('/FinalYear/Project/VLE_Public/index.php/teacherDashboard.php');
/*                return $this->view->render($response,
                    'teacher.html.twig',[
                        'logout_page' => LOGOUT_PAGE,
                    ]);*/
                break;

            case "3":
                return $response->withRedirect('/FinalYear/Project/VLE_Public/index.php/adminDashboard.php');
                /*return $this->view->render($response,
                    'admin.html.twig',[
                        'logout_page' => LOGOUT_PAGE,
                    ]);*/
                break;

            default:
                return $this->view->render($response,
                    'loggedin.html.twig',[
                        'logout_page' => LOGOUT_PAGE,
                    ]);
        }
}
else {
    return $response
        ->withHeader("Cache-Control", " no-store, no-cache, must-revalidate, max-age=0")
        ->withHeader("Cache-Control:", " post-check=0, pre-check=0, false")
        ->withHeader("Pragma:", "no-cache")
        ->withHeader('Expires', 'Sun, 02 Jan 1990 00:00:00 GMT')
        ->withRedirect(LANDING_PAGE);
    exit;

}
})->setName('loginhome');


