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
  public $db;

  public function __construct($db)
  {
    $this->db = $db;
  }

  public function register ($lastname, $firstname, $gender, $birthday, $phone, $mail, $password, $password_check)
  {

    $connexion_db = $this->db->connectDb();

    $hash = password_hash($password,PASSWORD_BCRYPT,array('cost'=>10));
    date_default_timezone_set('Europe/Paris');
    $date_joined = date("Y-m-d H:i:s");
    $account_type = "normal";

    if(!empty($lastname && $firstname && $gender && $birthday && $phone && $mail && $password && $password_check))
    {
      if($password == $password_check)
      {
        $check_mail = $connexion_db->prepare("SELECT mail FROM users WHERE mail = '$mail' ");
        $check_mail->execute();
        $checked_mail = $check_mail->fetchAll(PDO::FETCH_ASSOC);

        if(empty($checked_mail[0]))
        {
          $insert_new_user = "INSERT into users (lastname,firstname,gender,birthday,phone,mail,password,date_joined,account_type) VALUES (:lastname,:firstname,:gender,:birthday,:phone,:mail,:hash,:date_joined,:account_type)";
          $execution_insert = $connexion_db->prepare($insert_new_user);
          $execution_insert->bindParam(':lastname',$lastname,PDO::PARAM_STR);
          $execution_insert->bindParam(':firstname',$firstname,PDO::PARAM_STR);
          $execution_insert->bindParam(':gender',$gender,PDO::PARAM_STR);
          $execution_insert->bindParam(':birthday',$birthday,PDO::PARAM_STR);
          $execution_insert->bindParam(':phone',$phone,PDO::PARAM_STR);
          $execution_insert->bindParam(':mail',$mail,PDO::PARAM_STR);
          $execution_insert->bindParam(':hash',$hash,PDO::PARAM_STR);
          $execution_insert->bindParam(':date_joined',$date_joined,PDO::PARAM_STR);
          $execution_insert->bindParam(':account_type',$account_type,PDO::PARAM_STR);
          $execution_insert->execute();

          $this->mail = $mail;
          $this->password = $password;

          $this->connect($mail,$password);
          header('Location:index.php');
          exit;
 

        }else{echo"<span>Ce mail existe déjà</span>";}

      }else{echo"<span>Les champs mot de passe et confirmation de mot de passe doivent être identiques</span>";}

    }else{echo"<span>Veuillez remplir tous les champs</span>";}

  }

  public function connect ($mail, $password)
  {

    $connexion_db = $this->db->connectDb();

    if(!empty($mail && $password))
    {
      $user_account = $connexion_db->prepare("SELECT * FROM users WHERE mail = '$mail' ");
      $user_account->execute();
      $user = $user_account->fetch(PDO::FETCH_ASSOC);

      if(!empty($user))
      {

        if(password_verify($password,$user['password']))
        {
          $this->id_user = $user['id_user'];
          $this->lastname = $user['lastname'];
          $this->firstname = $user['firstname'];
          $this->gender = $user['gender'];
          $this->birthday = $user['birthday'];
          $this->phone = $user['phone'];
          $this->mail = $user['mail'];
          $this->password = $user['password'];
          $this->date_joined = $user['date_joined'];
          $this->date_modified = $user['date_modified'];
          $this->account_type = $user['account_type'];

          $_SESSION['user'] = [
            'id_user' => $this->id_user,
            'lastname' => $this->lastname,
            'firstname' => $this->firstname,
            'gender' => $this->gender,
            'birthday' => $this->birthday,
            'phone' => $this->phone,
            'mail' => $this->mail,
            'password' => $this->password,
            'date_joined' => $this->date_joined,
            'date_modified' => $this->date_modified,
            'account_type' => $this->account_type
          ];

          header('Location:index.php');
          exit;
        }

      }
      else
      {
        echo "<span>Votre adresse mail ou mot de passe est erroné</span>";
      }

    }
    else
    {
      echo "<span>Veuillez remplir tous les champs</span>";
    }

  }

  public function disconnect()
  {
    $this->id_user = "";
    $this->lastname = "";
    $this->firstname = "";
    $this->gender = "";
    $this->birthday = "";
    $this->phone = "";
    $this->mail = "";
    $this->password = "";
    $this->date_joined = "";
    $this->date_modified = "";
    $this->account_type = "";
    session_unset();
    session_destroy();
    header('Location:index.php');
  }

  public function update($lastname, $firstname, $gender, $birthday, $phone, $mail, $password, $password_check)
  {
    $connexion_db = $this->db->connectDb();
    $session = $_SESSION['user']['id_user'];

    if(!empty($lastname))
    {
      $new_lastname = "UPDATE users SET lastname=:lastname WHERE id_user = '$session' ";
      $update_lastname = $connexion_db -> prepare($new_lastname);
      $update_lastname->bindParam(':lastname',$lastname, PDO::PARAM_STR);
      $update_lastname->execute(); 
    }

    if(!empty($firstname))
    {
      $new_firstname = "UPDATE users SET firstname=:firstname WHERE id_user = '$session' ";
      $update_firstname = $connexion_db -> prepare($new_firstname);
      $update_firstname->bindParam(':firstname',$firstname, PDO::PARAM_STR);
      $update_firstname->execute(); 
    }

    if(!empty($gender))
    {
      $new_gender = "UPDATE users SET gender=:gender WHERE id_user = '$session' ";
      $update_gender = $connexion_db -> prepare($new_gender);
      $update_gender->bindParam(':gender',$gender, PDO::PARAM_STR);
      $update_gender->execute(); 
    }

    if(!empty($birthday))
    {
      $new_birthday = "UPDATE users SET birthday=:birthday WHERE id_user = '$session' ";
      $update_birthday = $connexion_db -> prepare($new_birthday);
      $update_birthday->bindParam(':birthday',$birthday, PDO::PARAM_STR);
      $update_birthday->execute(); 
    }

    if(!empty($phone))
    {
      $new_phone = "UPDATE users SET phone=:phone WHERE id_user = '$session' ";
      $update_phone = $connexion_db -> prepare($new_phone);
      $update_phone->bindParam(':phone',$phone, PDO::PARAM_STR);
      $update_phone->execute(); 
    }

    if(!empty($mail))
    {
      $check_mail = $connexion_db->prepare("SELECT mail FROM users WHERE mail = '$mail' ");
      $check_mail->execute();
      $checked_mail = $check_mail->fetchAll(PDO::FETCH_ASSOC);

      if(empty($checked_mail[0]))
      {
        $new_mail = "UPDATE users SET mail =:mail  WHERE id_user = '$session' ";
        $update_mail  = $connexion_db -> prepare($new_mail);
        $update_mail->bindParam(':mail',$mail, PDO::PARAM_STR);
        $update_mail->execute(); 
      }
      else
      {
        echo "Ce mail existe déjà";
      }   
    }

    if(!empty($password && $password_check))
    {
      if($password == $password_check)
      {
        $hash=password_hash($password,PASSWORD_BCRYPT,array('cost'=>10));

        $new_password = "UPDATE users SET password=:hash WHERE id_user = '$session' ";
        $update_password = $connexion_db -> prepare($new_password);
        $update_password->bindParam(':hash',$hash, PDO::PARAM_STR);
        $update_password->execute(); 

      }
      else
      {
        echo "Les champs mot de passe et confirmation de mot de passe doivent être identiques";
      } 

    }
    else
    {
      echo "Veuillez remplir les champs mot de passe et confirmation de mot de passe";
    }

    $this->refresh();
  }


  public function refresh()
  {
    $connexion_db = $this->db->connectDb();
    $session = $_SESSION['user']['id_user'];

    //REATTRIBUTION DES NOUVELLES DONNEES UTILISATEUR AU TABLEAU SESSION

    $updated_session = $connexion_db -> prepare("SELECT * FROM users WHERE id_user = '$session' ");
    $updated_session->execute();
    $user = $updated_session->fetch(PDO::FETCH_ASSOC);

    $this->id_user = $user['id_user'];
    $this->lastname = $user['lastname'];
    $this->firstname = $user['firstname'];
    $this->gender = $user['gender'];
    $this->birthday = $user['birthday'];
    $this->phone = $user['phone'];
    $this->mail = $user['mail'];
    $this->password = $user['password'];
    $this->date_joined = $user['date_joined'];
    $this->date_modified = $user['date_modified'];
    $this->account_type = $user['account_type'];

    $_SESSION['user'] = [
      'id_user' => $this->id_user,
      'lastname' => $this->lastname,
      'firstname' => $this->firstname,
      'gender' => $this->gender,
      'birthday' => $this->birthday,
      'phone' => $this->phone,
      'mail' => $this->mail,
      'password' => $this->password,
      'date_joined' => $this->date_joined,
      'date_modified' => $this->date_modified,
      'account_type' => $this->account_type
      ];

    header('Location:profil.php');
    exit;

  }

  

}
?>