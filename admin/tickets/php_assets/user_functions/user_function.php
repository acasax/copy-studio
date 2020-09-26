<?php

include "../../connection.php";
include "functions.php";

$query = '';
$output = array();
$query .= "SELECT * FROM `customers`";

if (isset($_POST["search"]["value"])) {
    $query .= ' WHERE customers.ticket_number LIKE "%' . $_POST["search"]["value"] . '%" ';
    $query .= 'OR customers.first_name LIKE "%' .$_POST["search"]["value"].'%" ';
    $query .= 'OR customers.last_name LIKE "%' .$_POST["search"]["value"].'%" ';
    $query .= 'OR customers.phone LIKE "%' .$_POST["search"]["value"].'%" ';
    $query .= 'OR customers.`e-mail` LIKE "%' .$_POST["search"]["value"].'%" ';
    $query .= 'OR customers.institution LIKE "%' .$_POST["search"]["value"].'%" ';
}

if (isset($_POST["order"])) {
    $query .= 'ORDER BY ' . $_POST['order']['0']['column'] . ' ' . $_POST['order']['0']['dir'] . ' ';
} else {
    $query .= 'ORDER BY customers.id DESC ';
}

$stmt = $db->prepare($query);
$stmt->execute();

$result = $stmt->fetchAll();

$data = array();

$filtered_rows = $stmt->rowCount();

foreach ($result as $row) {

    $sub_array = array();
    $img = "php_assets/user_functions/image/" . $row["picture"];
    $sub_array[] = $row["ticket_number"];
    $sub_array[] = '<img src="' . $img . '" class="custom_img">';
    $sub_array[] = $row["first_name"];
    $sub_array[] = $row["last_name"];
    $sub_array[] = $row["phone"];
    $sub_array[] = $row["e-mail"];
    $sub_array[] = $row["institution"];
    $sub_array[] = '<button type="button" name="update" id="' . $row["id"] . '" class="w-100 h-100 update" style="background: none; border: none; margin: auto; text-align: center;" title="Izmena" ><i class="fas fa-user-edit"></i></button>';
    $sub_array[] = '<button type="button" name="delete" id="' . $row["id"] . '" class="w-100 h-100 delete" style="background: none; border: none; margin: auto; text-align: center;" title="Brisanje" ><i class="fas fa-trash"></i></button>';

    $data[] = $sub_array;
}

$output = array(
    "recordsTotal" => $filtered_rows,
    "recordsFiltered" => get_total_all_records($db),
    "data" => $data
);

echo json_encode($output);