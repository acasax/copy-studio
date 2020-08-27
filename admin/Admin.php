<?php
require_once 'dbconfig.php';
require SITE_ROOT."/component/vendor/autoload.php";
require_once SITE_ROOT . '/mailer/PHPMailer-master/class.phpmailer.php';
include SITE_ROOT . '/mailer/PHPMailer-master/class.smtp.php';
use  \Firebase\JWT\JWT;
Firebase\JWT\JWT::$leeway = 5;

class Admin
{
    private $conn;
    private $role;

    public function __construct()
    {
        $database = new Database();
        $db = $database->dbConnection();
        $this->conn = $db;
    }

    public function getSecretKey(){
        return "ASIFCVJKIO1U89TGU123#$2#$!$!$!HB9QBJHIE8V1338907G0889BH8UH93TU27Y019UT80YHIQ2J311";
    }

    public function CloseCon()
    {
        $this->conn = null;
    }

    function send_mail($email, $message, $subject,$data=null){


        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
        $mail->CharSet = 'UTF-8';
        //$mail->SMTPDebug  = 2;
        /*  $mail->SMTPSecure = "tls";  // ovo je za domen
         $mail->Host = "smtp.gmail.com";
         $mail->Port = 587;*/
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = "ssl";
        $mail->Host = "smtp.gmail.com";
        $mail->Port = 465;
        $mail->AddAddress($email); //email unesi tvoj email
        $mail->Username = "resivojee@gmail.com"; //email
        $mail->Password = "podlogazamis"; //password
        $mail->SetFrom('acasax@gmail.com', "Copy Studio 88 Kruševac");
        $mail->AddReplyTo('acasax@gmail.com', "Copy Studio 88 Kruševac");
        $mail->Subject = $subject;
        $mail->MsgHTML($message);
        if(!is_null($data)) {
            $mail->addEmbeddedImage($data['path'],'sale',$data['file_name']);
        }

        if(!$mail->Send()){
            throw new Exception("Nije moguce poslati email. Pokusajte ponovo.");
            return false;
        }else{
            return true;
        }
    }


    public function register($username, $upass, $role)
    {

        try {
            $options = [
                'cost' => 12,
            ];
            $password = password_hash($upass, PASSWORD_BCRYPT);
            $stmt = $this->conn->prepare("INSERT INTO accounts(username,password,role)VALUES(:username, :user_pass,:role)");
            $stmt->bindparam(":username", $username);
            $stmt->bindparam(":user_pass", $password);
            $stmt->bindparam(":role", $role);
            $stmt->execute();
            return $stmt;
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }

    public function login($id)
    {
        try
        {
            $_SESSION['userSession'] = $id;
            return true;

        }
        catch(PDOException $ex)
        {
            echo $ex->getMessage();
        }
    }

    public function is_logged_in()
    {
        if (isset($_SESSION['userSession'])) {
            return true;
        }
    }

    public function returnJSON($type, $data)
    {
        $array = [];
        $array['type'] = $type;


        $array['data'] = $data;
        echo json_encode($array);
    }

    public function redirect($url)
    {
        header("Location: $url");
    }

    public function refresh()
    {
        header("Refresh:0");
    }

    public function logout()
    {
        session_destroy();
        $_SESSION['userSession'] = false;
    }

    public function encodeJWT ($token) {
       return JWT::encode($token,$this->getSecretKey());
    }

    public function get_type_of_account($accId)
    {

        try {
            $role = $this->conn->query("SELECT role FROM accounts WHERE account_id ='$accId'");
            $lvl = $role->fetch();
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
        return $lvl['role'];
    }

    public function check_jwt ($jwt) {
        $data= array();
        try {
            $jwtData = (array)JWT::decode($jwt, $this->getSecretKey(), array('HS256'));
        } catch (Firebase\JWT\ExpiredException $e) {
            $msg = $e->getMessage();
            if ($msg === "Expired token") {
                $data['type'] = "ERROR";
                $data['expired'] = true;
                return $data;
            }
        }
        if(!empty($data) && $data['expired'] == true) {
            return $data;
        }
        $userData = (array) $jwtData['data'];
        $account_id = $userData['id'];
        $stmt = $this->conn->prepare("SELECT * FROM accounts WHERE id='$account_id'");
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if($stmt->rowCount() <= 0){
            $data['type'] = "ERROR";
            $data['notValid'] = true;
            return $data;
        }
        return true;
    }

}
