<?php
	ob_start();
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
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/personal_space_head_page.css">
    <link rel="stylesheet" href="css/wish_list.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200&display=swap" rel="stylesheet">
</head>
<body>
	<header>
		<?php include("includes/header.php")?>
	</header>
	<main>
		<section class="banner">
		</section>

		<section class="profil" id="detail_wishlist">

			<?php include("includes/personal_space_head_page.php"); ?>
			<div class="profil_page_head">
				<p>
					<strong>MES ARTICLES PRÉFÉRÉS</strong> <br><br>

					En sauvegardant des articles dans votre Wish List, vous recevrez des mises à jour sur leur disponibilité et pourrez les partager avec vos amis. Vous pouvez sauvegarder jusqu’à 50 articles et les ajouter à votre panier à tout moment.<br><br>

				</p>
			</div>
			<div class="wish_list">
				<i class="fas fa-heart"></i>
				<p>Votre Wish List est actuellement vide.</p>
			</div>
		</section>
	</main>
	<footer>
		<?php include("includes/footer.php")?>
	</footer>
	<script type="text/javascript" src="js/modal.js"></script>
</body>
</html>

<?php ob_end_flush();?>