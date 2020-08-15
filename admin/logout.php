<?php
session_set_cookie_params(0);
session_start();
include('./db.php');
require_once './Admin.php';
$user = new Admin();

if(!$user->is_logged_in())
{
	$user->redirect('../prijava');
}

if($user->is_logged_in()!="")
{
	$user->logout();
	$user->redirect('../prijava');
}
exit();
?>

