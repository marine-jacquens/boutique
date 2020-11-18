<?php
	ob_start();
	session_start();
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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200&display=swap" rel="stylesheet">
</head>
<body>
	<header>
		<?php include("includes/header.php")?>
	</header>
	<main>
		<?php

			$saved_for_later = true;


			//RECUPERER LE PANIER 
			$get_cart = $connexion_db->prepare(" SELECT DISTINCT 
				cart_items.id_user,
				cart_items.id_product_detail,
				cart_items.quantity,
				cart_items.saved_for_later, 

				products.id_product, 
				products.product_name,
				products.picture, 
				products.price,
				product_details.id_product_detail,
				product_details.id_product,
				product_details.color, 
				product_details.size

				FROM cart_items,products,product_details 

				WHERE 

				cart_items.id_user = $id_user AND 
				cart_items.saved_for_later = $saved_for_later AND 
				cart_items.id_product_detail = product_details.id_product_detail AND 
				products.id_product = product_details.id_product ORDER BY time_added DESC ");

			$get_cart->execute();
			$cart = $get_cart->fetchAll(PDO::FETCH_ASSOC);

			//MODIFIER LA QUANTITE
			if(isset($_POST['cart_update'])){$cart->update($_POST['quantity'],$_POST['id_user'],$_POST['id_product_detail']);}

			foreach($cart as $info_cart){
				echo $info_cart['picture'].'</br>';
				echo $info_cart['product_name'].'</br>';
				echo $info_cart['price'].'</br>';
				echo $info_cart['color'].'</br>';
				echo $info_cart['size'].'</br>';
				echo $info_cart['quantity'].'</br>';

			?>
				<form action="" method="POST">
			        <input type="number" name="quantity" min="1" max="<?php echo $info_cart['stock'] ?>" value="<?php echo $cart_items_detail['quantity']; ?>">
			        <input type="hidden" name="id_user" value="<? echo $id_user ?>">
			        <input type="hidden" name="id_product_detail" value="<? echo $info_cart['id_product_detail'] ?>">
			        <input type="submit" name="cart_update" value="Modifier quantité">
			    </form><br/> 

			<?php }

		?>
	</main>
	<footer>
		<?php include("includes/footer.php")?>
	</footer>
	<script type="text/javascript" src="js/modal.js"></script>
</body>
</html>

<?php ob_end_flush();?>