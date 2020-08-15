<?php
   /**
    * Created by PhpStorm.
    * User: comp
    * Date: 3/14/2020
    * Time: 8:01 PM
    */

   session_set_cookie_params(0);
   session_start();
   include '../../db.php';
   require_once('../../Admin.php');
   $user_login = new Admin();



  //$user_login->register('copystudio@gmail.com','123','admin');

   if(isset($_POST['loginemail']) && isset($_POST['loginpassword'])) {

      $username = $_POST['loginemail'];
      $password = $_POST['loginpassword'];

      $query_select = "SELECT * FROM accounts WHERE username = '$username'";
      $check_query = $connection->prepare($query_select);
      $check_query->execute();

      if($check_query->rowCount() > 0) {
         $row = $check_query->fetch();
         $id = $row['account_id'];
         $username = $row['username'];
         $password2 = $row['password'];
         if(password_verify($password, $password2)){
            $secret_key = $user_login->getSecretKey();
            $issuedat_claim = time(); // issued at
            $date = date('Y-m-d HH:ii',$issuedat_claim);
            $notbefore_claim = $issuedat_claim ; //not before in seconds
            $expire_claim = $issuedat_claim + 60*60; // expire time in seconds
            $_SESSION['userSession'] = $id;
            $token = array(
             "iat" => $issuedat_claim,
             "nbf" => $notbefore_claim,
             "exp" => $expire_claim,
             "date" => $date,
             "data" => array(
              "id" => $id,
              "username" => $username
             ));
            http_response_code(200);
            $jwt = $user_login->encodeJWT($token);
            $role = $user_login->get_type_of_account($_SESSION['userSession']);
            $url = '';
            switch($role){
               case 'super_admin': $url = 'super_admin/index.php';break;
               case 'admin': $url = 'admin/index.php';break;
            }
            echo json_encode(
             array(
              "type" => "OK",
              "jwt" => $jwt,
              "url" => $url
             ));
         }else{
            echo json_encode(array("type"=>"ERROR","field"=>"loginpassword","message"=> "loginFaild"));
         }

      }
   }

?>
