<?php
/**
 * Created by PhpStorm.
 * User: alexmason
 * Date: 02/04/2018
 * Time: 18:53
 */

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Respect\Validation\Validator as v;



$app->post( '/reset', function(Request $request, Response $response)  {


    $validator = $this->get('validator');
    $db_handle = $this->get('dbase');
    $SQLQueries = $this->get('SQLQueries');
    $wrapper_mysql = $this->get('MYSQLWrapper');
    $userModel = $this->get('user_model');
    $bcryptwrapper = $this->get('BcryptWrapper');


    $validator->validate($request,[
        'email' => v::email()->noWhitespace()->notEmpty()
    ]);

    if ($validator->failed()){
        return $response->withRedirect(RESET_FORM);
    }
    $email = $request->getParam('email');
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);


    $check = $userModel->check_db_user($db_handle,$SQLQueries,$wrapper_mysql, $email);
//check that the user exists before carrying on with any other process. Output none specific error
    if($check !== true){
        $this->flash->addMessage('info',"There was an error processing your request, please verify details or contact an Admin.");
        return $response
            ->withHeader("Cache-Control", " no-store, no-cache, must-revalidate, max-age=0")
            ->withHeader("Cache-Control:", " post-check=0, pre-check=0, false")
            ->withHeader("Pragma:", "no-cache")
            ->withHeader('Expires', 'Sun, 02 Jan 1990 00:00:00 GMT')
            ->withRedirect(LANDING_PAGE);
        exit;
    }
    //Generate Random hash value to be stored in the system.
    $string_to_hash = bin2hex(random_bytes(20));


    //Adds recovery hash to user in the database
    $userModel->update_Recover_Hash($db_handle,$SQLQueries,$wrapper_mysql,$bcryptwrapper, $email, $string_to_hash);





    $mail = new PHPMailer(true);

    $mail->setFrom('admin@VLE-Education.com', 'VLE.com');
    $mail->addAddress('alex_mason1@hotmail.co.uk');
    $mail->addReplyTo('no-reply@VLE.com', 'VLE.com');

    $mail->isHTML(true);    // Set email format to HTML
    $url = recover_form;

    $mail->Subject = 'Instructions for resetting the password for your VLE Account';
    $mail->Body    = "
        <p>Hi,</p>
        <p>            
        We have received a request for a password reset on the account associated with this email address.
        </p>
        <p>
        To confirm and reset your password, please click <a href=\"http://localhost$url?email=$email&identifier=$string_to_hash\">here</a>.  If you did not initiate this request,
        please disregard this message.
        </p>
        <p>
        If you have any questions about this email, you may contact us at support@VLE.com.
        </p>
        <p>
        With regards,
        <br>
        The VLE Team
        </p>";
    if(!$mail->send()) {
        $this->flash->addMessage('info',"We're having trouble with our mail servers at the moment.  Please try again later, or contact us directly by phone.");
        return $response
            ->withHeader("Cache-Control", " no-store, no-cache, must-revalidate, max-age=0")
            ->withHeader("Cache-Control:", " post-check=0, pre-check=0, false")
            ->withHeader("Pragma:", "no-cache")
            ->withHeader('Expires', 'Sun, 02 Jan 1990 00:00:00 GMT')
            ->withRedirect(LANDING_PAGE);
        exit;
    }else{
        $this->flash->addMessage('success',"A Recovery Email has been sent!");
        return $response
            ->withHeader("Cache-Control", " no-store, no-cache, must-revalidate, max-age=0")
            ->withHeader("Cache-Control:", " post-check=0, pre-check=0, false")
            ->withHeader("Pragma:", "no-cache")
            ->withHeader('Expires', 'Sun, 02 Jan 1990 00:00:00 GMT')
            ->withRedirect(LANDING_PAGE);
        exit;
    }




})->setName('reset');