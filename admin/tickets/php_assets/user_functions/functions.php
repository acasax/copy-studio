<?php

function get_total_all_records($db)
{
    $stmt = $db->prepare("
        SELECT * FROM `customers`
    ");
    $stmt->execute();
    $result = $stmt->fetchAll();
    return $stmt->rowCount();
}

function get_total_all_purchape_records($db, $id)
{
    $query = "SELECT * FROM `purchase` WHERE purchase.fk_customer_id =   $id  ";
    $stmt = $db->prepare($query);
    $stmt->execute();
    $result = $stmt->fetchAll();
    return $stmt->rowCount();
}
