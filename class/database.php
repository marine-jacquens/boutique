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
       $this->db_password = "root";
       $this->db_name = "boutique";


   }


   public function connectDb()
   {
       try {
       		//connexion à la base de données
           $this->PDO = new PDO("mysql:host=$this->db_host;dbname=$this->db_name;charset=utf8", $this->db_login, $this->db_password);
           //force PDO à préparer les requêtes
           $this->PDO->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
           //indique à PDO de bien générer une erreur fatale si un problème survient. 
           $this->PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
               
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