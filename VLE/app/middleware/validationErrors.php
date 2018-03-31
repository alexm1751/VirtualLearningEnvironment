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

        if(isset($_SESSION['errors'])){
            $this->container->view->getEnvironment()->addGlobal('errors', $_SESSION['errors']);

            unset($_SESSION['errors']);
        }
        $response = $next($request,$response);
        return $response;
    }
}