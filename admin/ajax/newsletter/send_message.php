<?php

session_set_cookie_params(0);
session_start();
include('../../db.php');
require_once '../../Admin.php';
$admin = new Admin();
if(isset($_FILES['image']) && isset($_POST['mail_message'])){
    try {
        $message = $_POST['mail_message'];
        $image = $_FILES['image']['name'];
        $source_file = $_FILES['image']['tmp_name'];
        $html = file_get_contents('../../email/subscriber/sendMessage.html');
        $html = str_replace('$message', $message, $html);
        move_uploaded_file($source_file, '../../email/subscriber/tmp_images/'.$image) or die ("Error!!");
        $dest_file = "../../email/subscriber/tmp_images/".$_FILES['image']['name'];
        if (!file_exists($dest_file)) {
            throw new Exception("Došlo je do greške.Pokušajte ponovo.");
        }

        /**
         *  uzeti sve activne mailove iz newletters i proslediti im ove poruke
         * proveri da ne pukne request zbog kolicine mail-ova
         *
         * @var  $email
         */
      $email = 'stefan.milutinovic.rs@gmail.com';
      $data = [];
      $data['path'] = $dest_file;
      $data['file_name'] = $image;
      if ($admin->send_mail($email, $html, "Copy Studio Kruševac | Newsletter",$data)) {
            unlink($dest_file);
            $admin->returnJSON("OK", "Uspešno ste se poslali poruke.");
            return;
      }
    }catch (Exception $e){
        $msg = $e->getMessage();
        $admin->returnJSON("ERROR", $msg);
        return;
    }
}
