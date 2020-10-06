<?php
	session_start();
?>

<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
	<title>Boutique - Inscription</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, user-scalable=yes">
    <link rel="shortcut icon" type="image/x-icon" href="images/logo.png">
    <link rel="stylesheet" href="fontawesome/all.css">
</head>
<body>
	<header>
		<?php include("includes/header.php")?>
	</header>
	<main>
		<?php 
			if(isset($_POST['submit']))
			{
				$user->register(
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

			?>

	
		<form action="" method="post">
			<h1>INSCRIPTION</h1>
			<label for="lastname">Nom de famille</label><br>
	        <input type="text" name="lastname" placeholder="Entrez votre nom de famille"><br>
	        <label for="firstname">Prénom</label><br>
	        <input type="text" name="firstname" placeholder="Entrez votre prénom"><br>

	        <input type="radio" name="gender" id="male" value="male">
	        <label for="male">Homme</label>
	        <input type="radio" name="gender" id="female" value="female">
	        <label for="female">Femme</label>
	        <input type="radio" name="gender" id="no_gender" value="no_gender">
	        <label for="no_gender">Non genré</label><br>

	        <label for="birthday">Date de naissance</label><br>
	        <input type="date" name="birthday"><br>
	        <label for="phone">N° de téléphone</label><br>
	        <input type="text" name="phone" placeholder="0123456789"><br>
	        <label for="mail">Email</label><br>
	        <input type="text" name="mail" placeholder="email@email.com"><br>
	            

	        <label for="password">Mot de passe</label><br>
	        <input type="password" name="password" placeholder="Entrez votre mot de passe"><br>
			<label for="password_check">Confirmation mot de passe</label><br>
	        <input type="password" name="password_check" placeholder="Confirmez votre mot de passe"><br>

	        <input type="submit" name="submit" value="ENREGISTRER">
		</form>

	</main>
	<footer>
		
	</footer>
	

</body>
</html>
