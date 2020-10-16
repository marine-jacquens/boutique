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
  public $account_type;

  public function register ($lastname, $firstname, $gender, $birthday, $mail, $password, $password_check )
  {

    try
    {
      $connexion_db = new PDO("mysql:host=localhost;dbname=boutique", 'root', '');
      $connexion_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      $hash = password_hash($password,PASSWORD_BCRYPT,array('cost'=>10));
      date_default_timezone_set('Europe/Paris');
      $date_joined = date("Y-m-d H:i:s");
      $account_type = "normal";

      if(!empty($lastname && $firstname && $gender && $birthday && $mail && $password && $password_check))
      {
        if($password == $password_check)
        {
          $check_mail = $connexion_db->prepare("SELECT mail FROM users WHERE mail = '$mail' ");
          $check_mail->execute();
          $checked_mail = $check_mail->fetchAll(PDO::FETCH_ASSOC);

          if(empty($checked_mail[0]))
          {
            $insert_new_user = "INSERT into users (lastname,firstname,gender,birthday,mail,password,date_joined,account_type) VALUES (:lastname,:firstname,:gender,:birthday,:mail,:hash,:date_joined,:account_type)";
            $execution_insert = $connexion_db->prepare($insert_new_user);
            $execution_insert->bindParam(':lastname',$lastname,PDO::PARAM_STR);
            $execution_insert->bindParam(':firstname',$firstname,PDO::PARAM_STR);
            $execution_insert->bindParam(':gender',$gender,PDO::PARAM_STR);
            $execution_insert->bindParam(':birthday',$birthday,PDO::PARAM_STR);
            $execution_insert->bindParam(':mail',$mail,PDO::PARAM_STR);
            $execution_insert->bindParam(':hash',$hash,PDO::PARAM_STR);
            $execution_insert->bindParam(':date_joined',$date_joined,PDO::PARAM_STR);
            $execution_insert->bindParam(':account_type',$account_type,PDO::PARAM_STR);
            $execution_insert->execute();

            header('location:index.php');

          }else{echo"Ce mail existe déjà";}

        }else{echo"Les champs mot de passe et confirmation de mot de passe doivent être identiques";}

      }else{echo"Veuillez remplir tous les champs";}


    }
    catch(PDOException $e)
    {
      echo "Erreur : " . $e->getMessage();
    }


  
  }

  
}

ob_end_flush();
?>