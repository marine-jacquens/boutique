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
  public $autorisation_rgpd;
  public $autorisation_newsletter;
  public $db;

  public function __construct($db)
  {
    $this->db = $db;
  }

  public function register ($lastname, $firstname, $gender, $birthday, $phone, $mail, $password, $password_check, $autorisation_rgpd,$autorisation_newsletter)
  {

    $connexion_db = $this->db->connectDb();

    //Cryptage du mot de passe
    $hash = password_hash($password,PASSWORD_BCRYPT,array('cost'=>10));

    date_default_timezone_set('Europe/Paris');
    $date_joined = date("Y-m-d H:i:s");
    $account_type = "normal";

    if(!empty($lastname && $firstname && $gender && $birthday && $phone && $mail && $password && $password_check))
    {

      //vérifie si le mail est valide
      if(filter_var($mail, FILTER_VALIDATE_EMAIL)){

        if($password == $password_check)
        {
          $check_mail = $connexion_db->prepare("SELECT mail FROM users WHERE mail = '$mail' ");
          $check_mail->execute();
          $checked_mail = $check_mail->fetchAll(PDO::FETCH_ASSOC);

          if(empty($checked_mail[0]))
          {
            if(!empty($autorisation_rgpd))
            {

              $insert_new_user = "INSERT into users (lastname,firstname,gender,birthday,phone,mail,password,date_joined,account_type,autorisation_rgpd) VALUES (:lastname,:firstname,:gender,:birthday,:phone,:mail,:hash,:date_joined,:account_type,:autorisation_rgpd)";
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
              $execution_insert->bindParam(':autorisation_rgpd',$autorisation_rgpd,PDO::PARAM_BOOL);
              $execution_insert->execute();

              $this->mail = $mail;
              $this->password = $password;
              $this->autorisation_newsletter = $autorisation_newsletter;

              $this->newsletterSubscriber($autorisation_newsletter,$mail);

              $this->connect($mail,$password);
            }
            else
            {
              $autorisation_rgpd = false; 

              $insert_new_user = "INSERT into users (lastname,firstname,gender,birthday,phone,mail,password,date_joined,account_type,autorisation_rgpd) VALUES (:lastname,:firstname,:gender,:birthday,:phone,:mail,:hash,:date_joined,:account_type,:autorisation_rgpd)";
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
              $execution_insert->bindParam(':autorisation_rgpd',$autorisation_rgpd,PDO::PARAM_BOOL);
              $execution_insert->execute();

              $this->mail = $mail;
              $this->password = $password;
              $this->autorisation_newsletter = $autorisation_newsletter;

              $this->newsletterSubscriber($autorisation_newsletter,$mail);

              $this->connect($mail,$password);

            }

          }else{echo"<span>Ce mail existe déjà</span>";}

        }else{echo"<span>Les champs mot de passe et confirmation de mot de passe doivent être identiques</span>";}

      }else{echo"<span>Mail non conforme</span>";}

    }else{echo"<span>Veuillez remplir tous les champs</span>";}

  }

  public function newsletterSubscriber ($autorisation_newsletter,$mail)
  {
    $connexion_db = $this->db->connectDb();

    $get_id_user = $connexion_db->prepare("SELECT id_user FROM users WHERE mail = '$mail' ");
    $get_id_user->execute();
    $catched_id_user = $get_id_user->fetch(PDO::FETCH_ASSOC);
    $id_user = $catched_id_user['id_user'];

    if(!empty($autorisation_newsletter))
    {

      $subscriber_newsletter = "INSERT into newsletter (id_user, mail, autorisation) VALUES (:id_user,:mail,:autorisation)";
      $new_subscriber_newsletter = $connexion_db->prepare($subscriber_newsletter);
      $new_subscriber_newsletter->bindParam(':id_user',$id_user,PDO::PARAM_INT);
      $new_subscriber_newsletter->bindParam(':mail',$mail,PDO::PARAM_STR);
      $new_subscriber_newsletter->bindParam(':autorisation',$autorisation_newsletter,PDO::PARAM_BOOL);
      $new_subscriber_newsletter->execute();

    }
    else
    {
      $autorisation_newsletter = false; 

      $newsletter = "INSERT into newsletter (id_user, mail, autorisation) VALUES (:id_user,:mail, :autorisation)";
      $new_newsletter = $connexion_db->prepare($newsletter);
      $new_newsletter->bindParam(':id_user',$id_user,PDO::PARAM_INT);
      $new_newsletter->bindParam(':mail',$mail,PDO::PARAM_STR);
      $new_newsletter->bindParam(':autorisation',$autorisation_newsletter,PDO::PARAM_BOOL);
      $new_newsletter->execute();
    }
  }

  public function newsletterNoSubscriber($mail_noSubscriber){

    $connexion_db = $this->db->connectDb();

    if(!empty($mail_noSubscriber)){

      $check_mail_newsletter = $connexion_db -> prepare("SELECT mail FROM newsletter WHERE mail = '$mail_noSubscriber' ");
      $check_mail_newsletter->execute();
      $checked_mail = $check_mail_newsletter->fetchAll(PDO::FETCH_ASSOC);

      if(empty($checked_mail[0])){

        $autorisation_newsletter = true; 

        $mail_newsletter = "INSERT into newsletter (mail, autorisation) VALUES (:mail, :autorisation)";
        $new_newsletter_mail = $connexion_db->prepare($mail_newsletter);
        $new_newsletter_mail->bindParam(':mail',$mail_noSubscriber,PDO::PARAM_STR);
        $new_newsletter_mail->bindParam(':autorisation',$autorisation_newsletter,PDO::PARAM_BOOL);
        $new_newsletter_mail->execute();

        header('Location:index.php');
      }
      else
      {
        echo "<span>Ce mail est déjà enregistré</span>";
      }

    }
    else
    {
      echo "<span>Veuillez remplir le champs</span>";
    }
  }

  public function connect ($mail, $password)
  {

    $connexion_db = $this->db->connectDb();

    if(!empty($mail && $password))
    {
      //préparation de la requête en prenant en compte 1 paramètre
      $user_account = $connexion_db->prepare("SELECT * FROM users WHERE mail = :mail ");
      //execution de la requête en associant le paramètre à la donnée 
      $user_account->execute(array('mail' => $mail));
      //récupération des données utilisateurs 
      $user = $user_account->fetch(PDO::FETCH_ASSOC);


      $user_newsletter = $connexion_db->prepare("SELECT * FROM newsletter WHERE mail = '$mail' ");
      $user_newsletter->execute();
      $newsletter = $user_newsletter->fetch(PDO::FETCH_ASSOC);

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
          $this->autorisation_rgpd = $user['autorisation_rgpd'];
          $this->autorisation_newsletter = $newsletter['autorisation'];

          //Création d'un tableau de session user pour y associer toutes les données relatives à l'utilisateur connecté
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
            'account_type' => $this->account_type,
            'autorisation_rgpd' => $this->autorisation_rgpd,
            'autorisation_newsletter' => $this->autorisation_newsletter
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
    $this->autorisation_rgpd ="";
    $this->autorisation_newsletter="";
    session_unset();
    session_destroy();
    header('Location:index.php');
  }

  public function update($lastname, $firstname, $gender, $birthday, $phone, $mail, $password, $password_check,$account_type,$rgpd,$newsletter,$id_user)
  {
    $connexion_db = $this->db->connectDb();
    date_default_timezone_set('Europe/Paris');
    $date_modified = date("Y-m-d H:i:s");

    if(!empty($lastname))
    {
      $new_lastname = "UPDATE users SET lastname = :lastname, date_modified = :date_modified WHERE id_user = $id_user ";
      $update_lastname = $connexion_db -> prepare($new_lastname);
      $update_lastname->bindParam(':lastname',$lastname, PDO::PARAM_STR);
      $update_lastname->bindParam(':date_modified',$date_modified, PDO::PARAM_STR);
      $update_lastname->execute(); 
    }

    if(!empty($firstname))
    {
      $new_firstname = "UPDATE users SET firstname=:firstname, date_modified = :date_modified WHERE id_user = $id_user ";
      $update_firstname = $connexion_db -> prepare($new_firstname);
      $update_firstname->bindParam(':firstname',$firstname, PDO::PARAM_STR);
      $update_firstname->bindParam(':date_modified',$date_modified, PDO::PARAM_STR);
      $update_firstname->execute(); 
    }

    if(!empty($gender))
    {
      $new_gender = "UPDATE users SET gender = :gender, date_modified = :date_modified WHERE id_user = $id_user ";
      $update_gender = $connexion_db -> prepare($new_gender);
      $update_gender->bindParam(':gender',$gender, PDO::PARAM_STR);
      $update_gender->bindParam(':date_modified',$date_modified, PDO::PARAM_STR);
      $update_gender->execute(); 
    }

    if(!empty($birthday))
    {
      $new_birthday = "UPDATE users SET birthday = :birthday, date_modified = :date_modified WHERE id_user = $id_user ";
      $update_birthday = $connexion_db -> prepare($new_birthday);
      $update_birthday->bindParam(':birthday',$birthday, PDO::PARAM_STR);
      $update_birthday->bindParam(':date_modified',$date_modified, PDO::PARAM_STR);
      $update_birthday->execute(); 
    }

    if(!empty($phone))
    {
      //vérifie que l'entrée numéro de téléphone ne contient que des chiffres et en nombre limité
      if(preg_match("#^[0-9]{10}$#",$phone)){

        //mise à jour du numéro de téléphone
        $new_phone = "UPDATE users SET phone=?, date_modified=? WHERE id_user=? ";
        $update_phone = $connexion_db->prepare($new_phone);
        $update_phone->execute([$phone,$date_modified,$id_user]); 
      }
      else{
         echo "Numéro de téléphone non conforme";
      }  
    }

    if(!empty($mail))
    {
      $check_mail = $connexion_db->prepare("SELECT mail FROM users WHERE mail = '$mail' ");
      $check_mail->execute();
      $checked_mail = $check_mail->fetchAll(PDO::FETCH_ASSOC);

      if(empty($checked_mail[0]))
      {
        $new_mail = "UPDATE users SET mail =:mail,  date_modified = :date_modified WHERE id_user = $id_user ";
        $update_mail  = $connexion_db -> prepare($new_mail);
        $update_mail->bindParam(':mail',$mail, PDO::PARAM_STR);
        $update_mail->bindParam(':date_modified',$date_modified, PDO::PARAM_STR);
        $update_mail->execute(); 
      }
      else
      {
        echo "Ce mail existe déjà";
      }   
    }

    if(!empty($password || $password_check))
    {
      if($password == $password_check)
      {
        $hash=password_hash($password,PASSWORD_BCRYPT,array('cost'=>10));

        $new_password = "UPDATE users SET password=:hash, date_modified = :date_modified WHERE id_user = $id_user ";
        $update_password = $connexion_db -> prepare($new_password);
        $update_password->bindParam(':hash',$hash, PDO::PARAM_STR);
        $update_password->bindParam(':date_modified',$date_modified, PDO::PARAM_STR);
        $update_password->execute(); 

      }
      else
      {
        echo "Les champs mot de passe et confirmation de mot de passe doivent être identiques";
      } 

    }

    if(!empty($account_type)){
      $new_account_type = "UPDATE users SET account_type=:account_type, date_modified = :date_modified WHERE id_user = $id_user ";
      $update_account = $connexion_db -> prepare($new_account_type);
      $update_account->bindParam(':account_type',$account_type, PDO::PARAM_STR);
      $update_account->bindParam(':date_modified',$date_modified, PDO::PARAM_STR);
      $update_account->execute();   
    }

    if(!empty($rgpd)){

      if($rgpd=="denial"){

        $autorisation = false;

        $new_rgpd = "UPDATE users SET autorisation_rgpd=:rgpd, date_modified = :date_modified WHERE id_user = $id_user ";
        $update_rgpd = $connexion_db -> prepare($new_rgpd);
        $update_rgpd->bindParam(':rgpd',$autorisation, PDO::PARAM_BOOL);
        $update_rgpd->bindParam(':date_modified',$date_modified, PDO::PARAM_STR);
        $update_rgpd->execute();  

      }
      else{

        $autorisation = true;

        $new_rgpd = "UPDATE users SET autorisation_rgpd=:rgpd, date_modified = :date_modified WHERE id_user = $id_user ";
        $update_rgpd = $connexion_db -> prepare($new_rgpd);
        $update_rgpd->bindParam(':rgpd',$autorisation, PDO::PARAM_BOOL);
        $update_rgpd->bindParam(':date_modified',$date_modified, PDO::PARAM_STR);
        $update_rgpd->execute(); 

      }

    }

    if(!empty($newsletter)){

      if($newsletter=="denial"){

        $autorisation = false;

        $new_newsletter = "UPDATE newsletter SET autorisation=:autorisation WHERE id_user = $id_user";
        $update_newsletter = $connexion_db -> prepare($new_newsletter);
        $update_newsletter->bindParam(':autorisation',$autorisation, PDO::PARAM_BOOL);
        $update_newsletter->execute();   


      }else{

        $autorisation = true;

        $new_newsletter = "UPDATE newsletter SET autorisation=:autorisation WHERE id_user = $id_user";
        $update_newsletter = $connexion_db -> prepare($new_newsletter);
        $update_newsletter->bindParam(':autorisation',$autorisation, PDO::PARAM_BOOL);
        $update_newsletter->execute(); 

      }

    }

    

    
    

    if(isset($_SESSION['user']['id_user']) AND $_SESSION['user']['id_user']  == $id_user){
      $this->refresh();
    }else { header("Location:account_management.php#edit_management"); exit; }
    
  }





  public function refresh()
  {
    $connexion_db = $this->db->connectDb();
    $session = $_SESSION['user']['id_user'];

    //REATTRIBUTION DES NOUVELLES DONNEES UTILISATEUR AU TABLEAU SESSION

    $updated_session = $connexion_db -> prepare("SELECT * FROM users WHERE id_user = '$session' ");
    $updated_session->execute();
    $user = $updated_session->fetch(PDO::FETCH_ASSOC);

    $user_newsletter = $connexion_db->prepare("SELECT * FROM newsletter WHERE id_user = '$session' ");
    $user_newsletter->execute();
    $newsletter = $user_newsletter->fetch(PDO::FETCH_ASSOC);

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
    $this->autorisation_rgpd = $user['autorisation_rgpd'];
    $this->autorisation_newsletter = $newsletter['autorisation'];
    
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
      'account_type' => $this->account_type,
      'autorisation_rgpd' => $this->autorisation_rgpd,
      'autorisation_newsletter' => $this->autorisation_newsletter
      ];

    header('Location:profil.php');
    exit;

  }

  public function delete($id_user){

    $connexion_db = $this->db->connectDb();

    $delete_user = $connexion_db->prepare(" DELETE FROM users WHERE id_user = $id_user "); 
    $delete_user->execute();

    $delete_user = $connexion_db->prepare(" DELETE FROM newsletter WHERE id_user = $id_user ");
    $delete_user->execute();

    $delete_user = $connexion_db->prepare(" DELETE FROM cart_items WHERE id_user = $id_user "); 
    $delete_user->execute();

    $delete_user = $connexion_db->prepare(" DELETE FROM wish_list_items WHERE id_user = $id_user "); 
    $delete_user->execute();

    $delete_user = $connexion_db->prepare(" DELETE FROM bills_adresses  WHERE id_user = $id_user "); 
    $delete_user->execute();

    $delete_user = $connexion_db->prepare(" DELETE FROM deliveries_adresses WHERE id_user = $id_user "); 
    $delete_user->execute();

    $delete_user = $connexion_db->prepare(" DELETE FROM orders  WHERE id_user = $id_user "); 
    $delete_user->execute();

    header('Location:account_management.php#account_management.php');
    exit;
  }

  

}
?>