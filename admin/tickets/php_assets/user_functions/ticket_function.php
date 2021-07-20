<?php

include "../../connection.php";
include "functions.php";
require_once '../class/class.user.php';
$user_class = new USER();
if (isset($_POST["operation"])) {

    $amount = $_POST['txt_ticket'];
    $fk_customer_id = $_POST['fk_customer_id'];
    $amount = $amount * 2000;
    $amountQuery = "SELECT used_points FROM `customers` WHERE `customers`.`id` = " . $fk_customer_id . "";

    $stmt = $db->prepare($amountQuery);
    $stmt->execute();
    $result = $stmt->fetch();
   
    $amount = $amount + $result['used_points'];
    $query = "UPDATE `customers` SET `used_points` = " . $amount . " WHERE `customers`.`id` = " . $fk_customer_id . "";
    $stmt = $db->prepare($query);
    $stmt->execute();

    $user_class->returnJSON("OK", "Uspešno ste iskoristili vaučer.");
    return;
}
