<?php
class Database
{
   private $db_host;
   private $db_login;
   private $db_password;
   private $db_name;
   public $PDO;


   public function __construct()
   {
       $this->db_host = "localhost";
       $this->db_login = "root";
       $this->db_password = "";
       $this->db_name = "boutique";


   }


   public function connectDb()
   {
       try {
           $this->PDO = new PDO("mysql:host=$this->db_host;dbname=$this->db_name;charset=utf8", $this->db_login, $this->db_password,array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
               
           return $this->PDO;

       } catch (PDOException $e) {
           echo "Erreur : " . $e->getMessage();
        }
    }


  public function close(){
    mysqli_close($this->PDO);
  }

}



?>