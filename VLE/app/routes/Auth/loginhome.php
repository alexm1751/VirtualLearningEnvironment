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

//Validation method allows no white space. Redirects if error is found
    $validator->validate($request,[
        'email' => v::email()->noWhitespace()->notEmpty(),
        'password' => v::noWhitespace()->notEmpty()
    ]);

    if ($validator->failed()){
        return $response->withRedirect(LANDING_PAGE);
    }

    //Once details pass through validation sanitise them

    $email = $request->getParam('email');
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    $password = $request->getParam('password');
    $password = filter_var($password, FILTER_SANITIZE_STRING);

    //Login
    try{
        $userModel->check_db_login($db_handle,$SQLQueries,$wrapper_mysql, $email, $password);
    } catch (Exception $e){
        $this->flash->addMessage('danger',"Issue With Email or Password. Please Try again.");
        return $response->withRedirect(LANDING_PAGE);
   }

//Switch statement check users rank from authenticated db call and then guide them to the correct homepage
if ($_SESSION['logged_in'] == true){

        switch ($_SESSION['rank']){
            case "1":
                return $response->withRedirect(studentDashboard);
                break;

            case "2":
                return $response->withRedirect(teacherDashboard);

                break;

            case "3":
                return $response->withRedirect(adminDashboard);

                break;

            case "4":
                return $response->withRedirect(adminDashboard);

                break;
                //Default is to fail and kick user out.
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
        //If the user gets to this point their authentication has failed in someway redirect with info message
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
})->setName('loginhome');


