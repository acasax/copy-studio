<?php

include "../../connection.php";
include "functions.php";

if (isset($_POST["blog_id"])) {
    $output = array();
    $stmt = $db->prepare("
        SELECT * FROM blog
        WHERE id = '" . $_POST["blog_id"] . "'"
    );
    $stmt->execute();
    $result = $stmt->fetch();
    $output["title"] = $result["title"];
    $output["text"] = $result["text"];
    $output["image_name"] = $result["image_name"];

    echo json_encode($output);
}

