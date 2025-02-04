<?php
ob_start();
?>

<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
	<title>Boutique - Inscription</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=image">
    <link rel="shortcut icon" type="image/x-icon" href="images/logo.png">
    <link rel="stylesheet" href="fontawesome/all.css">
    <link rel="stylesheet" href="css/general.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/inscription.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200&display=swap" rel="stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
	<header>
		<?php include("includes/header.php")?>
	</header>
	<main class="main-inscription">
		<?php 

			if(isset($_SESSION['user']['id_user'] )){
				header('Location:index.php');
				exit;
			}

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
					$_POST['autorisation_rgpd'],
					$_POST['autorisation_newsletter']
				);

			}


		?>

		<section class="inscription-page">
			<h5>S'inscrire</h5>
			<p>
				Inscrivez-vous maintenant et bénéficiez des avantages Mon Compte. 
				Vous pourrez :
			</p>
			<ul>
				<li>Recevoir notre newsletter</li>
				<li>Sauvegarder vos articles coups de coeur</li>
				<li>Contrôler vos commandes et retours</li>
			</ul>
			<p>Champs obligatoires<span>*</span></p>
		</section>

		<section class="form-inscription">

			<form action="" method="post">

				<div class="formpart1_photo">

					<div class="form-input">

						<div class="gender">
							<p>Sexe *</p>
						
							<input type="radio" name="gender" id="male" value="male" checked="checked">
							<label for="male">Homme</label>
					        
					        <input type="radio" name="gender" id="female" value="female">
					        <label for="female">Femme</label>
					        
					        <input type="radio" name="gender" id="no_gender" value="no_gender">
					        <label for="no_gender">Non genré</label>
						</div>

						<label for="firstname">Prénom *</label>
				        <input type="text" name="firstname" class="input" placeholder="Entrez votre prénom" autocomplete="on">

						<label for="lastname">Nom *</label>
				        <input type="text" name="lastname" class="input" placeholder="Entrez votre nom de famille" autocomplete="on">

				        <label for="phone">N° de téléphone</label>
				        <input type="text" name="phone" class="input" placeholder="0646113568" autocomplete="on">

				        <label for="mail">Adresse mail *</label>
				        <input type="email" name="mail" class="input" placeholder="email@email.com" autocomplete="on">

				        <label for="password">Mot de passe *</label>
				        <input type="password" name="password" class="input" placeholder="Entrez votre mot de passe">

				        <label for="password_check">Confirmation mot de passe *</label>
				        <input type="password" name="password_check" class="input" placeholder="Confirmez votre mot de passe">

				        <label for="birthday">Date de naissance *</label>
				        <input type="date" name="birthday" class="input" autocomplete="on">

					</div>

					<div class="subImg">
						<img src="images/ester-exposito1.png" alt="ester-exposito1.png">
					</div>
					
				</div>
				
				<div class="checkbox">

					<div class="checkboxPart1">
						<p>
							Vos renseignements personnels seront utilisés par DUPEZ et le groupe LES SILENCIEUX (gestionnaire du site) afin d'améliorer la navigation du site Web, d'accélérer le processus d'achat, de vous garantir un accès à des espaces réservés, de vous offrir les services de la newsletter (sur demande) et en général d'améliorer la qualité de service que nous vous offrons.

							DUPEZ et le groupe LES SILENCIEUX conservent vos renseignements personnels.

							Veuillez consulter la Politique de Confidentialité pour plus d'informations.
						</p>
					</div>

                    <?php $true = true; ?>
					<div class="checkboxPart2">
						<div class="checkbox-position">
							<input type="checkbox" id="autorisation1" name="autorisation_newsletter" value="<?php echo $true ?>">
							<label for="autorisation1" class="autorisation1">
								Je souhaite recevoir par email des newsletters, des promotions personnalisées, des informations ainsi que de la communication par courrier de DUPEZ. 
								J’autorise DUPEZ et le groupe LES SILENCIEUX (gestionnaire du site) à traiter mes données personnelles à cette fin.
							</label>
						</div>
						<div class="checkbox-position">
							<input type="checkbox" id="autorisation2" name="autorisation_rgpd" value="<?php echo $true ?>">
							<label for="autorisation2"> 
								J'autorise DUPEZ et le groupe LES SILENCIEUX (gestionnaire du site) à collecter mes renseignements personnels afin de créer le profil de mes habitudes d'achat.
							</label>
						</div>

					</div>
					
				</div>

				<div class="inscription-button">
					<input type="submit" name="submit" class="subscrib-button" value="S'INSCRIRE">
				</div>

			</form>
			

		</section>

		
	</main>
	<footer>
		<?php include("includes/footer.php")?>
	</footer>
	
	<script type="text/javascript" src="js/modal.js"></script>
    <script type="text/javascript" src="js/autocompletion.js"></script>
</body>
</html>

<?php ob_end_flush();?>


