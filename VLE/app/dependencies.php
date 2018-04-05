<?php
/**
 * Created by PhpStorm.
 * User: alexmason
 * Date: 18/01/2018
 * Time: 12:40
 */

$container['view'] = function ($container) {
    $view = new \Slim\Views\Twig(
        $container['settings']['view']['template_path'],
        $container['settings']['view']['twig'],
        [
            'cache' => false,
            'debug' => true // This line should enable debug mode
        ]
    );

    // Instantiate and add Slim specific extension
    $basePath = rtrim(str_ireplace('index.php', '', $container['request']->getUri()->getBasePath()), '/');
    $view->addExtension(new Slim\Views\TwigExtension($container['router'], $basePath));
    $view->addExtension(new Knlv\Slim\Views\TwigMessages(
        new Slim\Flash\Messages()
    ));
    // This line should allow the use of {{ dump() }} debugging in Twig
    $view->addExtension(new \Twig_Extension_Debug());

    return $view;
};


$container['flash'] = function ($container){
    return new \Slim\Flash\Messages;
};

$container['MYSQLWrapper'] = function ($container) {
    $class_path = $container->get('settings')['class_path'];
    require $class_path . 'MYSQLWrapper.php';
    $MYSQLWrapper = new MYSQLWrapper();
    return $MYSQLWrapper;
};

$container ['validator'] =  function ($container) {
    $class_path = $container->get('settings')['class_path'];
    require $class_path . 'validator.php';
    $validator = new validator();
    return $validator;
};

$container['user_model'] = function ($container) {
    $class_path = $container->get('settings')['class_path'];
    require $class_path . 'userModel.php';
    $model = new userModel();
    return $model;
};

$container['SQLQueries'] = function ($container) {
    $class_path = $container->get('settings')['class_path'];
    require $class_path . 'SQLQueries.php';
    $SQLQueries = new SQLQueries();
    return $SQLQueries;
};

$container['BcryptWrapper'] = function ($container) {
    $class_path = $container->get('settings')['class_path'];
    require $class_path . 'BcryptWrapper.php';
    $wrapper = new BcryptWrapper();
    return $wrapper;
};

$container['flash'] = function () {
    return new \Slim\Flash\Messages();
};



$container['dbase'] = function ($container) {

    $db_conf = $container['settings']['pdo'];
    $host_name = $db_conf['rdbms'] . ':host=' . $db_conf['host'];
    $port_number = ';port=' . '3306';
    $user_database = ';dbname=' . $db_conf['db_name'];
    $host_details = $host_name . $port_number . $user_database;
    $user_name = $db_conf['user_name'];
    $user_password = $db_conf['user_password'];
    $pdo_attributes = $db_conf['options'];
    $obj_pdo = null;
    try
    {
        $obj_pdo = new PDO($host_details, $user_name, $user_password, $pdo_attributes);
    }
    catch (PDOException $exception_object)
    {
        trigger_error('error connecting to  database');
    }
    return $obj_pdo;
};