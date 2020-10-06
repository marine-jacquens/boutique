<?php
	session_start();
?>

<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
	<title>Boutique - Connexion</title>
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
				$user->connect(
					$_POST['mail'],
					$_POST['password']
				);
			}
		?>
		<form action="" method="post">
			<h1>CONNEXION</h1>
			<label for="mail">Email</label><br>
	        <input type="text" name="mail" placeholder="email@email.com"><br>
			<label for="password">Mot de passe</label><br>
	        <input type="password" name="password" placeholder="Entrez votre mot de passe">

	        <input type="submit" name="submit" value="CONNEXION">
		</form>
	</main>
	<footer>
		
	</footer>
</body>
</html>
