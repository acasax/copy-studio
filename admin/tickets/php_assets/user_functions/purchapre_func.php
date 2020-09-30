<?php

include "../../connection.php";
include "functions.php";
require_once '../class/class.user.php';
$user_class = new USER();
if (isset($_POST["operation"])) {

    $amount = $_POST['txt_amount'];
    $description = $_POST['txt_description'];
    $fk_customer_id = $_POST['fk_customer_id'];
    $id = $_POST['purchase_id'];

    $stmt = $db->prepare("
        SELECT `customers`.`sum_points` FROM customers
        WHERE id = '" . $fk_customer_id . "'"
    );
    $stmt->execute();
    $result = $stmt->fetch();
    $sum_points = $result['sum_points'];
    $sum_points = $sum_points + $amount;
        $stmt = $db->prepare("
                                INSERT INTO `purchase` ( `fk_customer_id`, `price`, `description`)
                                 VALUES ( :fk_customer_id, :price, :description);
                            ");
        $result = $stmt->execute(
            array(
                ':fk_customer_id'   => $fk_customer_id,
                ':price' => $amount,
                ':description' => $description
            )
        );
    $stmt = $db->prepare("
                                UPDATE `customers` SET `sum_points` = :points WHERE `customers`.`id` = '" . $fk_customer_id . "'");
    $result = $stmt->execute(
        array(
            ':points' => $sum_points,
        )
    );
    $user_class->returnJSON("OK", "Uspešno ste dodali novu kupovinu.");
    return;
}
