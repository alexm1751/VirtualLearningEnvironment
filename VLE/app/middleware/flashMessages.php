<?php
/**
 * Created by PhpStorm.
 * User: alexmason
 * Date: 04/04/2018
 * Time: 23:08
 */

namespace App\middleware;


class flashMessages extends middleware
{
    public function __invoke($request, $response, $next)
    {

        $this->container->view->getEnvironment()->addGlobal("flash", $this->container->flash);
        $response = $next($request, $response);

        return $response;

    }
}