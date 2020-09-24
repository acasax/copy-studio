<?php

include "../../connection.php";
include "functions.php";
require_once '../class/class.user.php';
$user_class = new USER();
if (isset($_POST["operation"])) {
    $valid_extensions = array('jpeg', 'jpg', 'png', 'gif', 'bmp', 'pdf', 'doc', 'ppt');
    if ($_POST["operation"] === "Dodaj") {

        $title = $_POST['txt_title'];
        $img = $_FILES['image']['name'];
        $text = $_POST['txt_text'];

        //pretvori ga u funkciju
        $db->exec("set names utf8");
        $get_img_name_sql1 = "SELECT * FROM blog WHERE image_name = '$img'";
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
                                INSERT INTO `blog`(`title`, `image_name`, `text`) 
                                VALUES (:title, :name, :text)
                            ");
                        $result = $stmt->execute(
                            array(
                                ':title' => $_POST["txt_title"],
                                ':name' => $img,
                                ':text' => $text
                            )
                        );
                        $user_class->returnJSON("OK", "Successfully insert blog.");
                        return;
                    }
                }
            }
        }
        else {
            $user_class->returnJSON('ERROR', "Image with this name already exist.");
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
