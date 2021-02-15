<?php
$db_host="s13.loopia.se";
$db_user="black@c55748";
$db_password="Podlogazamis3344";
$db_name="copystudiokrusevac_com_db_1";

try{
    $db= new PDO("mysql:host={$db_host};dbname={$db_name}",$db_user,$db_password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch (PDOException $e){
    $e->getMessage();
}
