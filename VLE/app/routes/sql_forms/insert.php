<?php
/**
 * Created by PhpStorm.
 * User: alexmason
 * Date: 08/04/2018
 * Time: 10:30
 */

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \Respect\Validation\Validator as v;

$app->get('/insert', function(Request $request, Response $response) {

    $id = $request->getParam('id');
    var_dump($id);

})->setName('insert');