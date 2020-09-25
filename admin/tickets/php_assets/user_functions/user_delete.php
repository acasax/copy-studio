<?php

include "../../connection.php";
include "functions.php";
require_once '../class/class.user.php';
$user_class = new USER();
if (isset($_POST["user_id"])) {
    $stmt = $db->prepare(
        "DELETE FROM customers WHERE id = :id"
    );
    $result = $stmt->execute(
        array(
            ':id' => $_POST["user_id"]
        )
    );

    if (!empty($result)) {
        $user_class->returnJSON("OK", 'Uspešno ste obrisali.');
        return;
    }
}
