<?php
class Database
{

    private $host = "s13.loopia.se";
    private $db_name = "copystudiokrusevac_com_db_1";
    private $username = "black@c55748";
    private $password = "Podlogazamis3344";
    public $conn;

    // private $host = "localhost";
    // private $db_name = "copystudiokrusevac_com_db_1";
    // private $username = "root";
    // private $password = "";
    // public $conn;

    public function dbConnection()
	{

	    $this->conn = null;
        try
		{
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name , $this->username, $this->password);
            $this->conn->exec("set names utf8");
			$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
		catch(PDOException $exception)
		{
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;
    }
}
?>

