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
    <link rel="stylesheet" href="css/wish_list.css">
    <link rel="stylesheet" href="css/cart_items.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200&display=swap" rel="stylesheet">
</head>
<body>
	<header>
		<?php include("includes/header.php")?>
	</header>
	<main>
		<?php

			if(isset($_SESSION['user']['id_user'])){

			$saved_for_later = true;


			//RECUPERER LE PANIER 
			$get_cart = $connexion_db->prepare(" SELECT DISTINCT cart_items.*, products.*,product_details.*,stock_products.*FROM cart_items,products,product_details,stock_products	WHERE 
				cart_items.id_user = $id_user AND 
				cart_items.saved_for_later = $saved_for_later AND 
				cart_items.id_product_detail = product_details.id_product_detail AND 
				products.id_product = product_details.id_product AND 
				product_details.id_product_detail = stock_products.id_product_detail ORDER BY time_added DESC ");

			$get_cart->execute();
			$cart_info = $get_cart->fetchAll(PDO::FETCH_ASSOC);

			//MODIFIER LA QUANTITE
			if(isset($_POST['cart_update'])){$cart->update($_POST['quantity'],$_POST['id_user'],$_POST['id_product_detail']);}

			?>

			<section class="wish_page section_cart">

				<div class="cart_head">
					<p>
						<strong>MES ARTICLES</strong> <br><br>

						En sauvegardant des articles dans votre panier, vous recevrez des mises à jour sur leur disponibilité et pourrez les partager avec vos amis. Vous pouvez sauvegarder jusqu’à 50 articles et les ajouter à votre panier à tout moment.<br><br>
					</p>

					<?php 
						if($nb_items['nb_items'] >= 1 ){?>
							<p>Votre panier comprend <?php echo '<strong>'.$nb_items['nb_items'].' </strong>' ; if($nb_items['nb_items'] > 1){echo"articles";}else{echo"article";} ?> </p>
						<?php }else { echo '<p>Votre panier est vide</p>'; } ?>


				</div>

				<?php foreach($cart_info as $info_cart){ ?>

					<div class="complete_wish_list">
						<div class="wish_cart_picture">
							<a href="product_page.php?prod=<?php echo $info_cart['id_product'] ?>"><img src="<?php echo $info_cart['picture'] ?>" alt="<?php echo $info_cart['picture'] ?>" width="300"></a>
						</div>
						<h3><?php echo $info_cart['product_name'] ?></h3>
						<p>€ <?php echo $info_cart['price'] ?></p>
						<div class="caracteristique">
							<p>Couleur : <?php echo $info_cart['color'] ?></p>
							<p>Taille : <?php echo $info_cart['size'] ?></p>
							<p>Quantité : <?php echo $info_cart['quantity'] ?></p>
						</div>
						<form action="" method="POST">
			        		<input type="number" name="quantity" min="1" max="<?php echo $info_cart['stock'] ?>" value="<?php echo $info_cart['quantity']; ?>" class="qt_nb">
			        		<input type="hidden" name="id_user" value="<?php echo $id_user ?>">
			        		<input type="hidden" name="id_product_detail" value="<?php echo $info_cart['id_product_detail'] ?>" >
			        		<input type="submit" name="cart_update" value="Mise à jour quantité" class="qt_modify">
			    		</form>
			    		<?php
							//SI ON RETIRE UN ITEM DU PANIER
							if(isset($_POST['remove_cart'])){$cart->removeCart($_POST['id_product'],$_POST['id_user']);}
						?>
			    		<form action="" method="POST" class="remove_wish_cart cart_button">
			                <button type="submit" name="remove_cart"><i class="fal fa-trash-alt"></i> SUPPRIMER</button>
			                <input type="hidden" name="id_user" value="<?php echo $id_user ?>">
			                <input type="hidden" name="id_product" value="<?php echo $info_cart['id_product_detail'] ?>">
			            </form>	

					</div>
				<?php } ?>

			</section>	
				 

			<?php } ?>
	</main>
	<footer>
		<?php include("includes/footer.php")?>
	</footer>
	<script type="text/javascript" src="js/modal.js"></script>
</body>
</html>

<?php ob_end_flush();?>