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

$app->map(['GET', 'POST'], '/loginhome', function(Request $request, Response $response) use ($app) {

    echo ('Logged In');
    $c_arr_clean_message = [];

    var_dump($request->getParams());

    $validator = $this->get('validator');

    $db_handle = $this->get('dbase');

    $SQLQueries = $this->get('SQLQueries');

    $wrapper_mysql = $this->get('MYSQLWrapper');

    $bcrypt_wrapper = $this->get('BcryptWrapper');

    $validator->validate($request,[
        'email' => v::email()->noWhitespace()->notEmpty(),
        'password' => v::noWhitespace()->notEmpty()
    ]);

    if ($validator->failed()){
        return $response->withRedirect('/FinalYearProject/VLE_Public/');
    }
   // $arr_tainted_auth = $request->getParsedBody();


   // $arr_cleaned_auth = validation($validator, $arr_tainted_auth);

    //$arr_hashed = hash_values($bcrypt_wrapper, $arr_cleaned_auth);


    $username = '';
//
//        try {
//            $login_details= $sms_model->check_db_login($db_handle,$sql_queries,$wrapper_mysql, $arr_hashed);
//            $username = $sms_model->getUserName($db_handle,$sql_queries,$wrapper_mysql, $arr_hashed);
//
//        } catch (Exception $e) {
//            return $response->withRedirect('/FinalYearProject/VLE_Public/');
//        }





    return $this->view->render($response,
        'loggedin.html.twig',
        [
            'css_path' => CSS_PATH,
            'landing_page' => LANDING_PAGE,
            'initial_input_box_value' => null,
            'page_title' => APP_NAME,
            //'username' => $username,
            //'method' => 'post',
            //'action' => 'vledashboard',
        ]);
})->setName('loginhome');
