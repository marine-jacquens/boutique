<?php
	require 'class/database.php';
	require 'class/users.php';
	require 'class/products.php';
	require 'class/administration.php';
	require 'class/wish_list.php';
	require 'class/cart.php';
	require 'class/orders.php';
	$db = new Database();
	$user = new Users($db);
	$product = new Products($db);
	$admin = new Admin($db);
	$wish = new WishList($db);
	$cart = new Cart($db);
	$order = new Orders($db);
	require 'modals_icones.php';
	require 'modals_menu.php';

	if(isset($_SESSION['user']['id_user'])){$id_user = $_SESSION['user']['id_user'];};

?>

<section class="top-nav1">
	<a href="">REJOIGNEZ LA #TEAMDUPEZ POUR CONNAITRE LES DERNIERES ACTUALITES DE LA MARQUE</a>

</section>

<section class="top-nav2">

	<div class="sales">
		<a href=""><i class="fal fa-map-marker-alt"></i> Nos points de vente</a>
	</div>
	<div class="logo">
		<a href="index.php"><img src="images/logo.png" alt="logo"></a>
	</div>
	<div class="icones">
		<a href="#search-modal" class="js-modal" id="fa-search"></a>
		<?php 
			if(isset($_SESSION['user']['id_user']) AND $_SESSION['user']['account_type'] == "normal")
			{ ?>
				<a href="#connexion-modal" class="js-modal" id="fas-fa-user"></a>
			  <?php
			}
			elseif(isset($_SESSION['user']['id_user']) AND $_SESSION['user']['account_type'] == "admin")
			{?>
				<a href="#connexion-modal" class="js-modal" id="fas-fa-user"></a>
				<a href="#admin-modal"  class="js-modal" id="fa-toolbox"></a>
			  <?php
			}
			else
			{ ?>
			<a href="#connexion-modal" class="js-modal" id="fa-user"></a>
			<?php } 

			//RECUPERATION WISH LIST
			if(isset($_SESSION['user']['id_user'])){

				$connexion_db = $db->connectDb();
				$id_user = $_SESSION['user']['id_user'];
				$saved_for_later = true;

				$get_wish_list = $connexion_db->prepare("SELECT * FROM wish_list_items WHERE id_user = $id_user AND saved_for_later = $saved_for_later ");
				$get_wish_list->execute();

				$get_cart_items = $connexion_db->prepare("SELECT * FROM cart_items WHERE id_user = $id_user AND saved_for_later = $saved_for_later ");
				$get_cart_items->execute();

				$get_nb_items_cart = $connexion_db->prepare(" SELECT COUNT(*) AS count FROM cart_items  WHERE id_user = $id_user AND saved_for_later = $saved_for_later");
				$get_nb_items_cart->execute();
				$nb_items_cart = $get_nb_items_cart->fetch(PDO::FETCH_ASSOC);

				if(!empty($get_wish_list->fetch(PDO::FETCH_ASSOC))){?>
					<a href="#wish-modal" class="js-modal" id="fas-fa-heart"></a>
				<?php }
				else{ ?> <a href="#wish-modal" class="js-modal" id="fa-heart"></a> <?php }

				if(!empty($get_cart_items->fetch(PDO::FETCH_ASSOC))){?>
					<a href="#cart-modal" class="js-modal" id="fas-shopping-bag"></a>
					<p class="cart_number"><?php echo $nb_items_cart['count']; ?></p>

				<?php } 
				else{?> <a href="cart_items.php" id="fa-shopping-bag"></a> <?php }
			} ?>
		
	</div>

</section>

<section>
	
	<nav class="navbar">
		<ul>
			<?php 

				$connexion_db = $db->connectDb();

                $get_categories = $connexion_db->prepare("SELECT id_category, UPPER(name_category) AS categorie_maj FROM categories");
                $get_categories->execute();

                while($info_cat = $get_categories->fetch()){
			?>
			<li><a href="#<?php echo "cat-". htmlspecialchars($info_cat['id_category']) ?>-modal" class="js-modal"><?php echo htmlspecialchars($info_cat['categorie_maj']) ?></a></li>
			<?php } $get_categories->closeCursor();?>
			<li><a href="new_features.php">NOUVEAUTÉS</a></li>
			<li><a href="about_us.php">LES COULISSES</a></li>
		</ul>
	</nav>

</section>

