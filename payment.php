<?php
	ob_start();
	session_start();
?>

<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
	<title>Boutique - Paiement</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=image">
    <link rel="shortcut icon" type="image/x-icon" href="images/logo.png">
    <link rel="stylesheet" href="fontawesome/all.css">
    <link rel="stylesheet" href="css/general.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/payment.css">
    <link rel="stylesheet" href="css/footer.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200&display=swap" rel="stylesheet">
</head>
<body>
	<header>
		<?php include("includes/header.php")?>
	</header>
	<main>

		<?php if(isset($_SESSION['user']['id_user'])){ ?>

			<section class="payment_page">
				<div class="info_delivery">
					<form method="POST" action="payment.php#payment">
						<div class="form_position_name">
							<h3>Civilité</h3>
							<div class="lastname_firstname">
								<div class="name_position">
									<label for="lastname">Nom</label>
									<input type="text" name="lastname" placeholder="<?php echo $_SESSION['user']['lastname'] ?>" required>
								</div>	
								<div class="name_position">
									<label for="firstname">Prénom</label>
									<input type="text" name="firstname" placeholder="<?php echo $_SESSION['user']['firstname'] ?>" required>
								</div>						
							</div>
						</div>
						
						<div class="form_position_part">
							<h3>Adresse de livraison</h3>
							<label for="delivery_address">Adresse</label>
							<input type="text" name="delivery_address" placeholder="21 cours Mirabeau" required>

							<label for="delivery_postcode">Code postal</label>
							<input type="number" name="delivery_postcode" placeholder="13100" required>
							
							<label for="delivery_city">Ville</label>
							<input type="text" name="delivery_city" placeholder="Aix-en-Provence" required>

							<label for="delivery_country">Pays</label>
							<input type="text" name="delivery_country" placeholder="France" required>
						</div>
						<div class="form_position_part">
							<h3>Adresse de facturation</h3>
							<label for="bill_address">Adresse</label>
							<input type="text" name="bill_address" placeholder="21 cours Mirabeau" required>

							<label for="bill_postcode">Code postal</label>
							<input type="number" name="bill_postcode" placeholder="13100" required>
							
							<label for="bill_city">Ville</label>
							<input type="text" name="bill_city" placeholder="Aix-en-Provence" required>

							<label for="bill_country">Pays</label>
							<input type="text" name="bill_country" placeholder="France" required>
						</div>
						<div class="form_position_part">
							<h3>Coordonnées</h3>
							<label for="mail">Mail</label>
							<input type="email" name="mail" placeholder="<?php echo $_SESSION['user']['mail'] ?>" required>
							<label for="phone">Numéro de téléphone</label>
							<input type="text" name="phone" placeholder="<?php echo $_SESSION['user']['phone'] ?>" required>
						</div>
						<div>
							<input type="submit" name="register_delivery" value="CONFIRMER SES INFORMATIONS" class="button_info_delivery">
						</div>
					</form>
				</div>
				<div class="info_payment">
					<div class="cart_items_modify">
						<?php 
						//COUNT NBR D'ITEMS DANS LE PANIER
						$saved_for_later = true;
						$get_item_number = $connexion_db->prepare("SELECT COUNT(*) AS item_count FROM cart_items WHERE id_user = $id_user AND saved_for_later = $saved_for_later");
						$get_item_number->execute();
						$item_number = $get_item_number->fetch(PDO::FETCH_ASSOC);

						?>
						<p><strong>Panier </strong>(<?php if($item_number['item_count'] > 1){echo $item_number['item_count'].' articles';}else{echo $item_number['item_count'].' article';}?>)</p>
						<a href="cart_items.php?id_user=<?php echo $id_user ?>" class="cart_modify_access"><i class="fal fa-pencil"></i> MODIFIER</a>
					</div>
					<?php 

						//RECUPERATION ARTICLE PANIER 
						$get_items = $connexion_db->prepare(" SELECT cart_items.*,products.*,product_details.* FROM cart_items,products,product_details WHERE product_details.id_product = products.id_product AND cart_items.id_product_detail = product_details.id_product_detail AND cart_items.id_user = $id_user AND cart_items.saved_for_later = $saved_for_later ORDER BY cart_items.time_added DESC ");
						$get_items->execute(); ?>
					<div class="list-items_frame">
						<?php while($items = $get_items->fetch()){?>
						<div class="list-items">
							
							<div class="payment_picture_product">
								<a href="product_page.php?prod=<?php echo $items['id_product'] ?>"><img src="<?php echo $items['picture'] ?>" alt="<?php echo $items['picture'] ?>" width="150"></a>
							</div>
							<div class="payment_info_product">
								<h3><?php echo $items['product_name'] ?></h3>	
								<p>€ <?php echo $items['price'] ?></p>
								<p>Taille : <?php echo $items['size'] ?></p>
								<p>Couleur : <?php echo $items['color'] ?></p>
								<p>Quantité : <?php echo $items['quantity'] ?></p>
								<?php
									//SI ON RETIRE UN ITEM DU PANIER
									if(isset($_POST['remove_cart'])){$cart->removeCart($_POST['id_product'],$_POST['id_user']);}
								?>
								<form action="" method="POST" class="remove_wish_cart cart_button">
			                    	<button type="submit" name="remove_cart"><i class="fal fa-trash-alt"></i> SUPPRIMER</button>
			                    	<input type="hidden" name="id_user" value="<?php echo $id_user ?>">
			                    	<input type="hidden" name="id_product" value="<?php echo $items['id_product_detail'] ?>">
			                    </form>							
							</div>
						</div>
						<?php }$get_items->closeCursor(); ?>
					</div>
					<div class="sous_total">
						<?php 

						//TOTAL PANIER
						$amount_cart = $connexion_db->prepare("SELECT DISTINCT products.*,cart_items.*,product_details.*,SUM(products.price*cart_items.quantity) AS total FROM products, product_details, cart_items WHERE cart_items.id_user = $id_user AND 
							cart_items.saved_for_later = $saved_for_later AND 
							products.id_product = product_details.id_product AND 
							product_details.id_product_detail = cart_items.id_product_detail ");
						$amount_cart->execute();
						$total = $amount_cart->fetch(PDO::FETCH_ASSOC);

						?>	
						<div class="calculation_detail">
							<div class="detail_price">
								<h4>SOUS TOTAL </h4>
								<p> € <?php echo $total['total'] ?></p>
							</div>
							<div class="detail_price">
								<div>
									<h4>MOYEN DE LIVRAISON</h4>
									<h5>Standard </br> Livraison dans un délai de 4-6 jours ouvrables</h5>
								</div>
								<div>
									<p>Gratuite</p>
								</div>
							</div>
							<div class="detail_price">
								<div>
									<h4>MOYEN DE PAIEMENT</h4>
									<h5>Carte de crédit</h5>
								</div>
								<div>
									<p>Gratuit</p>
								</div>
								
							</div>	
						</div>
						<div class="total_amount_line">
							<div class="detail_price">
								<h4>TOTAL</h4>
								<p> € <?php echo $total['total'] ?></p>
							</div>
						</div>
						
					</div>
					<?php
						if(isset($_POST['register_delivery'])){
							
						
						?>				
							<div class="payment_frame" id="payment">

								<form action="payment.php" method="POST" class="form_payment">

									<label for="cardholder_firstname">Prénom du titulaire*</label>
									<input type="text" name="cardholder_firstname" placeholder="<?php echo $_SESSION['user']['firstname'] ?>" required>

									<label for="cardholder_lastname">Nom du titulaire*</label>
									<input type="text" name="cardholder_lastname" placeholder="<?php echo $_SESSION['user']['lastname'] ?>" required>

									<label for="card_number">Numéro de carte*</label>
									<div class="credit_card">
										<input type="password" name="card_number" required>
										<i class="fab fa-cc-mastercard"></i>
										<i class="fab fa-cc-visa"></i>
									</div>
									
									<label for="card_validity">Date d'expiration*</label>
									<input type="date" name="card_validity" min="<?php echo date("Y-m-d")?>" required>

									<label for="CVC_number">Code de sécurité*</label>
									<input type="password" name="CVC_number" placeholder="CVC" required>

									<input type="hidden" name="id_user" value="<?php echo $_SESSION['user']['id_user'] ?>">
									<input type="hidden" name="lastname" value="<?php echo $_POST['lastname'] ?>">
									<input type="hidden" name="firstname" value="<?php echo $_POST['firstname'] ?>">
									<input type="hidden" name="bill_address" value="<?php echo $_POST['bill_address'] ?>">
									<input type="hidden" name="bill_postcode" value="<?php echo $_POST['bill_postcode'] ?>">
									<input type="hidden" name="bill_city" value="<?php echo $_POST['bill_city'] ?>">
									<input type="hidden" name="bill_country" value="<?php echo $_POST['bill_country'] ?>">
									<input type="hidden" name="delivery_address" value="<?php echo $_POST['delivery_address'] ?>">
									<input type="hidden" name="delivery_city" value="<?php echo $_POST['delivery_city'] ?>">
									<input type="hidden" name="delivery_country" value="<?php echo $_POST['delivery_country'] ?>">
									<input type="hidden" name="delivery_postcode" value="<?php echo $_POST['delivery_postcode'] ?>">
									<input type="hidden" name="mail" value="<?php echo $_POST['mail'] ?>">
									<input type="hidden" name="phone" value="<?php echo $_POST['phone'] ?>">
									<input type="hidden" name="amount" value="<?php echo $total['total'] ?>">

									<input type="submit" name="proceed_payment" value="CONFIRMER LE PAIEMENT" class="payment_button">

								</form>

							</div>
						<?php } 

							if(isset($_POST['proceed_payment'])){

								//VERIFICATION VALIDITE DU NUMERO DE LA CARTE LA CARTE
								if(preg_match("#^5[1-5]{3}([- ]?[0-9]{4}){3}$#", $_POST['card_number']) OR preg_match("#^4[0-9]{3}([- ]?[0-9]{4}){3}$#", $_POST['card_number'])){

									if(preg_match("#[0-9]{3}#", $_POST['CVC_number'])){

										$order->register(
											$_POST['id_user'],
											$_POST['lastname'], 
											$_POST['firstname'], 
											$_POST['bill_address'], 
											$_POST['bill_postcode'],
											$_POST['bill_city'], 
											$_POST['bill_country'],
											$_POST['delivery_address'], 
											$_POST['delivery_city'], 
											$_POST['delivery_country'],
											$_POST['delivery_postcode'],
											$_POST['phone'],
											$_POST['mail'],
											$_POST['amount']

										);





									}else{echo"<span>Le numéro de sécurité de votre carte est invalide</span>";}

								}else{echo "<span>Votre numéro de carte est invalide</span>";}

							}
							

						 ?>
					
					
				</div>
			</section>

	<?php }else{header('Location:index.php');} ?>
	</main>
	<footer>
		<?php include("includes/footer.php")?>
	</footer>
	<script type="text/javascript" src="js/modal.js"></script>
</body>
</html>

<?php ob_end_flush();?>