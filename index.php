<?php
	ob_start();
?>

<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
	<title>Boutique - Accueil</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=image">
    <link rel="shortcut icon" type="image/x-icon" href="images/logo.png">
    <link rel="stylesheet" href="fontawesome/all.css">
    <link rel="stylesheet" href="css/general.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/index.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200&display=swap" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://js.stripe.com/v3/"></script>
    
</head>
<body>
	<header>
		<?php include("includes/header.php")?>
	</header>
	<main>
		<section class="banner_home">
			<a href="sub_category_2.php?cat=1&sub_cat=4&sub_cat_2=34"><h1 class="title_banner_home">DECONTRACT' FACON ESTER EXPOSITO</h1></a>
		</section>
		<div class="recommendation">
			<section class="recommendation_1">
				<div class="recommendation_title"><h2>LES KARDASHIAN</h2></div>
				<div class="recommendation_1_product">
					<?php 

						$recherche = 'kardashian';
						//SELECTION DES ARTICLES RELATIFS AUX KARDASHIAN
						$get_products = $connexion_db->prepare(" SELECT * FROM products WHERE product_name LIKE '%$recherche%' OR description LIKE '%$recherche%' LIMIT 0,3 ");
						$get_products->execute();

						while($products = $get_products->fetch(PDO::FETCH_ASSOC)){
					?>
					<div class="card_recommendation">
						<div class="card_recommendation_picture">
							<a href="product_page.php?prod=<?php echo $products['id_product'] ?>">
								<img src="<?php echo $products['picture']?>" alt="<?php echo $products['picture']?>" width="300">
							</a>
						</div>
						<h3><?php echo $products['product_name']?></h3>
						<p>€ <?php echo $products['price']?></p>
						<div class="recommendation_button_item"><a href="product_page.php?prod=<?php echo $products['id_product'] ?>">VOIR L'ARTICLE</a></div>
						
					</div>
					<?php } $get_products->closeCursor();?>
				</div>
			</section>
		</div>
		<section class="recommendation_2">
				<div class="recommendation_2_picture">
					<img src="images/jodie_comer.png" alt="jodie_comer.png" height="500" class="product_picture">
					<?php 
						$id_product = 112;
						//SELECTION DES ARTICLES RELATIFS AUX KARDASHIAN
						$get_product = $connexion_db->prepare(" SELECT * FROM products WHERE id_product = $id_product ");
						$get_product->execute();
						$product = $get_product->fetch(PDO::FETCH_ASSOC);
					?>
					<a href="product_page.php?prod=<?php echo $product['id_product'] ?>" class="linked_item"> + </a>
				</div>
				<div class="recommendation_2_text">
					<h2>Flirtez avec le danger façon Villanelle</h2>
					<img src="images/killing_eve_logo.png" alt="killing_eve_logo.png" width="100">
					<p>
						Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
					</p>
					<a href="sub_category_2.php?cat=1&sub_cat=1&sub_cat_2=2">DÉCOUVRIR</a>
				</div>
			</section>
			<section class="recommendation_3">
				<div class="recommendation_3_text">
					<h2>Rafraichissez votre automne à la manière d'Emily</h2>
					<img src="images/Emily_In_Paris_(Logo).jpg" alt="Emily_In_Paris_(Logo).jpg" width="100">
					<p>
						Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
					</p>
					<a href="sub_category_2.php?cat=1&sub_cat=1&sub_cat_2=2">DÉCOUVRIR</a>
				</div>
				<div class="recommendation_3_picture">
					<img src="images/Emily-in-Paris-Lily-Collins-Ashley-Park-river.png" alt="Emily-in-Paris-Lily-Collins-Ashley-Park-river.png" height="500" class="product_picture">
					<?php 
						$id_product = 113;
						//SELECTION DES ARTICLES RELATIFS AUX KARDASHIAN
						$get_product = $connexion_db->prepare(" SELECT * FROM products WHERE id_product = $id_product ");
						$get_product->execute();
						$product = $get_product->fetch(PDO::FETCH_ASSOC);
					?>
					<a href="product_page.php?prod=<?php echo $product['id_product'] ?>" class="linked_item"> + </a>
				</div>
			</section>
		<?php include("includes/banner_delivery.php")?>
	</main>
	<footer>
		<?php include("includes/footer.php")?>
	</footer>
	<script type="text/javascript" src="js/modal.js"></script>
</body>
</html>

<?php ob_end_flush();?>