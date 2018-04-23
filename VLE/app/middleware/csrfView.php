<?php
/**
 * Created by PhpStorm.
 * User: alexmason
 * Date: 31/03/2018
 * Time: 02:25
 */

namespace App\middleware;


class csrfView extends middleware
{
    public function __invoke($request, $response, $next)
    {
//Producing Special Token name and values to make sure form is csrf guarded. Caught in the $next request preventing the server from displaying response of html
        $this->container->view->getEnvironment()->addGlobal('csrf', [
            'field' => '
            <input type="hidden" name="' . $this->container->csrf->getTokenNameKey(). '" value="' . $this->container->csrf->getTokenName() .'">
            
            <input type="hidden" name="' . $this->container->csrf->getTokenValueKey(). '" value="' . $this->container->csrf->getTokenValue() .'">
            ',
    ]);
        $response = $next($request, $response);

        return $response;
    }
}