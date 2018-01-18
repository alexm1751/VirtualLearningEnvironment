<?php
/**
 * Created by PhpStorm.
 * User: alexmason
 * Date: 18/01/2018
 * Time: 13:47
 */

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;


$app->map(['GET', 'POST'], '/passwordreset', function(Request $request, Response $response) use ($app) {

    echo ('Please Enter your user name or email to be reset.');
//    $c_arr_clean_message = [];
//
//    $xml_parser = $this->get('xml_parser');
//
//    $validator = $this->get('validator');
//
//    $sms_model = $this->get('sms_model');
//
//    $db_handle = $this->get('dbase');
//
//    $sql_queries = $this->get('sql_queries');
//
//    $wrapper_mysql = $this->get('mysql_wrapper');
//
//    $bcrypt_wrapper = $this->get('bcrypt_wrapper');
//
//
//    $arr_tainted_auth = $request->getParsedBody();
//
//
//
//
//    $arr_cleaned_auth = validation($validator, $arr_tainted_auth);
//
//    $arr_hashed = hash_values($bcrypt_wrapper, $arr_cleaned_auth);
//
//
//    $username = '';

//    if(sizeof($arr_hashed) >2){
//        try {
//            $register_details= $sms_model->check_db_register($db_handle,$sql_queries,$wrapper_mysql, $arr_hashed);
//            $username = $sms_model->getUserName($db_handle,$sql_queries,$wrapper_mysql, $arr_hashed);
//        } catch (Exception $e) {
//            return $response->withRedirect('/FinalYearProject/VLE_Public/');
//        }
//    }
//    else{
//        try {
//            $login_details= $sms_model->check_db_login($db_handle,$sql_queries,$wrapper_mysql, $arr_hashed);
//            $username = $sms_model->getUserName($db_handle,$sql_queries,$wrapper_mysql, $arr_hashed);
//
//        } catch (Exception $e) {
//            return $response->withRedirect('/FinalYearProject/VLE_Public/');
//        }
//
//
//    }


    return $this->view->render($response,
        'reset.html.twig',
        [
            'css_path' => CSS_PATH,
            'landing_page' => LANDING_PAGE,
            'initial_input_box_value' => null,
            'page_title' => APP_NAME,
            //'username' => $username,
            //'method' => 'post',
            //'action' => 'vledashboard',
        ]);
})->setName('passwordreset');