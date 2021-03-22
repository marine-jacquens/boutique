<?php
	ob_start();
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
	<header>
		<?php include("includes/header.php")?>
	</header>
	<main>
		<?php if(isset($_GET['search'])) {?>

		<section class="search_page">

			<h1>Résultat(s) de votre recherche : </h1>

			<?php

			// Récupère la recherche
			$recherche = isset($_GET['search']) ? $_GET['search'] : '';

			// la requete mysql
			$q = $connexion_db->prepare("SELECT * FROM products WHERE product_name LIKE '%$recherche%' OR description LIKE '%$recherche%'LIMIT 10");
			$q->execute();
			$search_results = $q->fetchAll(PDO::FETCH_ASSOC);

			if(!empty($search_results)) {

				// affichage du résultat
				foreach($search_results as $r){

					//RECUPERATION CATEGORIES TAILLE COULEUR
					$id_product = $r['id_product'];
					$get_size_product = $connexion_db->prepare(" SELECT product_details.*,stock_products.* FROM product_details, stock_products WHERE product_details.id_product = $id_product AND product_details.id_product_detail  = stock_products.id_product_detail AND stock_products.stock > 0  ");
					$get_size_product->execute();
					$get_size = $get_size_product->fetchAll(PDO::FETCH_ASSOC);

					$get_color_product = $connexion_db->prepare(" SELECT * FROM product_details WHERE id_product = $id_product ");
					$get_color_product->execute();
					$get_color = $get_color_product->fetch(PDO::FETCH_ASSOC);

					$get_categories = $connexion_db->prepare("SELECT categories.*,sub_categories.*,sub_categories_2.*,products.* FROM categories,sub_categories,sub_categories_2,products WHERE products.id_product = $id_product AND products.id_sub_category_2 = sub_categories_2.id_sub_category_2 AND sub_categories_2.id_sub_category = sub_categories.id_sub_category AND sub_categories_2.id_category = categories.id_category  ");

					$get_categories->execute();
					$categories_info = $get_categories->fetch(PDO::FETCH_ASSOC);

					?>
					<a href="product_page.php?prod=<?php echo $r['id_product'] ?>">
					<div class="search_results">
						<div class="info_result_product">
							<h3 class="search_result"> <?php echo $r['product_name'] ?></h3> 
							<p><?php echo $r['description'] ?></p>
							<p>A retrouver dans : <?php echo $categories_info['name_category']?> / <?php echo $categories_info['name_sub_category'] ?> / <?php echo $categories_info['name_sub_category_2']?></p>
							<p>Couleur : <?php echo $get_color['color'] ?></p>
							<p>Tailles disponibles : <?php foreach($get_size AS $available_size){ echo $available_size['size'].' ' ;} $get_size_product->closeCursor();?></p>
						</div>
						<div class="image_result_product">
							<img src=" <?php echo $r['picture'] ?> " alt="<?php echo $r['product_name'] ?>">
						</div>
					</div>	
					</a>
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
    <script type="text/javascript" src="js/autocompletion.js"></script>
</body>
</html>

