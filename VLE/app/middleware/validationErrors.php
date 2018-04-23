<?php
/**
 * Created by PhpStorm.
 * User: alexmason
 * Date: 29/03/2018
 * Time: 17:54
 */


namespace App\middleware;

class validationErrors extends middleware
{
    public function __invoke($request, $response, $next)
    {
//Adds the name of the field then assers error into session array errors.
        if(isset($_SESSION['errors'])){
            $this->container->view->getEnvironment()->addGlobal('errors', $_SESSION['errors']);

            unset($_SESSION['errors']);
        }
        $response = $next($request,$response);
        return $response;
    }
}