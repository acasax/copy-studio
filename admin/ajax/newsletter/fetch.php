<?php
session_set_cookie_params(0);
session_start();
include('../../db.php');
$query = '';
$output = array();
$current_year = date("Y");
$query_1 = "";
$stateNewsletter = $_POST['stateNewsletter'];
$query .= "SELECT * FROM newsletter WHERE status = '$stateNewsletter' ";
if(isset($_POST["search"]["value"]) && $_POST["search"]["value"] !== '') {
    $query .= ' AND email LIKE "%'.$_POST["search"]["value"].'%" ';
}

if ($_POST["length"] != -1) {
    $query .= ' LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
}
$connection->exec("set names utf8");
$statement = $connection->prepare($query);
$statement->execute();
$result = $statement->fetchAll();
$data = array();
$filtered_rows = $statement->rowCount();

$query_1 .= "SELECT * FROM newsletter WHERE status = '$stateNewsletter'  ";

$connection->exec("set names utf8");
$statement1 = $connection->prepare($query_1);
$statement1->execute();
$result1 = $statement1->fetchAll();
$fetchAll = $statement1->rowCount();

$i = 1;
foreach ($result as $row) {
    $sub_array = array();
    $sub_array[] = $row["email"];
    $sub_array[] = $row["status"];
    $data[] = $sub_array;
    $i++;
}
$output = array(
    "draw" => intval($_POST["draw"]),
    "recordsTotal" => $filtered_rows,
    "recordsFiltered" => $fetchAll,
    "data" => $data
);
echo json_encode($output);
?>
