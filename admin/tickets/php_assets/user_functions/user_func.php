<?php

include "../../connection.php";
include "functions.php";
require_once '../class/class.user.php';
$user_class = new USER();
if (isset($_POST["operation"])) {
    $valid_extensions = array('jpeg', 'jpg', 'png', 'gif', 'bmp', 'pdf', 'doc', 'ppt');
    if ($_POST["operation"] === "Dodaj") {

        $img = $_FILES['image']['name'];
        $tNumber = $_POST['txt_ticket_number'];
        $name = $_POST['txt_name'];
        $lName = $_POST['txt_last_name'];
        $phone = $_POST['txt_phone'];
        $email = $_POST['txt_email'];
        $institution = $_POST['txt_institution'];


        $db->exec("set names utf8");
        $get_img_name_sql1 = "SELECT * FROM customers WHERE picture = '$img'";
        $get_img_name1 = $db->prepare($get_img_name_sql1);
        $get_img_name1->execute();
        $row = $get_img_name1->fetch(PDO::FETCH_ASSOC);
        $num_of_img_name = $get_img_name1->rowCount();


        if ($num_of_img_name == 0) {
            if(is_array($_FILES)) {
                if(is_uploaded_file($_FILES['image']['tmp_name'])) {
                    $sourcePath = $_FILES['image']['tmp_name'];
                    $targetPath = "image/".$_FILES['image']['name'];
                    if (move_uploaded_file($sourcePath, $targetPath)) {
                        $stmt = $db->prepare("
                                INSERT INTO `customers` ( `picture`, `ticket_number`, `name`, `last_name`, `phone`, `e-mail`, `institution`)
                                 VALUES ( :picture, :tNumber, :name, :lName, :phone, :email, :institutio);
                            ");
                        $result = $stmt->execute(
                            array(
                                ':tNumber' => $tNumber,
                                ':name' => $name,
                                ':lName' => $lName,
                                ':phone' => $phone,
                                ':email' => $email,
                                ':institutio' => $institution,
                                ':picture'   => $img
                            )
                        );
                        $user_class->returnJSON("OK", "Uspešno ste dodali korisnika.");
                        return;
                    }
                }
            }
        }
        else {
            $user_class->returnJSON('ERROR', "Slika sa ovim nazivom već postoji.");
            return;
        }
    }


    if ($_POST["operation"] === "Promeni") {

        $id    = $_POST['id'];
        $title = $_POST['txt_title'];
        $img   = $_FILES['image']['name'];
        $text  = $_POST['txt_text'];

        if(is_array($_FILES)) {
            if(is_uploaded_file($_FILES['image']['tmp_name'])) {
                $sourcePath = $_FILES['image']['tmp_name'];
                $targetPath = "image/".$_FILES['image']['name'];
                if (move_uploaded_file($sourcePath, $targetPath)) {
                    $update_image_sql = "UPDATE `blog` SET `title` = '$title', `image_name` = '$img', `text` = '$text'  WHERE `blog`.`id` = $id;";
                    $stmt = $db->prepare($update_image_sql);
                    $result = $stmt->execute();
                    $user_class->returnJSON("OK", "Successfully change blog.");
                    return;
                }
            }
        }
        else {
            $user_class->returnJSON("inavalid", "Error.");
            return;
        }
    }
}
