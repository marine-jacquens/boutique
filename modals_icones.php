<aside id="connexion-modal" class="modal" aria-hidden="true" role="dialog" aria-labelledby="titlemodal" style="display: none;">

	<div class="modal-wrapper js-modal-stop">
		
		<div class="close-btn"><button class="js-modal-close"><i class="fal fa-times"></i></button></div>
		
			<?php 

				

				if(isset($_SESSION['user']['id_user']))
				{ 
					if(isset($_POST['submit_deconnexion']))
					{
						$user->disconnect();
					}

				?>
					<div class="personal_space">
						<h1>Bonjour <?php echo $_SESSION['user']['firstname'] ?></h1>

						<table class="table_personal_space">
							<thead>
								<tr>
									<th>Mon profil</th>
									<th>Ma liste d'envies</th>
									<th>Mes info facturation et livraison</th>
									<th>Mes commandes</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td><a href="profil.php"><i class="fas fa-address-card"></i></a></td>
									<td><a href="wish_list.php"><i class="fal fa-heart"></i></a></td>
									<td><a href="bills_delivery.php"><i class="fad fa-credit-card-front"></i></a></td>
									<td><a href="order.php"><i class="fad fa-truck-loading"></i></a></td>
								</tr>
							</tbody>
						</table>

						<form action="" method="post">
							<input type="submit" name="submit_deconnexion" value="Se déconnecter"class="submit_deconnexion">
						</form>
					</div>
					
					<?php	
				}
				else
				{ 
					?>

					<form action="" method="post" class="connexion-form">

						<?php

							if(isset($_POST['submit_connexion']))
							{

								$user->connect(
									$_POST['mail'],
									$_POST['password']
								);
							}

						?>
				
						<h1>Mon compte</h1>
					
						<p>Identifiez-vous avec votre e-mail et votre mot de passe.</p>

						<p>Champs obligatoires*</p>
							
						<label for="mail">Adresse mail*</label>
						<input type="text" name="mail" class="mail" placeholder=""><br>
							
						<label for="password">Mot de passe* (8 - 15 CARACTÈRES)</label>
						<input type="password" name="password" class="password" placeholder=""><br>
						
						<a href="" class="forgotten-password">Mot de passe oublié ?</a><br>
					
					    <input type="submit" name="submit_connexion" class="identification" value="S'IDENTIFIER">

					    <p>ou Créez votre compte personnel pour une expérience de shopping exclusive.</p>

					    <a href="inscription.php" class="subscribe">S'INSCRIRE</a>

					</form>

			<?php } ?>
		
	</div>
	
</aside>

<aside id="wish-modal" class="modal" aria-hidden="true" role="dialog" aria-labelledby="titlemodal" style="display: none;">

	<div class="modal-wrapper js-modal-stop">

		<div class="close-btn"><button class="js-modal-close"><i class="fal fa-times"></i></button></div>
			
			<div class="empty-wish">
				<h1>Ma liste d'envies</h1>
				<p>Votre Wish List est actuellement vide.</p>
			</div>

	</div>
	
</aside>


<aside id="search-modal" class="modal" aria-hidden="true" role="dialog" aria-labelledby="titlemodal" style="display: none;">

	<div class="modal-wrapper js-modal-stop">

		<div class="close-btn"><button class="js-modal-close"><i class="fal fa-times"></i></button></div>
			
		<div class="search-title">
			<h1>Rechercher</h1>
		</div>

		<div class="search-console">
			<article class="product-suggestion">
				<h2>ARTICLES RECOMMANDÉS</h2>
				<div class="product-description">
					<div class="article">
						<img src="images/Benedetta_Porcaroli.jpg" alt="Benedetta_Porcaroli" height="200">
						<p>Nom produit</p>
						<p>Description</p>
						<p>Prix</p>
					</div>
					<div class="article">
						<img src="images/Alice_Pagani.png" alt="Alice_Pagani" height="200">
						<p>Nom produit</p>
						<p>Description</p>
						<p>Prix</p>
					</div>
					<div class="article">
						<img src="images/Lorenzo_Zurzolo.jpg" alt="Lorenzo_Zurzolo" height="200">
						<p>Nom produit</p>
						<p>Description</p>
						<p>Prix</p>
					</div>
				</div>
			</article>
			<div class="search-form">
				<form action="" method="post">
					<input type="search" name="search" class="search" placeholder="Tapez votre recherche">
					<button type="submit" class="search-button"><i class="fal fa-search"></i></button>
				</form>
			</div>		
		</div>
	</div>
	
</aside>