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
use Slim\Http\UploadedFile;

$app->map(['GET', 'POST'], '/insert', function(Request $request, Response $response) use ($app){

    if (!$id = $request->getParam('id')){
        $_SESSION = array();
        $this->flash->addMessage('info',"Oops! We aren't sure whats happened. Would you mind logging again?.");
        return $response
            ->withHeader("Cache-Control", " no-store, no-cache, must-revalidate, max-age=0")
            ->withHeader("Cache-Control:", " post-check=0, pre-check=0, false")
            ->withHeader("Pragma:", "no-cache")
            ->withHeader('Expires', 'Sun, 02 Jan 1990 00:00:00 GMT')
            ->withRedirect(LANDING_PAGE);
        exit;
    }

    $id = $request->getParam('id');

    $validator = $this->get('validator');

    $studentModel = $this->get('student_model');

    $db_handle = $this->get('dbase');

    $SQLQueries = $this->get('SQLQueries');

    $wrapper_mysql = $this->get('MYSQLWrapper');




    switch ($id){
        case "2":
            if($_SESSION['rank'] != 1){
                $_SESSION = array();
                $this->flash->addMessage('info',"Oops! We aren't sure whats happened. Would you mind logging again?.");
                return $response
                    ->withHeader("Cache-Control", " no-store, no-cache, must-revalidate, max-age=0")
                    ->withHeader("Cache-Control:", " post-check=0, pre-check=0, false")
                    ->withHeader("Pragma:", "no-cache")
                    ->withHeader('Expires', 'Sun, 02 Jan 1990 00:00:00 GMT')
                    ->withRedirect(LANDING_PAGE);
                exit;
            }
            try{
                $user_id = $request->getParam('user');
                $cw_id = $request->getParam('cwID');
                $exists = $studentModel->check_submission($db_handle,$SQLQueries,$wrapper_mysql, $user_id,$cw_id);

            }catch (Exception $e){
                $this->flash->addMessage('info',"Oops! We aren't sure whats happened. Please Check Your Coursework");
                return $response->withRedirect(assessment);
            }

            if($exists == false){
                $this->flash->addMessage('info',"You have already submitted this assignment. Contact your lecturer to change this.");
                return $response->withRedirect(assessment);
            }
            else{
            try {
                $directory = directory;
                $m_directory = m_directory;
                $uploadedFiles = $request->getUploadedFiles();
                if (!empty($uploadedFile = $uploadedFiles['file'])) {
                    $fileSize = $uploadedFile->getSize();
                    $fileName = $uploadedFile->getClientFilename();


                    $fileExt = explode('.', $fileName);
                    $fileActualExt = strtolower(end($fileExt));

                    $allowed = array('pdf');

                    if (in_array($fileActualExt, $allowed)) {
                        if ($fileSize < 500000) {

                            if ($uploadedFile->getError() === UPLOAD_ERR_OK) {
                                $filename = moveUploadedFile($directory, $uploadedFile);
                                try{
                                    $filename = ($m_directory . DIRSEP . $filename);
                                    $studentModel->submitAssessments($db_handle,$SQLQueries,$wrapper_mysql,$user_id,$cw_id,$filename);
                                    $this->flash->addMessage('success', "You Successfully Submitted Your Assignment!");
                                    session_regenerate_id();
                                    return $response->withRedirect(assessment);
                                }catch (Exception $e){
                                    $this->flash->addMessage('danger', "There was an Error Uploading the File!");
                                    return $response->withRedirect(assessment);
                                }


                            } else {
                                $this->flash->addMessage('danger', "There was an Error Uploading the File!");
                                return $response->withRedirect(assessment);
                            }
                        } else {

                            $this->flash->addMessage('danger', "Invalid File Size!");
                            return $response->withRedirect(assessment);
                        }
                    } else {

                        $this->flash->addMessage('danger', "Invalid File Type Uploaded!");
                        return $response->withRedirect(assessment);

                    }

                } else {
                    $this->flash->addMessage('danger', "Empty File Detected");
                    return $response->withRedirect(assessment);
                }
                // handle single input with single file upload
            } catch (Exception $e) {
                var_dump($e);

            }

        }
        break;
    }


    // Check user rank and check id else kick back



})->setName('insert');

function moveUploadedFile($directory, $uploadedFile)
{
    $extension = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);
    $basename = bin2hex(random_bytes(8)); // see http://php.net/manual/en/function.random-bytes.php
    $filename = sprintf('%s.%0.8s', $basename, $extension);

    $uploadedFile->moveTo($directory . DIRECTORY_SEPARATOR . $filename);

    return $filename;
}