<?php
	require 'class/database.php';
	require 'class/users.php';
	require 'class/products.php';
	require 'class/administration.php';
	$db = new Database();
	$user = new Users($db);
	$product = new Products($db);
	$admin = new Admin($db);
	require 'modals_icones.php';
	require 'modals_menu.php';

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
			<?php } ?>
		
		<a href="#wish-modal" class="js-modal" id="fa-heart"></a>
		<a href="" id="fa-shopping-bag"></a>
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

