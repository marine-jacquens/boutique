<?php
	ob_start();
	session_start();
?>

<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
	<title>Boutique - Accueil</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=image">
    <link rel="shortcut icon" type="image/x-icon" href="images/logo.png">
    <link rel="stylesheet" href="fontawesome/all.css">
    <link rel="stylesheet" href="css/general.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/search.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200&display=swap" rel="stylesheet">
</head>
<body>
	<header>
		<?php include("includes/header.php")?>
	</header>
	<main>
		<?php if(isset($_POST['search'])) {?>

		<section class="search_page">

			<h1>Résultat(s) de votre recherche : </h1>

			<?php

			// Récupère la recherche
			$recherche = isset($_POST['search']) ? $_POST['search'] : '';

			// la requete mysql
			$q = $connexion_db->prepare("SELECT DISTINCT 
				

				categories.id_category,
				categories.name_category,

				sub_categories.id_sub_category,
				sub_categories.name_sub_category,

				sub_categories_2.id_sub_category_2, 
				sub_categories_2.id_category,
				sub_categories_2.id_sub_category,
				sub_categories_2.name_sub_category_2,

				products.id_product, 
				products.id_sub_category_2, 
				products.product_name, 
				products.picture, 
				products.description, 
				products.price, 

				product_details.id_product, 
				product_details.color

				FROM products,categories,sub_categories,sub_categories_2,product_details 

				WHERE

				categories.id_category = sub_categories_2.id_category  AND 
				sub_categories.id_sub_category = sub_categories_2.id_sub_category AND
				sub_categories_2.id_sub_category_2 = products.id_sub_category_2 AND
				products.id_product = product_details.id_product AND

				products.product_name LIKE '%$recherche%' OR 
				products.description LIKE '%$recherche%'

				 LIMIT 10");

			$q->execute();
			$search_results = $q->fetchAll(PDO::FETCH_ASSOC);

			if(!empty($search_results)) {

				// affichage du résultat
				foreach($search_results as $r){

					$id_product = $r['id_product'];
					$get_size_product = $connexion_db->prepare(" SELECT product_details.id_product_detail,product_details.id_product,product_details.size, stock_products.id_product_detail, stock_products.stock FROM product_details, stock_products WHERE product_details.id_product = $id_product AND product_details.id_product_detail  = stock_products.id_product_detail AND stock_products.stock > 0  ");
					$get_size_product->execute();
					$get_size = $get_size_product->fetchAll(PDO::FETCH_ASSOC);


					?>

					<div class="search_results">
						<div class="info_result_product">
							<h3 class="search_result"> <?php echo $r['product_name'] ?></h3> 
							<p><?php echo $r['description'] ?></p>
							<p>A retrouver dans : <?php echo $r['name_category']?> / <?php echo $r['name_sub_category'] ?> / <?php echo $r['name_sub_category_2']?></p>
							<p>Couleur : <?php echo $r['color'] ?></p>
							<p>Tailles disponibles : <?php foreach($get_size AS $available_size ){ echo $available_size['size'].' ' ;} $get_size_product->closeCursor();?> </p>
						</div>
						<div class="image_result_product">
							<img src=" <?php echo $r['picture'] ?> " alt="<?php echo $r['product_name'] ?>"><br>
						</div>
					</div>	

				<?php }

			}else{

				echo "<h1>Oops votre recherche n'a rien donné</h1>";

				} ?>
			

			
			
		</section>
		
		<?php }else{ header('Location:index.php'); } ?>
	</main>
	<footer>
		<?php include("includes/footer.php")?>
	</footer>
	<script type="text/javascript" src="js/modal.js"></script>
</body>
</html>

