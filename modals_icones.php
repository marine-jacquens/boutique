<aside id="connexion-modal" class="modal" aria-hidden="true" role="dialog" aria-labelledby="titlemodal" style="display: none;">

	<div class="modal-wrapper js-modal-stop">
		
		<div class="close-btn close-btn-top"><button class="js-modal-close"><i class="fal fa-times"></i></button></div>
		
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

		<div class="close-btn close-btn-top"><button class="js-modal-close"><i class="fal fa-times"></i></button></div>
			
			<div class="empty-wish">
				<h1>Ma liste d'envies</h1>
				<?php 


					$connexion_db = $db->connectDb();

					//SI ON RETIRE UN ITEM DE LA WISH LIST
					if(isset($_POST['remove_wish_list'])){
		            $wish->update($_POST['id_product'],$_POST['id_user']);
		            }

		            //SI ON AJOUTE UN ITEM DE LA WISH LIST DANS LE PANIER
		            /*if(isset($_POST['add_cart'])){
		            $cart->update($_POST['id_product'],$_POST['id_user']);
		            }*/

					$id_user = $_SESSION['user']['id_user'];
					$saved_for_later = true;


					$get_wish_list = $connexion_db->prepare(" SELECT DISTINCT wish_list_items.id_user,wish_list_items.id_product,wish_list_items.saved_for_later, products.id_product, products.product_name,products.picture, products.price,product_details.id_product,product_details.color FROM wish_list_items,products,product_details WHERE wish_list_items.id_user = $id_user AND wish_list_items.saved_for_later = $saved_for_later AND wish_list_items.id_product =  products.id_product AND products.id_product = product_details.id_product ORDER BY time_added DESC LIMIT 0,3 ");
					$get_wish_list->execute();
					$wish_list = $get_wish_list->fetchAll(PDO::FETCH_ASSOC);

					$count_list_items = $connexion_db->prepare("SELECT COUNT(*) AS nb_items FROM wish_list_items WHERE id_user = $id_user AND saved_for_later = $saved_for_later");
					$count_list_items->execute();
					$items = $count_list_items->fetch(PDO::FETCH_ASSOC);

					if(!empty($wish_list[0])){ ?>

						<section class="wish_list_overview">
							<h3>Votre liste d'envies comprend <?php echo '<strong>'.$items['nb_items'].'</strong> '; if($items['nb_items'] > 1){echo"articles";}else{echo"article";} ?></h3>

							<?php if($items['nb_items'] > 3){ ?> <a href="wish_list.php">VOIR TOUS LES ARTICLES</a> <?php } ?>

							<div class="wish_list_products">

								<?php foreach($wish_list as $wish_list_detail){ ?>

									<div class="wish_list">
										<div class="wish_picture">
											<img src="<?php echo $wish_list_detail['picture']?>" alt="<?php echo $wish_list_detail['product_name']?>" width="150">
										</div>
										<h3><?php echo $wish_list_detail['product_name']?></h3>
										<p>€ <?php echo $wish_list_detail['price'] ?></p>
		                    			<p>Couleur : <?php echo $wish_list_detail['color'] ?></p>
		                    			<form action="" method="POST" class="remove_wish_list">
		                    				<button type="submit" name="remove_wish_list"><i class="fal fa-trash-alt"></i> SUPPRIMER</button>
		                    				<input type="hidden" name="id_user" value="<?php echo $id_user ?>">
		                    				<input type="hidden" name="id_product" value="<?php echo $wish_list_detail['id_product'] ?>">
		                    			</form>
		                    			<form action="" method="POST" class="add_cart">
		                    				<button type="submit" name="add_cart">AJOUTER AU PANIER</button>
		                    				<input type="hidden" name="id_product" value="<?php echo $wish_list_detail['id_product'] ?>">
		                    			</form>
									</div>

					 		   	<?php } ?>

					 		</div>
				 		</section>

			  <?php }
					
					else{ ?> 

					<p>Votre Wish List est actuellement vide.</p>

			  <?php } ?>

			

				
			</div>

	</div>
	
</aside>


<aside id="search-modal" class="modal" aria-hidden="true" role="dialog" aria-labelledby="titlemodal" style="display: none;">

	<div class="modal-wrapper js-modal-stop">

		<div class="close-btn close-btn-top"><button class="js-modal-close"><i class="fal fa-times"></i></button></div>
			
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

<aside id="admin-modal" class="modal" aria-hidden="true" role="dialog" aria-labelledby="titlemodal" style="display: none;">

	<div class="modal-wrapper js-modal-stop">

		<div class="close-btn close-btn-top"><button class="js-modal-close"><i class="fal fa-times"></i></button></div>
			
		<div class="personal_space">

			<h1>Bonjour <?php echo $_SESSION['user']['firstname'] ?></h1>

				<table class="table_personal_space">
					
					<thead>
						
						<tr>
							<th>Administration générale</th>
							<th>Les articles</th>
							<th>Les commandes</th>
							<th>Les informations utilisateurs</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td><a href="admin.php"><i class="fas fa-folder-open"></i></a></td>
							<td><a href="stock_management.php"><i class="fas fa-cart-plus"></i></a></td>
							<td><a href="orders_admin.php"><i class="fas fa-truck-loading"></i></a></td>
							<td><a href="users_admin.php"><i class="fas fa-users-cog"></i></a></td>
						</tr>
					</tbody>
				</table>

				<form action="" method="post">
					<input type="submit" name="submit_deconnexion" value="Se déconnecter"class="submit_deconnexion">
				</form>
		</div>
			


	</div>
	
</aside>