<?php

					$connexion_db = $db->connectDb();	
									
/*					$get_all_categories_info = $connexion_db->prepare("SELECT

					categories.id_category,
					sub_categories.id_sub_category,
					sub_categories_2.id_sub_category_2,
					sub_categories_2.id_category,
					sub_categories_2.id_sub_category,

					UPPER(categories.name_category) AS categorie_maj,
					UPPER(sub_categories.name_sub_category) AS sub_categorie_maj,
					sub_categories_2.name_sub_category_2
					
					FROM categories,sub_categories,sub_categories_2 

					WHERE 
					sub_categories_2.id_category = categories.id_category
					AND sub_categories_2.id_sub_category = sub_categories.id_sub_category

					");*/

					$get_nb_categories = $connexion_db->prepare("SELECT COUNT(DISTINCT id_category) AS nb_categorie, COUNT(DISTINCT id_sub_category) AS nb_sub_categorie FROM sub_categories_2");
				    $get_nb_categories->execute();

				    

				    /*while($donnees = $get_all_categories_info->fetch()){*/


?>


<aside id="cat-1-modal" class="modal_menu" aria-hidden="true" role="dialog" aria-labelledby="titlemodal" style="display: none;">

	<div class="modal-wrapper_menu js-modal-stop">

		<div class="close-btn"><button class="js-modal-close"><i class="fal fa-times"></i></button></div>
			
			<div class="modal_women_menu">

				<?php /*var_dump($get_all_categories_info->fetch())*/  ?>

				<table class="table_menu">
					<thead>
						<tr>
							<th><a href="category.php?cat=<?php ?>">INSPIRATION <?php /*echo $donnees['categorie_maj']*/ ?> </a></th>
						</tr>
						<tr>
							<th><a href="sub_category.php?sub_cat=5"><?php /*echo $donnees['sub_categorie_maj']*/ ?></a></th>
						</tr>
						
					</thead>
					<tbody>
						<tr>
							<td>Les Kardashian</td>
							<td>Romance</td>
							<td>Romance</td>
							<td>Queen B</td>
						</tr>
						<tr>
							<td>Les Jenner</td>
							<td>Comédie</td>
							<td>Comédie</td>
							<td>S.Gomez</td>
						</tr>
						<tr>
							<td>Enjoy Phoenix</td>
							<td>Action</td>
							<td>Action</td>
							<td>H.Kiyoko</td>
						</tr>
					</tbody>
				</table>
			</div>
	</div>
</aside>
<?php /*} $get_all_categories_info->closeCursor();*/ ?>
<aside id="cat-2-modal" class="modal_menu" aria-hidden="true" role="dialog" aria-labelledby="titlemodal" style="display: none;">

	<div class="modal-wrapper_menu js-modal-stop">

		<div class="close-btn"><button class="js-modal-close"><i class="fal fa-times"></i></button></div>
			
			<div class="modal_women_menu">
				<table class="table_menu">
					<thead>
						<tr><th><a href="category.php?cat=">INSPIRATION</a></th></tr>
						<tr>
							<th><a href="sub_category.php?sub_cat=5">AUTOMNE</a></th>
							<th><a href="sub_category.php?sub_cat=6">HIVERS</a></th>
							<th><a href="sub_category.php?sub_cat=7">PRINTEMPS</a></th>
							<th><a href="sub_category.php?sub_cat=8">ÉTÉ</a></th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>Les Kardashian</td>
							<td>Romance</td>
							<td>Romance</td>
							<td>Queen B</td>
						</tr>
						<tr>
							<td>Les Jenner</td>
							<td>Comédie</td>
							<td>Comédie</td>
							<td>S.Gomez</td>
						</tr>
						<tr>
							<td>Enjoy Phoenix</td>
							<td>Action</td>
							<td>Action</td>
							<td>H.Kiyoko</td>
						</tr>
					</tbody>
				</table>
			</div>
	</div>
</aside>

<aside id="cat-3-modal" class="modal_menu" aria-hidden="true" role="dialog" aria-labelledby="titlemodal" style="display: none;">

	<div class="modal-wrapper_menu js-modal-stop">

		<div class="close-btn"><button class="js-modal-close"><i class="fal fa-times"></i></button></div>
			
			<div class="modal_women_menu">
				<table class="table_menu">
					<thead>
						<tr><th><a href="category.php?cat=<?php?>">INSPIRATION <?php?></a></th></tr>
						<tr>
							<th><a href="sub_category.php?sub_cat=9">AUTOMNE</a></th>
							<th><a href="sub_category.php?sub_cat=10">HIVERS</a></th>
							<th><a href="sub_category.php?sub_cat=11">PRINTEMPS</a></th>
							<th><a href="sub_category.php?sub_cat=12">ÉTÉ</a></th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>Les Kardashian</td>
							<td>Romance</td>
							<td>Romance</td>
							<td>Queen B</td>
						</tr>
						<tr>
							<td>Les Jenner</td>
							<td>Comédie</td>
							<td>Comédie</td>
							<td>S.Gomez</td>
						</tr>
						<tr>
							<td>Enjoy Phoenix</td>
							<td>Action</td>
							<td>Action</td>
							<td>H.Kiyoko</td>
						</tr>
					</tbody>
				</table>
			</div>
	</div>
</aside>

