<?php
/**
 * Created by PhpStorm.
 * User: alexmason
 * Date: 02/04/2018
 * Time: 13:51
 */
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
$app->get('/adminDashboard', function(Request $request, Response $response) {
    $validator = $this->get('validator');

    $userModel = $this->get('user_model');
    $adminModel = $this->get('admin_model');

    $db_handle = $this->get('dbase');

    $SQLQueries = $this->get('SQLQueries');

    $wrapper_mysql = $this->get('MYSQLWrapper');
    if((!$_SESSION['logged_in'])){
        $this->flash->addMessage('danger',"Invalid Request! No Access!");
        echo time();
        return $response
            ->withHeader("Cache-Control"," no-store, no-cache, must-revalidate, max-age=0")
            ->withHeader("Cache-Control"," post-check=0, pre-check=0, false")
            ->withHeader("Pragma","no-cache")
            ->withHeader('Expires','Sun, 02 Jan 1990 00:00:00 GMT')
            ->withHeader('Expires','0')
            ->withRedirect(LANDING_PAGE);
        exit;

    }

    //if Rank 4 super admin, delete or add new admins!! :D

    $name =$userModel->getUserName($db_handle, $SQLQueries, $wrapper_mysql, $_SESSION['user']);


























    if ($_SESSION['logged_in'] == true){

        switch ($_SESSION['rank']){

            case "3":
                return $this->view->render($response,
                    'admin.html.twig',
                    [
                        'page_title' => APP_NAME,
                        'page_heading_1' => APP_NAME,
                        'page_heading_2' => 'Virtual Learning Environment',
                        'logout_page' => LOGOUT_PAGE,
                        'name' => $name

                    ]);

                break;

            case "4":
                return $this->view->render($response,
                    'superAdmin.html.twig',
                    [
                        'page_title' => APP_NAME,
                        'page_heading_1' => APP_NAME,
                        'page_heading_2' => 'Virtual Learning Environment',
                        'logout_page' => LOGOUT_PAGE,
                        'name' => $name

                    ]);
                break;
            default:
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
        $this->flash->addMessage('info',"Oops! We aren't sure whats happened. Please try to login again.");

        return $response
            ->withHeader("Cache-Control", " no-store, no-cache, must-revalidate, max-age=0")
            ->withHeader("Cache-Control:", " post-check=0, pre-check=0, false")
            ->withHeader("Pragma:", "no-cache")
            ->withHeader('Expires', 'Sun, 02 Jan 1990 00:00:00 GMT')
            ->withRedirect(LANDING_PAGE);
        exit;

    }


})->setName('adminDashboard');