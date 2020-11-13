<?php
ob_start();
session_start();
?>

<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
	<title>Boutique - Page produits</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=image">
    <link rel="shortcut icon" type="image/x-icon" href="images/logo.png">
    <link rel="stylesheet" href="fontawesome/all.css">
    <link rel="stylesheet" href="css/general.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/category.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200&display=swap" rel="stylesheet">
</head>
<body>
	<header>
		<?php include("includes/header.php")?>
	</header>
    <main>
        <?php 
        
            $id_category = $_GET['cat'];
            $id_sub_category = $_GET['sub_cat'];
            $id_sub_category_2 = $_GET['sub_cat_2'];

            $get_products_per_sub_category_2 = $connexion_db->prepare("SELECT DISTINCT

            categories.id_category,
            categories.name_category,

            sub_categories.id_sub_category,
            sub_categories.name_sub_category,

            sub_categories_2.id_sub_category_2,
            sub_categories_2.id_category,
            sub_categories_2.id_sub_category,
            sub_categories_2.name_sub_category_2,
            sub_categories_2.description_sub_category_2,

            products.id_product,
            products.id_sub_category_2,
            products.product_name,
            products.picture,
            products.price,

            product_details.id_product,
            product_details.color

            FROM 

            products, categories, sub_categories, sub_categories_2, product_details

            WHERE 

            products.id_sub_category_2 = sub_categories_2.id_sub_category_2
            AND sub_categories_2.id_category =  $id_category
            AND sub_categories_2.id_sub_category =  $id_sub_category
            AND sub_categories_2.id_sub_category_2 =  $id_sub_category_2
            AND categories.id_category = sub_categories_2.id_category
            AND sub_categories.id_sub_category = sub_categories_2.id_sub_category
            AND products.id_product = product_details.id_product

            ");

            $get_products_per_sub_category_2->execute();
            $all_products = $get_products_per_sub_category_2->fetchAll(PDO::FETCH_ASSOC);

            /*var_dump($all_products);*/

        if(!empty($all_products[0])){?>

            <section>
                <div class="breadcrumb_line">
                    <ul>
                        <li><a href="index.php">accueil </a>/</li>
                        <li><a href="category.php?cat=<?php echo $id_category ?>"><?php echo $all_products[0]['name_category']?></a> /</li>
                        <li><a href="sub_category.php?cat=<?php echo $id_category?>&amp;sub_cat=<?php echo $id_sub_category?>"><?php echo $all_products[0]['name_sub_category'] ?></a> /</li>
                        <li><strong><?php echo $all_products[0]['name_sub_category_2'] ?></strong></li>
                    </ul>
                </div>
                <div class="description_category">
                    <div class="text_background">
                        <h1><?php echo $all_products[0]['name_sub_category_2']  ?></h1>
                        <p>
                            <?php echo $all_products[0]['description_sub_category_2']?>
                        </p>
                    </div>
                </div>
            </section>

            <section class="products">
                <?php foreach($all_products as $info_products){ ?>
                <div class="products_card">
                    <div>
                        <img src="<?php echo $info_products['picture'] ?>" width="300">
                    </div>
                    <div class="info_products">
                        <div class="title_cart">
                            <h3><?php echo $info_products['product_name'] ?></h3>
                            <i class="fal fa-heart"></i>
                        </div>
                        <p>€ <?php echo $info_products['price'] ?></p>
                        <p>Couleur : <?php echo $info_products['color'] ?></p>
                    </div>
                    
                    
                    
                </div>
                <?php } ?>
            </section>


        <?php } else { echo"<h1 class='building_page'>Oops sorry, page en construction...</h1>";} ?>

        
    </main>
    <footer>
        <?php include("includes/footer.php")?>
    </footer>
    <script type="text/javascript" src="js/modal.js"></script>
    <script type="text/javascript" src="js/wish_heart.js"></script>
</body>
</html>
<?php ob_end_flush();?>