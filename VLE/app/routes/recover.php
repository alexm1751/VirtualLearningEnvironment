<?php
/**
 * Created by PhpStorm.
 * User: alexmason
 * Date: 02/04/2018
 * Time: 21:46
 */


use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;



$app->get('/recover', function(Request $request, Response $response)
{
    $validator = $this->get('validator');
    $userModel = $this->get('user_model');
    $db_handle = $this->get('dbase');
    $SQLQueries = $this->get('SQLQueries');
    $wrapper_mysql = $this->get('MYSQLWrapper');

    //needs error handling
    $email = $request->getParam('email');
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    $identifier = $request->getParam('identifier');
    //$identifier = filter_var($identifier, FILTER_SANITIZE_STRING);
//    var_dump($email . '' . $identifier);


    $userExists = $userModel->check_db_user($db_handle,$SQLQueries,$wrapper_mysql, $email);
    $hashWorks = $userModel->check_recover_hash($db_handle,$SQLQueries,$wrapper_mysql, $email,$identifier);

    if($userExists == false || $hashWorks == false){
        return $response
            ->withHeader("Cache-Control", " no-store, no-cache, must-revalidate, max-age=0")
            ->withHeader("Cache-Control:", " post-check=0, pre-check=0, false")
            ->withHeader("Pragma:", "no-cache")
            ->withHeader('Expires', 'Sun, 02 Jan 1990 00:00:00 GMT')
            ->withRedirect(LANDING_PAGE);
        exit;
    }


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


        ]);


})->setName('recover');