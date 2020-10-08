<?php
	require 'class/database.php';
	require 'class/users.php';
	$db = new Database();
	$user = new Users($db);

	if (isset($_POST["deconnexion"])) {
    $user->disconnect();
}
?>

<section class="top-nav1">

	<a href="">REJOIGNEZ LA #TEAMDUPEZ POUR CONNAITRE LES DERNIERES ACTUALITES DE LA MARQUE</a>

</section>

<section class="top-nav2">

	<div class="sales">
		<a href=""><i class="fal fa-map-marker-alt"></i> Nos points de vente</a>
	</div>
	<div class="logo">
		<img src="images/logo.png" alt="logo">
	</div>
	<div class="icones">
		<a href=""><i class="fal fa-search"></i></a>
		<?php 
			if(isset($_SESSION['user'])){
				?><a href=""><i class="fas fa-user"></i></a><?php
			}else{
				?><a href=""><i class="fal fa-user"></i></a><?php
			}
		?>
		<a href=""><i class="fal fa-heart"></i></a>
		<a href=""><i class="fal fa-shopping-bag"></i></a>
	</div>

</section>

<section>

	<nav class="navbar">
		<ul>
			<li>FEMME</li>
			<li>HOMME</li>
			<li>ENFANT</li>
			<li>NOUVEAUTE</li>
			<li>TAPIS ROUGE</li>
			<li>LES COULISSES</li>
		</ul>
	</nav>

</section>