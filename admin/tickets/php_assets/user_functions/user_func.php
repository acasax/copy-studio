<?php

include "../../connection.php";
include "functions.php";
require_once '../class/class.user.php';
$user_class = new USER();
if (isset($_POST["operation"])) {
    $valid_extensions = array('jpeg', 'jpg', 'png', 'gif', 'bmp', 'pdf', 'doc', 'ppt');

    $img = $_FILES['image']['name'];
    $tNumber = $_POST['txt_ticket_number'];
    $name = $_POST['txt_name'];
    $lName = $_POST['txt_last_name'];
    $phone = $_POST['txt_phone'];
    $email = $_POST['txt_email'];
    $institution = $_POST['txt_institution'];
    $id = $_POST['user_id'];

    if (!isset($img)){
        $img = "user-default.jpg";
    }
    if ($_POST["operation"] === "Dodaj") {

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
                                INSERT INTO `customers` ( `picture`, `ticket_number`, `first_name`, `last_name`, `phone`, `e-mail`, `institution`)
                                 VALUES ( :picture, :ticket_number, :first_name, :last_name, :phone, :email, :institutio);
                            ");
                        $result = $stmt->execute(
                            array(
                                ':picture'   => $img,
                                ':ticket_number' => $tNumber,
                                ':first_name' => $name,
                                ':last_name' => $lName,
                                ':phone' => $phone,
                                ':email' => $email,
                                ':institutio' => $institution,
                            )
                        );
                        $user_class->returnJSON("OK", "Uspešno ste dodali korisnika.");
                        return;
                    }
                    else {
                    $user_class->returnJSON("ERROR", "Slika se nije uplodovala.");
                    return;
                    }
                }
                else {
                    $stmt = $db->prepare("
                                INSERT INTO `customers` ( `picture`, `ticket_number`, `first_name`, `last_name`, `phone`, `e-mail`, `institution`)
                                 VALUES ( :picture, :ticket_number, :first_name, :last_name, :phone, :email, :institutio);
                            ");
                    $result = $stmt->execute(
                        array(
                            ':picture'   => $img,
                            ':ticket_number' => $tNumber,
                            ':first_name' => $name,
                            ':last_name' => $lName,
                            ':phone' => $phone,
                            ':email' => $email,
                            ':institutio' => $institution,
                        )
                    );
                    $user_class->returnJSON("OK", "Uspešno ste dodali korisnika.");
                    return;
                }
            }
            else {
            $user_class->returnJSON('ERROR', "Slika sa ovim nazivom već postoji.");
            return;
            }
        }
    }

    if ($_POST["operation"] == "Promeni") {
        if($img != ""){
            $db->exec("set names utf8");
            $get_img_name_sql1 = "SELECT * FROM customers WHERE picture = '$img'";
            $get_img_name1 = $db->prepare($get_img_name_sql1);
            $get_img_name1->execute();
            $row = $get_img_name1->fetch(PDO::FETCH_ASSOC);
            $num_of_img_name = $get_img_name1->rowCount();

            if ($num_of_img_name == 0){
                if(is_array($_FILES)) {
                    if(is_uploaded_file($_FILES['image']['tmp_name'])) {
                        $sourcePath = $_FILES['image']['tmp_name'];
                        $targetPath = "image/".$_FILES['image']['name'];
                        if (move_uploaded_file($sourcePath, $targetPath)) {
                            $update_image_sql = "UPDATE `customers` SET `picture` = '$img', `ticket_number` = '$tNumber', `first_name` = '$name', `last_name` = '$lName', `phone` = '$phone', `e-mail` = '$email', `institution` = '$institution'
                                         WHERE `customers`.`id` = '$id'";
                            $stmt = $db->prepare($update_image_sql);
                            $result = $stmt->execute();
                            $user_class->returnJSON("OK", "Uspešno ste izmenili podatke o korisniku.");
                            return;
                        }else {
                            $user_class->returnJSON("inavalid", "Error.");
                            return;
                        }
                    }
                }

            }
        }
        else{
            $update_image_sql = "UPDATE `customers` SET `ticket_number` = '$tNumber', `first_name` = '$name', `last_name` = '$lName', `phone` = '$phone', `e-mail` = '$email', `institution` = '$institution'
                                         WHERE `customers`.`id` = '$id'";
            $stmt = $db->prepare($update_image_sql);
            $result = $stmt->execute();
            $user_class->returnJSON("OK", "Uspešno ste izmenili podatke o korisniku.");
            return;
        }
    }
}
