<?php


include "../../connection.php";
include "functions.php";

$query = '';
$output = array();
session_start();
$query .= 'SELECT * FROM `purchase` WHERE purchase.fk_customer_id = ' .  $_SESSION["id"] . ' ';

if (isset($_POST["order"])) {
    $query .= 'ORDER BY ' . $_POST['order']['0']['column'] . ' ' . $_POST['order']['0']['dir'] . ' ';
} else {
    $query .= 'ORDER BY purchase.id DESC ';
}
$stmt = $db->prepare($query);
$stmt->execute();

$result = $stmt->fetchAll();

$data = array();

$filtered_rows = $stmt->rowCount();

foreach ($result as $row) {

    $sub_array = array();
    $sub_array[] = $row["date"];
    $sub_array[] = $row["price"];
    $sub_array[] = $row["description"];
    //$sub_array[] = '<button type="button" name="update" id="' . $row["id"] . '" class="w-100 h-100 update" style="background: none; border: none; margin: auto; text-align: center;" title="Izmena" ><i class="fas fa-user-edit"></i></button>';
    $data[] = $sub_array;
}

$output = array(
    "recordsTotal" => $filtered_rows,
    "recordsFiltered" => get_total_all_records($db),
    "data" => $data
);

echo json_encode($output);