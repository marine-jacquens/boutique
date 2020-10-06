<?php


class Users
{
  private $id_user;
  public $lastname;
   public $firstname;
   public $gender;
   public $birthday;
   public $phone;
   public $mail;
   public $password;
   public $date_joined;
   public $date_modified;
   public $deleted_account;
   public $account_type;
   public $db;




  public function __construct($db)
  {
    $this->db = $db;
  }


  public function register($lastname,$firstname,$gender,$birthday,$phone,$mail,$password,$password_check)
  {

    $connexion = $this->db->connectDb();


    if(!empty($lastname && $firstname && $gender && $birthday && $phone && $mail && $password && $password_check))
    {
      if($password == $password_check)
      {
        $hash=password_hash($password,PASSWORD_BCRYPT,array('cost'=>10));
        $default_account_type="normal";
        $date_joined=date("Y-m-d H:i:s");

        //VERIFICATION CORRESPONDANCE LOGIN ENTRE ET EN BDD
        $sth = $connexion->prepare("SELECT mail FROM users  WHERE mail = '$mail' ");
        //EXECUTION DE LA REQUETE
        $sth->execute();
        //RECUPERATION RESULTAT
        $resultat = $sth->fetchAll(PDO::FETCH_ASSOC);

        if(empty($resultat[0]))
        {
          //INSERTION DES INFOS UTILISATEURS EN BDD
          $sql="INSERT into users (lastname,firstname,gender,birthday,phone,mail,password,date_joined,account_type)VALUES (:lastname,:firstname,:gender,:birthday,:phone,:mail,:hash,:date_joined,:account_type)";
          //EXECUTION REQUETE
          $stmt=$connexion->prepare($sql);
          $stmt->bindParam(':lastname',$lastname, PDO::PARAM_STR);
          $stmt->bindParam(':firstname',$firstname, PDO::PARAM_STR);
          $stmt->bindParam(':gender',$gender, PDO::PARAM_STR);
          $stmt->bindParam(':birthday',$birthday, PDO::PARAM_STR);
          $stmt->bindParam(':phone',$phone, PDO::PARAM_STR);
          $stmt->bindParam(':mail',$mail, PDO::PARAM_STR);
          $stmt->bindParam(':hash', $hash, PDO::PARAM_STR);
          $stmt->bindParam(':date_joined',$date_joined, PDO::PARAM_STR);
          $stmt->bindParam(':account_type',$default_account_type, PDO::PARAM_STR);

          $stmt->execute();

          header('location:connexion.php');

        }
        else
        {
          echo 'Cet email existe déjà <br/>';
        }

      }
      else
      {
        echo 'Les champs mot de passe et confirmation de mot de passe doivent être identiques';
      }

    }
    else
    {
    echo'Veuillez remplir tous les champs <br/>';
    }

  }
  
};


?>