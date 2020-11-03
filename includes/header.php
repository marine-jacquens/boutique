<?php
	require 'class/database.php';
	require 'class/users.php';
	require 'class/products.php';
	$db = new Database();
	$user = new Users($db);
	$product = new Products($db);
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
				<a href="admin.php" id="fa-toolbox"></a>
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
			<li><a href="#women-modal" class="js-modal">FEMME</a></li>
			<li><a href="#men-modal" class="js-modal">HOMME</a></li>
			<li><a href="#child-modal" class="js-modal">ENFANT</a></li>
			<li><a href="new_features.php">NOUVEAUTÉS</a></li>
			<li><a href="about_us.php">LES COULISSES</a></li>
		</ul>
	</nav>

</section>

