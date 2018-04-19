<?php
/**
 * Created by PhpStorm.
 * User: alexmason
 * Date: 18/01/2018
 * Time: 12:40
 */

ini_set('display_errors', 'on');
ini_set('html_errors', 'On');



define('DIRSEP', DIRECTORY_SEPARATOR);

$url_root = $_SERVER['SCRIPT_NAME'];
$url_root = implode('/', explode('/', $url_root, -1));
//$css_path = $url_root . '/css/style.css';

$upload_directory = __DIR__ . '/assets/PDF';
$mysql_directory = ' /FinalYearProject/VLE/app/assets/PDF';

$script_filename = $_SERVER["SCRIPT_FILENAME"];
$arr_script_filename = explode('/' , $script_filename, '-1');
$script_path = implode('/', $arr_script_filename) . '/';

define('m_directory', $mysql_directory);
define('directory', $upload_directory);
/*define('CSS_PATH', $css_path);*/
define('APP_NAME', 'Virtual Learning Environment - Homepage');
define('LANDING_PAGE', $_SERVER['SCRIPT_NAME']);
define('LOGOUT_PAGE', $_SERVER['SCRIPT_NAME'] . '/logout');
define('LOGGED_OUT', $_SERVER['SCRIPT_NAME'] . '/loggedOut');
define('studentDashboard', $_SERVER['SCRIPT_NAME'] . '/studentDashboard');
define('teacherDashboard', $_SERVER['SCRIPT_NAME'] . '/teacherDashboard');
define('adminDashboard', $_SERVER['SCRIPT_NAME'] . '/adminDashboard');
define('PASS_RESET', $_SERVER['SCRIPT_NAME'] . '/reset');
define('RESET_FORM', $_SERVER['SCRIPT_NAME'] . '/passwordreset');
define('recover_form', $_SERVER['SCRIPT_NAME'] . '/recover');
define('RECOVERED', $_SERVER['SCRIPT_NAME'] . '/recovered');
define('module_page', $_SERVER['SCRIPT_NAME'] . '/modules');
define('contact', $_SERVER['SCRIPT_NAME'] . '/contact');
define('profile', $_SERVER['SCRIPT_NAME'] . '/profile');
define('attendance', $_SERVER['SCRIPT_NAME'] . '/attendanceDashboard');
define('update', $_SERVER['SCRIPT_NAME']. '/update');
define('timetable', $_SERVER['SCRIPT_NAME'] . '/timetable');
define('feedback', $_SERVER['SCRIPT_NAME']. '/feedback');
define('staffinfo', $_SERVER['SCRIPT_NAME']. '/staffinfo');
define('learning', $_SERVER['SCRIPT_NAME']. '/learningResources');
define('assessment', $_SERVER['SCRIPT_NAME']. '/assessment');
define('setAttendance', $_SERVER['SCRIPT_NAME']. '/setAttendance');
define('course_announcement', $_SERVER['SCRIPT_NAME']. '/courseAnnouncements');
define('module_content', $_SERVER['SCRIPT_NAME']. '/moduleContent');
define('module_announcement', $_SERVER['SCRIPT_NAME']. '/moduleAnnouncements');
define('setTheory', $_SERVER['SCRIPT_NAME'] . '/setTheory');
define('setPractical', $_SERVER['SCRIPT_NAME'] . '/setPractical');
define('setCoursework', $_SERVER['SCRIPT_NAME'] . '/setCoursework');
define('assignments', $_SERVER['SCRIPT_NAME'] . '/assignments');
define('course_edit', $_SERVER['SCRIPT_NAME']. '/courseEdit');
define('module_edit', $_SERVER['SCRIPT_NAME']. '/moduleEdit');
define('user_edit', $_SERVER['SCRIPT_NAME']. '/userEdit');
define('class_schedule', $_SERVER['SCRIPT_NAME']. '/classSchedule');
define('timetables', $_SERVER['SCRIPT_NAME']. '/timetables');
define('admin_edit', $_SERVER['SCRIPT_NAME']. '/adminEdit');
define('insert', $_SERVER['SCRIPT_NAME']. '/insert');
define('delete', $_SERVER['SCRIPT_NAME']. '/delete');
define('attendance_form', $_SERVER['SCRIPT_NAME']. '/classAttendance');
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