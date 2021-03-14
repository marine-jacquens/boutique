<?php

	$connexion_db = $db->connectDb();	

	$get_categories_bis = $connexion_db->prepare("SELECT DISTINCT categories.id_category, UPPER(categories.name_category) AS cat_maj, sub_categories_2.id_category FROM categories, sub_categories_2 WHERE categories.id_category = sub_categories_2.id_category");
	$get_categories_bis->execute();

	while($categories = $get_categories_bis->fetch()){ 

		$id_category = $categories['id_category'];
		$name_category = $categories['cat_maj'];

		//RECUPERATION DES SOUS CATEGORIES 
		$get_sub_categories = $connexion_db->prepare("SELECT DISTINCT UPPER(sub_categories.name_sub_category) AS sub_cat_maj,sub_categories.id_sub_category,sub_categories_2.id_sub_category FROM sub_categories,sub_categories_2 WHERE id_category = $id_category AND sub_categories.id_sub_category = sub_categories_2.id_sub_category ORDER BY sub_categories.id_sub_category" );
		
		$get_sub_categories->execute();


?>
		<aside id="cat-<?php echo $id_category ; ?>-modal" class="modal_menu" aria-hidden="true" role="dialog" aria-labelledby="titlemodal" style="display: none;">

			<div class="modal-wrapper_menu js-modal-stop">

				<div class="menu_title"><h3><a href="category.php?cat=<?php echo $id_category; ?>">INSPIRATION <?php echo $name_category; ?> </a></h3></div>

				<div class="close-btn"><button class="js-modal-close"><i class="fal fa-times"></i></button></div>
										
				<div class="modal_table_menu">

					<?php
												
						while($sub_categories = $get_sub_categories->fetch()){
						$id_sub_category = $sub_categories['id_sub_category'];
						$name_sub_category = $sub_categories['sub_cat_maj'];

						$get_sub_categories_2 = $connexion_db->prepare("SELECT * FROM sub_categories_2 WHERE id_category = $id_category AND id_sub_category = $id_sub_category");
						$get_sub_categories_2->execute();

					?>

						<table class="table_menu">
							<thead>
								<tr>
									<th><a href="sub_category.php?cat=<?php echo $id_category?>&amp;sub_cat=<?php echo $id_sub_category ?>"><?php echo $name_sub_category; ?></a></th>
								</tr>
												
							</thead>
							<tbody>
								<?php 
									while($sub_categories_2 = $get_sub_categories_2->fetch()){
										$id_sub_category_2 = $sub_categories_2['id_sub_category_2'];
										$name_sub_category_2 = $sub_categories_2['name_sub_category_2'];	    		
								?>
										<tr>
											<td><a href="sub_category_2.php?cat=<?php echo $id_category?>&amp;sub_cat=<?php echo $id_sub_category?>&amp;sub_cat_2=<?php echo $id_sub_category_2; ?>"><?php echo $name_sub_category_2; ?></a></td>
										</tr>
										<?php } $get_sub_categories_2->closeCursor(); ?>
							</tbody>
						</table>
					<?php } $get_sub_categories->closeCursor(); ?>
				</div>
			</div>
		</aside>
	<?php } $get_categories_bis->closeCursor();?>
				    	

				    	







