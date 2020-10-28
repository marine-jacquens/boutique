<section class="footer">
	<div class="newsletter_footer">
		<div class="paragraphe_newsletter">
			<h2>REJOIGNEZ LA #TEAMDUPEZ</h2>
			<p>
				Inscrivez-vous pour découvrir les nouveautés, vous tenir au courant des dernières tendances et être au courant des promotions exclusives.<br><br>Bénéficiez également d’une remise de 10 % sur votre prochaine commande.<br><br><span>*</span>Champs obligatoires
			</p>
		</div>
		<div class="picture_newsletter">
			<img src="images/Lorenzo_Zurzolo_footer.png" alt="Lorenzo_Zurzolo_footer.png">
		</div>
	</div>
	<div>
		<?php 
			if(isset($_POST['submit_mail_button'])){
				$user->newsletterNoSubscriber($_POST['mail_noSubscriber']);
			}

		?>
		<form action="" method="post" class="form_newsletter">
			<div><label for="mail">Adresse email<span>*</span></label></div>
			<div>
				<input type="email" name="mail_noSubscriber" class="mail_newsletter">
				<button type="submit" name="submit_mail_button" class="submit_mail_button"><i class="fal fa-long-arrow-right"></i></button>
			</div>
		</form>
	</div>
	<div class="footer_table">
		<table>
			<thead>
				<tr>
					<th colspan="1" class="delivery_places">LIEU DE LIVRAISON</th>
					<th colspan="2" class="delivery_track">NOS SERVICES</th>
					<th colspan="2" class="about_us">L'ENTREPRISE</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td colspan="1" class="delivery_places">
						<ul class="place_list_footer">
							<li>France</li>
						</ul>
					</td>
					<td colspan="1" class="delivery_track_part">
							<ul class="place_list_footer">
								<li>Suivre votre commande</li>
								<li>Livraisons</li>
								<li>Retours</li>
							</ul>
					</td>
					<td colspan="1" class="delivery_track_part">
						<ul class="place_list_footer">
							<li>Contactez-nous</li>
							<li>Informations sur l'article</li>
						</ul>
					</td>
					<td colspan="1" class="about_us_part">
						<ul class="place_list_footer">
							<li>À propos de nous</li>
							<li>Carrières</li>
							<li>Plan du site</li>
						</ul>
					</td>
					<td colspan="1" class="about_us_part">
						<ul class="place_list_footer">
							<li>Mentions légales</li>
							<li>Politique de confidentialité</li>
						</ul>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
	<div class="footer_rs">
		<h4>SUIVEZ-NOUS</h4>
		<div class="network_line">
			<a href="https://www.instagram.com/"><i class="fab fa-instagram-square"></i></a>
			<a href="https://www.facebook.com/"><i class="fab fa-facebook-square"></i></a>
			<a href="https://www.twitter.com/"><i class="fab fa-twitter-square"></i></a>
			<a href="https://www.youtube.com/"><i class="fab fa-youtube"></i></a>
		</div>
	</div>
	<div class="footer_end">
		<div class="logo_footer"><img src="images/logo.png" alt="logo_dupez" width="150"></div>
		<div class="payment_copyright">
			<p>PAIEMENTS SÉCURISÉS TRUSTWAVE - GEOTRUST - POSSIBILITE DE PAIEMENT PAR...</p>
			<p>
				Propulsé par la marque DUPEZ - <a href="#">Copyright © 2020 GROUPE LES SILENCIEUX - Tous droits réservés - Informations au sujet du vendeur</a>  - Photographie retouchée
			</p>
		</div>
	</div>
</section>
