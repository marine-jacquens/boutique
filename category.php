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
            $connexion_db = $db->connectDb();

            $id_category = $_GET['cat'];
            $size_1 = 'S';
            $size_2 = 'unique';
            

            //selection de : nom produit, photo, prix, taille, couleur. Pour récupérer les détails j'ai besoin de l'id du produit dans detail produit, pour récupérer la catégorie du produit j'ai besoin de l'id sous catégorie dans produit et ensuite de l'id catégorie qui correspond à la sous catégorie dans product
            $get_products_category = $connexion_db->prepare("SELECT 

                  
            products.id_product,
            product_details.id_product, 
            products.id_category,
            products.id_sub_category,

            products.product_name,
            products.picture,
            products.price, 
            product_details.size, 
            product_details.color, 

            categories.name_category,
            categories.description_category
            
              
            FROM 

            products, product_details, categories

            WHERE 
            products.id_category = $id_category
            AND categories.id_category = $id_category
            AND products.id_product = product_details.id_product 
            AND product_details.size = '$size_1'



            ");

            $get_products_category->execute();
            $all_products = $get_products_category->fetchAll(PDO::FETCH_ASSOC);

            /*var_dump($all_products);*/
        ?>
        <section>
            <div class="breadcrumb_line">
                <ul>
                    <li><a href="index.php">accueil </a>/</li>
                    <li><strong><?php echo $all_products[0]['name_category'] ?></strong></li>
                </ul>
            </div>
            <div class="description_category">
                <div class="text_background">
                    <h1>inspirations <?php echo $all_products[0]['name_category'] ?></h1>
                    <p>
                        <?php echo $all_products[0]['description_category']?>
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
        
    </main>
    <footer>
        <?php include("includes/footer.php")?>
    </footer>
    
    <script type="text/javascript" src="js/modal.js"></script>
</body>
</html>
<?php ob_end_flush();?>