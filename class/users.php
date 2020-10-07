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

        $check_mail = $connexion->prepare("SELECT mail FROM users  WHERE mail = '$mail' ");
        $check_mail->execute();
        $checked_mail = $check_mail->fetchAll(PDO::FETCH_ASSOC);

        if(empty($checked_mail[0]))
        {
          $insert_new_user="INSERT into users (lastname,firstname,gender,birthday,phone,mail,password,date_joined,account_type)VALUES (:lastname,:firstname,:gender,:birthday,:phone,:mail,:hash,:date_joined,:account_type)";
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
          $this->account_type = $account_user['account_type'];

          $_SESSION['user'] = [
                    'id_user' =>
                        $this->id_user,
                    'lastname' =>
                        $this->lastname,
                    'firstname' =>
                        $this->firstname,
                    'gender' =>
                        $this->gender,
                    'birthday' =>
                        $this->birthday,
                    'phone' =>
                        $this->phone,
                    'mail' =>
                        $this->mail,
                    'password' =>
                        $this->password,
                    'date_joined' =>
                        $this->date_joined,
                    'date_modified' =>
                        $this->date_modified,   
                    'account_type' =>
                        $this->account_type
                ];
                return $_SESSION['user'];
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
      $this->register_date = "";
      $this->date_modified = "";
      $this->account_type = "";
      session_unset();
      session_destroy();
      header('location:index.php');
  }




  public function delete($password)
  {
    $connexion = $this->db->connectDb();
    if(password_verify($password,$this->password))
    {
      $deleted_account = true ;

      $account_suppress = $connexion->prepare("DELETE FROM users WHERE id_user = '$this->id_user'");
      $account_suppress ->execute();
      $this->disconnect();
    }
    else 
    {
      echo "Votre mot de passe est erroné";
    }
  }




  public function update()
  {
    $connexion = $this->db->connectDb();
    $date_modified = date("Y-m-d H:i:s");

    if(!empty($lastname))
    {
      $update_lastname = "UPDATE users SET lastname =:lastname, date_modified = :date_modified  WHERE id_user = '$this->id_user' ";
      $update_lastname_user = $connexion->prepare($update_lastname);
      $update_lastname_user->bindParam(':lastname',$lastname, PDO::PARAM_STR);
      $update_lastname_user->bindParam(':date_modified',$date_modified, PDO::PARAM_STR);
      $update_lastname_user->execute(); 
      header('location:profil.php');
    }

    if(!empty($firstname))
    {
      $update_firstname = "UPDATE users SET firstname =:firstname, date_modified = :date_modified WHERE id_user = '$this->id_user' ";
      $update_firstname_user=$connexion->prepare($update_firstname);
      $update_firstname_user->bindParam(':firstname',$firstname, PDO::PARAM_STR);
      $update_firstname_user->bindParam(':date_modified',$date_modified, PDO::PARAM_STR);
      $update_firstname_user->execute(); 
      header('location:profil.php');
    }

    if(!empty($gender))
    {
      $update_gender = "UPDATE users SET gender =:gender, date_modified = :date_modified WHERE id_user = '$this->id_user' ";
      $update_gender_user=$connexion->prepare($update_gender);
      $update_gender_user->bindParam(':gender',$gender, PDO::PARAM_STR);
      $update_gender_user->bindParam(':date_modified',$date_modified, PDO::PARAM_STR);
      $update_gender_user->execute(); 
      header('location:profil.php');
    }

    if(!empty($phone))
    {
      $update_phone = "UPDATE users SET phone =:phone, date_modified = :date_modified WHERE id_user = '$this->id_user' ";
      $update_phone_user=$connexion->prepare($update_phone);
      $update_phone_user->bindParam(':phone',$phone, PDO::PARAM_STR);
      $update_phone_user->bindParam(':date_modified',$date_modified, PDO::PARAM_STR);
      $update_phone_user->execute(); 
      header('location:profil.php');
    }

     if(!empty($mail))
    {
      $check_mail = $connexion->prepare("SELECT mail FROM users  WHERE mail = '$mail' ");
      $check_mail->execute();
      $checked_mail = $check_mail->fetchAll(PDO::FETCH_ASSOC);

      if(empty($checked_mail[0]))
      {
        $update_mail = "UPDATE users SET mail =:mail, date_modified = :date_modified WHERE id_user = '$this->id_user' ";
        $update_mail_user=$connexion->prepare($update_mail);
        $update_mail_user->bindParam(':mail',$mail, PDO::PARAM_STR);
        $update_mail_user->bindParam(':date_modified',$date_modified, PDO::PARAM_STR);
        $update_mail_user->execute();
        header('location:profil.php');

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

        $update_password = "UPDATE users SET password =:hash, date_modified = :date_modified WHERE id_user = '$this->id_user' ";
        $update_password_user=$connexion->prepare($update_password);
        $update_password_user->bindParam(':hash',$hash, PDO::PARAM_STR);
        $update_password_user->bindParam(':date_modified',$date_modified, PDO::PARAM_STR);
        $update_password_user->execute(); 
        header('location:profil.php');
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




  }













  
};


?>