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
		<?php if(isset($_SESSION['user']['id_user'])) { ?>
		<section class="banner">
		</section>

		<?php 

		$id_user = $_GET['id_user'];

		//RECUPERATION WISH LIST
		$get_wish_list = $connexion_db->prepare(" SELECT DISTINCT wish_list_items.id_user,wish_list_items.id_product,wish_list_items.saved_for_later, products.id_product, products.product_name,products.picture, products.price,product_details.id_product,product_details.color FROM wish_list_items,products,product_details WHERE wish_list_items.id_user = $id_user AND wish_list_items.saved_for_later = $saved_for_later AND wish_list_items.id_product =  products.id_product AND products.id_product = product_details.id_product ORDER BY time_added DESC");
		$get_wish_list->execute();
		$wish_list = $get_wish_list->fetchAll(PDO::FETCH_ASSOC);

		//SI ON RETIRE UN ITEM DE LA WISH LIST
		if(isset($_POST['remove_wish_list'])){$wish->update($_POST['id_product'],$_POST['id_user']);}

		$saved_for_later = true;
		$count_list_items = $connexion_db->prepare("SELECT COUNT(*) AS nb_items FROM wish_list_items WHERE id_user = $id_user AND saved_for_later = $saved_for_later");
		$count_list_items->execute();
		$items = $count_list_items->fetch(PDO::FETCH_ASSOC);

		?>

		<section class="forme" id="detail_wishlist">

			<?php include("includes/personal_space_head_page.php"); ?>
			<div class="profil_page_head">
				<p>
					<strong>MES ARTICLES PRÉFÉRÉS</strong> <br><br>

					En sauvegardant des articles dans votre liste d'envies, vous recevrez des mises à jour sur leur disponibilité et pourrez les partager avec vos amis. Vous pouvez sauvegarder jusqu’à 50 articles et les ajouter à votre panier à tout moment.<br><br>
				</p>

				<?php 
					if($items['nb_items'] >= 1 ){?>
						<p>Votre liste d'envie comprend <?php echo '<strong>'.$items['nb_items'].' </strong>' ; if($items['nb_items'] > 1){echo"articles";}else{echo"article";} ?> </p>
					<?php }?>


			</div>

			<?php 
				if(!empty($wish_list)){ ?>

					<div class="wish_page">

					<?php foreach($wish_list AS $wish_list_detail){ ?>

						<div class="complete_wish_list">
							<div class="wish_cart_picture">
								<img src="<?php echo $wish_list_detail['picture']?>" alt="<?php echo $wish_list_detail['product_name']?>" width="300">
							</div>
							<h3><?php echo $wish_list_detail['product_name']?></h3>
							<p>€ <?php echo $wish_list_detail['price'] ?></p>
		                    <p>Couleur : <?php echo $wish_list_detail['color'] ?></p>
		                    <form action="" method="POST" class="remove_wish_list">
		                    	<button type="submit" name="remove_wish_list"><i class="fal fa-trash-alt"></i> SUPPRIMER</button>
		                    	<input type="hidden" name="id_user" value="<?php echo $id_user ?>">
		                    	<input type="hidden" name="id_product" value="<?php echo $wish_list_detail['id_product'] ?>">
		                    </form>
		                    <a href="product_page?prod=<?php echo $wish_list_detail['id_product'] ?>" class="see_item">VOIR L'ARTICLE</a>
						</div>

					<?php } ?>
					</div>
			<?php }	
				else{ ?>
					<div class="wish_list_empty">
						<i class="fas fa-heart"></i>
						<p>Votre liste d'envies est actuellement vide</p>
					</div>
				<?php } ?>
			
		</section>
	<?php } else {header('Location:index.php');exit;} ?>
	</main>
	<footer>
		<?php include("includes/footer.php")?>
	</footer>
	<script type="text/javascript" src="js/modal.js"></script>
</body>
</html>

<?php ob_end_flush();?>