<div class="message_perso">
	<p>
		<strong>Bonjour <?php echo $_SESSION['user']['firstname'] ?></strong> ,<br><br>

		Bienvenue sur votre Compte.<br>
		Personnalisez votre expérience d'achat sur dupez.com. Sur cet espace, vous pouvez modifier vos données personnelles et vos préférences, suivre vos commandes et découvrir les promotions qui vous sont spécialement réservées.
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
	<a href="profil.php#detail_account">MON PROFIL</a>
	<a href="wish_list.php?id_user=<?php echo $id_user ?>#detail_wishlist">MES ENVIES</a>
	<!-- <a href="bills_delivery.php#detail_bill_del">MES INFOS FACTURATION ET LIVRAISON</a> -->
	<a href="order.php#detail_order">MES COMMANDES</a>
</div>
<div class="bar">
	<div class="progression-bar">
	</div>
</div>