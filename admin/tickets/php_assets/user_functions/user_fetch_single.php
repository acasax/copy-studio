<?php

include "../../connection.php";
include "functions.php";
if (isset($_POST["user_id"])) {
    $output = array();
    $stmt = $db->prepare("
        SELECT * FROM customers
        WHERE id = '" . $_POST["user_id"] . "'"
    );
    $stmt->execute();
    $result = $stmt->fetch();
    $output["picture"] = $result['picture'];
    $output["tNumber"] = $result['ticket_number'];
    $output["name"] = $result['first_name'];
    $output["lName"] = $result['last_name'];
    $output["phone"]= $result['phone'];
    $output["email"] = $result['e-mail'];
    $output["institution"] = $result['institution'];

    echo json_encode($output);
}

