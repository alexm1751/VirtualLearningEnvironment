<?php
/**
 * Created by PhpStorm.
 * User: alexmason
 * Date: 29/03/2018
 * Time: 17:52
 */

namespace App\middleware;

class Middleware{
    protected $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

}