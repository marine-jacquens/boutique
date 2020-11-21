<div class="message_perso">
	<p>
		<strong>Bonjour <?php echo $_SESSION['user']['firstname'] ?></strong> ,<br><br>

		Bienvenue sur votre page d'administration.<br>
		Vous avez la possibilité de personnaliser ici votre site internet grâce aux différents panneaux de contrôle. Vous pouvez ainsi créer, modifier et supprimer des articles ; avoir accès aux informations utilisateurs et suivre le processus de livraison de vos produits.
	</p>
	<?php 
		if(isset($_POST['submit_deconnexion']))
		{
			$user->disconnect();
		}
	?>
	<form action="" method="post">
		<input type="submit" name="submit_deconnexion" value="Se déconnecter"class="submit_deconnexion">
	</form>
</div>

<div class="profil_menu">
	<a href="admin.php#admin">ADMINISTRATION GÉNÉRALE</a>
	<a href="stock_management.php#stock_management">LES ARTICLES</a>
	<a href="">LES COMMANDES</a>
	<a href="account_management.php#account_management">LES INFORMATIONS UTILISATEURS</a>
</div>
