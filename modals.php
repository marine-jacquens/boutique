<aside id="connexion-modal" class="modal" aria-hidden="true" role="dialog" aria-labelledby="titlemodal" style="display: none;">

	<div class="modal-wrapper js-modal-stop">
		<?php 
			if(isset($_POST['submit']))
			{
				$user->connect(
					$_POST['mail'],
					$_POST['password']
				);
			}
		?>

		<div class="close-btn"><button class="js-modal-close"><i class="fal fa-times"></i></button></div>
		

		<form action="" method="post" class="connexion-form">
			
			<h1 id="titlemodal"><strong>Mon compte</strong></h1>
		
			<p>Identifiez-vous avec votre e-mail et votre mot de passe.</p>

		
				<p>Champs obligatoires*</p>
				
				
					<label for="mail">Adresse mail*</label>
			    	<input type="text" name="mail" class="mail" placeholder=""><br>
				
				
					<label for="password">Mot de passe* (8 - 15 CARACTÈRES)</label>
			    	<input type="password" name="password" class="password" placeholder=""><br>
			
			
				

				<a href="" class="forgotten-password">Mot de passe oublié ?</a><br>
		
			

		    <input type="submit" name="submit" class="identification" value="S'IDENTIFIER">

		    <p>ou Créez votre compte personnel pour une expérience de shopping exclusive.</p>

		    <a href="inscription.php" class="subscribe">S'INSCRIRE</a>

		</form>

	</div>
	
</aside>


<aside id="wish-modal" class="modal" aria-hidden="true" role="dialog" aria-labelledby="titlemodal" style="display: none;">

	<div class="modal-wrapper js-modal-stop">

		<div class="close-btn"><button class="js-modal-close"><i class="fal fa-times"></i></button></div>
			
			<div class="empty-wish">
				<h1 id="titlemodal"><strong>Ma liste d'envies</strong></h1>
				<p>Votre Wish List est actuellement vide.</p>
			</div>

	</div>
	
</aside>


<aside id="search-modal" class="modal" aria-hidden="true" role="dialog" aria-labelledby="titlemodal" style="display: none;">

	<div class="modal-wrapper js-modal-stop">

		<div class="close-btn"><button class="js-modal-close"><i class="fal fa-times"></i></button></div>
			
		<div class="search-title">
			<h1 id="titlemodal"><strong>Rechercher</strong></h1>
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