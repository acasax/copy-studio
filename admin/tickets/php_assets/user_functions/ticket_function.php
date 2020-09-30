<?php

include "../../connection.php";
include "functions.php";
require_once '../class/class.user.php';
$user_class = new USER();
if (isset($_POST["operation"])) {

    $amount = $_POST['txt_ticket'];
    $fk_customer_id = $_POST['fk_customer_id'];
    $amount = $amount * 2000;


    $stmt = $db->prepare("
                                UPDATE `customers` SET `used_points` = :points WHERE `customers`.`id` = '" . $fk_customer_id . "'");
    $result = $stmt->execute(
        array(
            ':points' => $amount,
        )
    );
    $user_class->returnJSON("OK", "Uspešno ste iskoristili vaučer.");
    return;
}
