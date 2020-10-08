<?php
	session_start();
?>

<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
	<title>Boutique - Profil</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, user-scalable=yes">
    <link rel="shortcut icon" type="image/x-icon" href="images/logo.png">
    <link rel="stylesheet" href="fontawesome/all.css">
    <link rel="stylesheet" href="css/general.css">
    <link rel="stylesheet" href="css/header.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200&display=swap" rel="stylesheet">
</head>
<body>
	<header>
		<?php include("includes/header.php")?>
	</header>
	<main>
		<?php 

			if(isset($_POST['submit']))
			{
				$user->update(
					$_POST['lastname'],
					$_POST['firstname'],
					$_POST['gender'],
					$_POST['birthday'],
					$_POST['phone'],
					$_POST['mail'],
					$_POST['password'],
					$_POST['password_check'],
				);
			}

				var_dump($_SESSION['user']);
			?>

	
		<form action="" method="post">
			<h1>PROFIL</h1>
			<label for="lastname">Nom de famille</label><br>
	        <input type="text" name="lastname" placeholder="<?php echo $_SESSION['user']['lastname'] ?>"><br>
	        <label for="firstname">Prénom</label><br>
	        <input type="text" name="firstname" placeholder="<?php echo $_SESSION['user']['firstname'] ?>"><br>

	        <?php
	        	$gender_check = $_SESSION['user']['gender'];
                $check = ($gender_check=="male")?true:false;
                $check2 = ($gender_check=="female")?true:false;
                $check3 = ($gender_check=="no_gender")?true:false;

            ?>
	        <input type="radio" name="gender" id="male" value="male" <?php if($check==true){echo "checked";}else{echo "";}  ?>>
	        <label for="male">Homme</label>

	        <input type="radio" name="gender" id="female" value="female" <?php if($check2==true){echo "checked";}else{echo "";}  ?>>
	        <label for="female">Femme</label>

	        <input type="radio" name="gender" id="no_gender" value="no_gender" <?php if($check3==true){echo "checked";}else{echo "";}  ?>>
	        <label for="no_gender">Non genré</label><br>


	        <label for="birthday">Date de naissance</label><br>
	        <input type="date" name="birthday" value="<?php echo $_SESSION['user']['birthday'] ?>"><br>
	        <label for="phone">N° de téléphone</label><br>
	        <input type="text" name="phone" placeholder="<?php echo $_SESSION['user']['phone'] ?>"><br>
	        <label for="mail">Email</label><br>
	        <input type="text" name="mail" placeholder="<?php echo $_SESSION['user']['mail'] ?>"><br>
	            

	        <label for="password">Mot de passe</label><br>
	        <input type="password" name="password" placeholder="Entrez votre mot de passe"><br>
			<label for="password_check">Confirmation mot de passe</label><br>
	        <input type="password" name="password_check" placeholder="Confirmez votre mot de passe"><br>

	        <input type="submit" name="submit" value="VALIDER MODIFICATION">
		</form>

	</main>
	<footer>
		
	</footer>
	

</body>
</html>