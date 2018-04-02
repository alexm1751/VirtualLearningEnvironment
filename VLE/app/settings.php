<?php
/**
 * Created by PhpStorm.
 * User: alexmason
 * Date: 18/01/2018
 * Time: 12:40
 */

ini_set('display_errors', 'On');
ini_set('html_errors', 'On');



define('DIRSEP', DIRECTORY_SEPARATOR);

$url_root = $_SERVER['SCRIPT_NAME'];
$url_root = implode('/', explode('/', $url_root, -1));
//$css_path = $url_root . '/css/style.css';

$script_filename = $_SERVER["SCRIPT_FILENAME"];
$arr_script_filename = explode('/' , $script_filename, '-1');
$script_path = implode('/', $arr_script_filename) . '/';

//define('CSS_PATH', $css_path);
define('APP_NAME', 'Virtual Learning Environment - Homepage');
define('LANDING_PAGE', $_SERVER['SCRIPT_NAME']);
define('LOGOUT_PAGE', $_SERVER['SCRIPT_NAME'] . '/logout');
define('LOGGED_OUT', $_SERVER['SCRIPT_NAME'] . '/loggedOut');
define('studentDashboard', $_SERVER['SCRIPT_NAME'] . '/studentDashboard');
define('PASS_RESET', $_SERVER['SCRIPT_NAME'] . '/reset');
define('RESET_FORM', $_SERVER['SCRIPT_NAME'] . '/passwordreset');
define('recover_form', $_SERVER['SCRIPT_NAME'] . '/recover');
define ('BCRYPT_ALGO', PASSWORD_DEFAULT);
define ('BCRYPT_COST', 12);
$m_max_length_password = 25;


$settings = [
    "settings" => [
        'displayErrorDetails' => true,
        'addContentLengthHeader' => false,
        'mode' => 'development',
        'debug' => true,
        'class_path' => __DIR__ . '/src/',
        'view' => [
            'template_path' => __DIR__ . '/templates/',
            'twig' => [
                'cache' => __DIR__ . '/cache/twig',
                'auto_reload' => true,
            ]],
        'pdo' => [
            'rdbms' => 'mysql',
            'host' => 'localhost',
            'db_name' => 'vle',
            'port' => '3306',
            'user_name' => 'root',
            'user_password' => 'root',
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'options' => [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => true,
            ],
        ]
    ],
];

return $settings;