<?php
/**
 * Created by PhpStorm.
 * User: alexmason
 * Date: 02/04/2018
 * Time: 21:46
 */


use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \Respect\Validation\Validator as v;


$app->get('/recover', function(Request $request, Response $response)
{

    $userModel = $this->get('user_model');
    $db_handle = $this->get('dbase');
    $SQLQueries = $this->get('SQLQueries');
    $wrapper_mysql = $this->get('MYSQLWrapper');

    //needs error handling
    $email = $request->getParam('email');
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    $identifier = $request->getParam('identifier');
    $identifier = filter_var($identifier, FILTER_SANITIZE_STRING);
    $_SESSION['email']= $email;
    $_SESSION['identifier']= $identifier;

    //This controller is dealing with the password reset request, if the hash does not match or is not present then the user has already reset their password and the email link they are using has expired
    try{
        $hashWorks = $userModel->check_recover_hash($db_handle,$SQLQueries,$wrapper_mysql, $email,$identifier);

    }
    catch (Exception $e){
        $this->flash->addMessage('danger',"Invalid Request! No Access!");
       // $this->flash->addMessage('danger',"Invalid Request! No Access!");
        return $response
            ->withHeader("Cache-Control"," no-store, no-cache, must-revalidate, max-age=0")
            ->withHeader("Cache-Control"," post-check=0, pre-check=0, false")
            ->withHeader("Pragma","no-cache")
            ->withHeader('Expires','Sun, 02 Jan 1990 00:00:00 GMT')
            ->withRedirect(LANDING_PAGE);
        exit;
    }

//if either of these functions fail then the user is denied password reset request

    $userExists = $userModel->check_db_user($db_handle,$SQLQueries,$wrapper_mysql, $email);

    if($userExists == false || $hashWorks == false){
        $this->flash->addMessage('danger',"There was an issue with processing your request.");
        return $response
            ->withHeader("Cache-Control", " no-store, no-cache, must-revalidate, max-age=0")
            ->withHeader("Cache-Control:", " post-check=0, pre-check=0, false")
            ->withHeader("Pragma:", "no-cache")
            ->withHeader('Expires', 'Sun, 02 Jan 1990 00:00:00 GMT')
            ->withRedirect(LANDING_PAGE);
        exit;
    }
//proceed to password reset

    return $this->view->render($response,
        'resetPassword.html.twig',
        [
            /*'css_path' => CSS_PATH,*/
            'landing_page' => LANDING_PAGE,
            'method' => 'post',
            'action' => RECOVERED,
            'page_title' => APP_NAME,
            'page_heading_1' => APP_NAME,
            'page_heading_2' => 'Virtual Learning Environment',
            'email' => $email,
            'identifier' => $identifier

        ]);


})->setName('recover');