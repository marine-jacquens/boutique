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
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/personal_space_head_page.css">
    <link rel="stylesheet" href="css/order.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200&display=swap" rel="stylesheet">
</head>
<body>
	<header>
		<?php include("includes/header.php")?>
	</header>
	<main>
		<section class="banner">
		</section>

		<section class="profil" id="detail_order">

			<?php include("includes/personal_space_head_page.php"); ?>
			<div class="profil_page_head">
				<p>
					<strong>DÉTAILS DU COMPTE</strong> <br><br>

					Enregistrez les informations de votre compte, ajoutez-en de nouvelles et modifiez-les au besoin.<br><br>

					Champs obligatoires<span>*</span>
				</p>
			</div>
		</section>
	</main>
	<footer>
		<?php include("includes/footer.php")?>
	</footer>
	<script type="text/javascript" src="js/modal.js"></script>
</body>
</html>