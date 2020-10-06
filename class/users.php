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
        $check_mail = $connexion->prepare("SELECT mail FROM users  WHERE mail = '$mail' ");
        //EXECUTION DE LA REQUETE
        $check_mail->execute();
        //RECUPERATION RESULTAT
        $checked_mail = $check_mail->fetchAll(PDO::FETCH_ASSOC);

        if(empty($checked_mail[0]))
        {
          //INSERTION DES INFOS UTILISATEURS EN BDD
          $insert_new_user="INSERT into users (lastname,firstname,gender,birthday,phone,mail,password,date_joined,account_type)VALUES (:lastname,:firstname,:gender,:birthday,:phone,:mail,:hash,:date_joined,:account_type)";
          //EXECUTION REQUETE
          $insert_data_user=$connexion->prepare($insert_new_user);
          $insert_data_user->bindParam(':lastname',$lastname, PDO::PARAM_STR);
          $insert_data_user->bindParam(':firstname',$firstname, PDO::PARAM_STR);
          $insert_data_user->bindParam(':gender',$gender, PDO::PARAM_STR);
          $insert_data_user->bindParam(':birthday',$birthday, PDO::PARAM_STR);
          $insert_data_user->bindParam(':phone',$phone, PDO::PARAM_STR);
          $insert_data_user->bindParam(':mail',$mail, PDO::PARAM_STR);
          $insert_data_user->bindParam(':hash', $hash, PDO::PARAM_STR);
          $insert_data_user->bindParam(':date_joined',$date_joined, PDO::PARAM_STR);
          $insert_data_user->bindParam(':account_type',$default_account_type, PDO::PARAM_STR);

          $insert_data_user->execute();

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




  public function connect($mail,$password)
  {
    $connexion = $this->db->connectDb();
    

    if(!empty($mail && $password))
    {
      $check_user_account = $connexion-> prepare("SELECT * FROM users WHERE mail ='$mail' ");
      $check_user_account->execute();
      $account_user = $check_user_account->fetch(PDO::FETCH_ASSOC);

      if(!empty($account_user))
      {
        if(password_verify($password,$account_user['password']))
        {
          $this->id_user = $account_user['id_user'];
          $this->lastname = $account_user['lastname'];
          $this->firstname = $account_user['firstname'];
          $this->gender = $account_user['gender'];
          $this->birthday = $account_user['birthday'];
          $this->phone = $account_user['phone'];
          $this->mail = $account_user['mail'];
          $this->password = $account_user['password'];
          $this->date_joined = $account_user['date_joined'];
          $this->date_modified = $account_user['date_modified'];
          $this->deleted_account = $account_user['deleted_account'];
          $this->account_type = $account_user['account_type'];

          $_SESSION['id_user']=$this->id_user;
          header('location:index.php');

          
        }
      }
      else
      {
        echo "Le mail ou le mot de passe est erroné";
      }

    }
    else
    {
    echo "Veuillez remplir tous les champs";
    }

  }
  
};


?>