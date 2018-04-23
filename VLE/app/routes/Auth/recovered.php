<?php
/**
 * Created by PhpStorm.
 * User: alexmason
 * Date: 03/04/2018
 * Time: 04:36
 */

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \Respect\Validation\Validator as v;


$app->map(['GET', 'POST'],'/recovered', function(Request $request, Response $response) use ($app)
{

    if (!$_SESSION['email']){
       // $this->flash->addMessage('danger',"Here");
        $this->flash->addMessage('danger',"Invalid Request! No Access!");
        return $response
            ->withHeader("Cache-Control"," no-store, no-cache, must-revalidate, max-age=0")
            ->withHeader("Cache-Control"," post-check=0, pre-check=0, false")
            ->withHeader("Pragma","no-cache")
            ->withHeader('Expires','Sun, 02 Jan 1990 00:00:00 GMT')
            ->withRedirect(LANDING_PAGE);
        exit;
    }

    $validator = $this->get('validator');
    $userModel = $this->get('user_model');
    $db_handle = $this->get('dbase');
    $SQLQueries = $this->get('SQLQueries');
    $wrapper_mysql = $this->get('MYSQLWrapper');
    $bcryptwrapper = $this->get('BcryptWrapper');

    $email = $_SESSION['email'];
    $identifier = $_SESSION['identifier'];
//validation for password reset if the user does not enter a matching password

    $validator->validate($request,[
        'password' => v:: noWhitespace()->notEmpty()->stringType()
    ]);
    $pass1 = $request->getParam('password');

    if ($validator->failed()){
        return $response->withRedirect(recover_form . "?email=" . $email . "&identifier=" . $identifier );
    }

    $validator->validate($request,[
        'password_confirm' => v:: noWhitespace()->notEmpty()->stringType()->equals($pass1)
    ]);

    if ($validator->failed()){
        return $response->withRedirect(recover_form . "?email=" . $email . "&identifier=" . $identifier);
    }

    $pass2 = $request->getParam('password_confirm');

    $pass2 = filter_var($pass2, FILTER_SANITIZE_STRING);

    //after validation sanitise string
    $email = $_SESSION['email'];
    //Hash new password and enter into the DB
    $userModel->update_pass( $db_handle,$SQLQueries,$wrapper_mysql,$bcryptwrapper,$email,$pass2);

    //Remove Recover Hash
    unset ($_SESSION['email']);
    unset ($_SESSION['identifier']);
    // Redirect to Homepage and Flash Reset Complete! success alert

    $this->flash->addMessage('success',"Password Reset!");
    return $response
        ->withHeader("Cache-Control"," no-store, no-cache, must-revalidate, max-age=0")
        ->withHeader("Cache-Control"," post-check=0, pre-check=0, false")
        ->withHeader("Pragma","no-cache")
        ->withHeader('Expires','Sun, 02 Jan 1990 00:00:00 GMT')
        ->withRedirect(LANDING_PAGE);
    exit;
})->setName('recovered');