<?php

					$connexion_db = $db->connectDb();

					$get_sub_categories_2 = $connexion_db->prepare("SELECT

					categories.id_category,
					sub_categories.id_sub_category,

					sub_categories_2.name_sub_category_2,
					sub_categories_2.description_sub_category_2,
					categories.name_category,
					categories.description_category,
					sub_categories.name_sub_category,
					sub_categories.description_sub_category
					
					FROM categories,sub_categories,sub_categories_2 

					WHERE sub_categories_2.id_category = 1
					AND sub_categories_2.id_category = categories.id_category
					AND sub_categories_2.id_sub_category = sub_categories.id_sub_category

					");

				    $get_sub_categories_2->execute();
				    $sub_categories_2 = $get_sub_categories_2->fetchAll(PDO::FETCH_ASSOC);




?>

<aside id="women-modal" class="modal_menu" aria-hidden="true" role="dialog" aria-labelledby="titlemodal" style="display: none;">

	<div class="modal-wrapper_menu js-modal-stop">

		<div class="close-btn"><button class="js-modal-close"><i class="fal fa-times"></i></button></div>
			
			<div class="modal_women_menu">



				<table class="table_menu">
					<thead>
						<tr>
							<?php 
								$get_category = $connexion_db->prepare("SELECT * FROM categories");
				    			$get_category->execute();
				    			$category = $get_category->fetchAll(PDO::FETCH_ASSOC);
							?>
							<th><a href="category.php?cat=<?php echo $category[0]['id_category'] ?>">INSPIRATION <?php echo $category[0]['name_category'] ?> </a></th>
						</tr>


						<tr>
							<th><a href="sub_category.php?sub_cat=5">AUTOMNE</a></th>
							<th><a href="sub_category.php?sub_cat=5">HIVER</a></th>
							<th><a href="sub_category.php?sub_cat=5">PRINTEMPS</a></th>
							<th><a href="sub_category.php?sub_cat=5">ÉTÉ</a></th>
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

<aside id="men-modal" class="modal_menu" aria-hidden="true" role="dialog" aria-labelledby="titlemodal" style="display: none;">

	<div class="modal-wrapper_menu js-modal-stop">

		<div class="close-btn"><button class="js-modal-close"><i class="fal fa-times"></i></button></div>
			
			<div class="modal_women_menu">
				<table class="table_menu">
					<thead>
						<tr><th><a href="category.php?cat=<?php echo $category[1]['id_category'] ?>">INSPIRATION <?php echo $category[1]['name_category'] ?></a></th></tr>
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

<aside id="child-modal" class="modal_menu" aria-hidden="true" role="dialog" aria-labelledby="titlemodal" style="display: none;">

	<div class="modal-wrapper_menu js-modal-stop">

		<div class="close-btn"><button class="js-modal-close"><i class="fal fa-times"></i></button></div>
			
			<div class="modal_women_menu">
				<table class="table_menu">
					<thead>
						<tr><th><a href="category.php?cat=<?php echo $category[2]['id_category'] ?>">INSPIRATION <?php echo $category[2]['name_category'] ?></a></th></tr>
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

