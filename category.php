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

            $get_products_per_category = $connexion_db->prepare("SELECT DISTINCT

            categories.id_category,
            categories.name_category,
            categories.description_category,

            sub_categories_2.id_category,
            sub_categories_2.id_sub_category_2,

            products.id_product,
            products.id_sub_category_2,
            products.product_name,
            products.picture,
            products.price,

            product_details.id_product,
            product_details.color

            FROM 

            products, categories, sub_categories_2, product_details

            WHERE 

            products.id_sub_category_2 = sub_categories_2.id_sub_category_2
            AND sub_categories_2.id_category =  $id_category
            AND categories.id_category = sub_categories_2.id_category
            AND products.id_product = product_details.id_product

            ");

            $get_products_per_category->execute();
            $all_products = $get_products_per_category->fetchAll(PDO::FETCH_ASSOC);

       

        if(!empty($all_products[0])){?>
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
        
        <?php 
            //ENVOI FORMULAIRE WISH LIST
            if(isset($_POST['add_wish_list'])){
            $wish->register($_POST['id_product'],$_POST['id_user']);
            }

            if(isset($_POST['remove_wish_list'])){
            $wish->update($_POST['id_product'],$_POST['id_user']);
            }

        ?>

        <section class="products">
            <?php foreach($all_products as $info_products){ ?>
            <div class="products_card">
                <div>
                    <img src="<?php echo $info_products['picture'] ?>" width="300">
                </div>
                <div class="info_products">
                    <div class="title_cart">
                        <h3><?php echo $info_products['product_name'] ?></h3>
                       
                            <?php 

                                if(isset($_SESSION['user']['id_user'])){

                                    //VERIFICATION WISH LIST UTILISATEUR PLEINE OU VIDE
                                    $id_user = $_SESSION['user']['id_user'];
                                    $id_product = $info_products['id_product'];

                                    $get_wish_list = $connexion_db->prepare("SELECT * FROM wish_list_items WHERE id_user = $id_user AND id_product = $id_product ");
                                    $get_wish_list->execute();
                                    $wish_list = $get_wish_list->fetch(PDO::FETCH_ASSOC);

                                    if(!empty($wish_list)){

                                        if($wish_list['saved_for_later'] == true){?>

                                            <form action="" method="POST">

                                            <button type="submit" name="remove_wish_list" class="wish_button" id="fas_heart" ></button>
                                            <input type="hidden" name="id_product" value="<?php echo $info_products['id_product'] ?>">
                                            <input type="hidden" name="id_user" value="<?php echo $_SESSION['user']['id_user']?>">

                                            </form>


                                  <?php }
                                        else{ ?>

                                            <form action="" method="POST">

                                            <button type="submit" name="add_wish_list" class="wish_button" id="fa_heart" ></button>
                                            <input type="hidden" name="id_product" value="<?php echo $info_products['id_product'] ?>">
                                            <input type="hidden" name="id_user" value="<?php echo $_SESSION['user']['id_user'] ?>">

                                            </form>
                                      <?php }        

                                    }
                                    elseif(empty($wish_list)){?>

                                    <form action="" method="POST">

                                        <button type="submit" name="add_wish_list" class="wish_button" id="fa_heart" ></button>
                                        <input type="hidden" name="id_product" value="<?php echo $info_products['id_product'] ?>">
                                        <input type="hidden" name="id_user" value="<?php echo $_SESSION['user']['id_user'] ?>">

                                    </form>

                              <?php }

                                }
                                else{?>

                                    <form action="" method="POST">

                                        <button type="submit" name="add_wish_list" class="wish_button" id="fa_heart" ></button>
                                        <input type="hidden" name="id_product" value="<?php echo $info_products['id_product'] ?>">

                                    </form>

                          <?php } ?>
                    </div>
                    <p>€ <?php echo $info_products['price'] ?></p>
                    <p>Couleur : <?php echo $info_products['color'] ?></p>
                </div>
                
                
                
            </div>
            <?php } ?>
        </section>
        <?php }else { echo"<h1 class='building_page'>Oops sorry, page en construction...</h1>";} ?>
    </main>
    <footer>
        <?php include("includes/footer.php")?>
    </footer>
    
    <script type="text/javascript" src="js/modal.js"></script>
    <script type="text/javascript" src="js/wish_heart.js"></script>
</body>
</html>
<?php ob_end_flush();?>