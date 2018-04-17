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

        try{

        } catch (Exception $e){
            return view;
        }

    $validator = $this->get('validator');

    $userModel = $this->get('user_model');

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

    }


    // Check user rank and check id else kick back

})->setName('update');