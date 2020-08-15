<?php

include './db.php';
require_once('./Admin.php');
require_once './VerifyEmail.class.php';
$admin = new Admin();
/*$mail = new VerifyEmail();
$mail->Debug = false;
$mail->setStreamTimeoutWait(25);
$mail->setEmailFrom('stefan.milutinovic.rs@gmail.com');
*/


if(isset($_POST['EMAIL']) && isset($_POST['AGREE_TO_TERMS'])) {
    try{
        $email = $_POST['EMAIL'];
        if($_POST['AGREE_TO_TERMS'] === '0'){
            throw new Exception('Morate prihvati uslove koriscenja.');
        }
        $html = file_get_contents('./email/email.html');
        $html = str_replace('$email',$email,$html);
        $sql_get = "SELECT * FROM  newsletter  WHERE email = '$email' AND status = 'A'";
        $query_get = $connection->prepare($sql_get);
        $query_get->execute();
        if($query_get->rowCount() >0) {
            throw new Exception('Vec ste se prijavili. Hvala.');
        }
        if($admin->send_mail($email,$html,"Copy Studio Kruševac | Newsletter")) {
            $sql_insert = "INSERT INTO newsletter (email,status)VALUES('$email','A')";
            $query_insert = $connection->prepare($sql_insert);
            $query_insert->execute();
            $admin->returnJSON("OK", "Uspešno ste se prijavili.");
            return;
       }
    }catch (Exception $e){
        $msg = $e->getMessage();
        $admin->returnJSON("ERROR", $msg);
        return;
    }
}
/*    if($mail->check($email)){
        $html = file_get_contents('./email/email.html');
        $html = str_replace('$email',$email,$html);
        echo $html;
        return;
    }elseif(verifyEmail::validate($email)){
        echo 'MAIL VALID, BUT NOT EXIST.';
        return;
    }*/


