<?php
ob_start();
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
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

            $all_products = $admin->getProductsBySubCategory2($id_category,$id_sub_category,$id_sub_category_2);

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
                        <a href="product_page.php?prod=<?php echo $info_products['id_product'] ?>"><img src="<?php echo $info_products['picture'] ?>" width="300"></a>
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

                                    //SI ELLE EST PLEINE
                                    if(!empty($wish_list)){

                                        //ET SI L'OPTION SAUVEGARDE A VALEUR VRAI
                                        if($wish_list['saved_for_later'] == true){?>

                                            <!-- COEUR NOIR REMPLI ET POSSIBILITE D'ENLEVER L'ITEM DE LA LISTE-->
                                            <form action="" method="POST">

                                                <button type="submit" name="remove_wish_list" class="wish_button fas_heart" ></button>
                                                <input type="hidden" name="id_product" value="<?php echo $info_products['id_product'] ?>">
                                                <input type="hidden" name="id_user" value="<?php echo $_SESSION['user']['id_user']?>">

                                            </form>


                                        <?php }

                                            //SI L'OPTION SAUVEGARDE A VALEUR FAUX REACTIVER L'ITEM EXISTENT DANS LA WISH LIST
                                            else{ ?>

                                                <form action="" method="POST">

                                                    <button type="submit" name="add_wish_list" class="wish_button fa_heart" ></button>
                                                    <input type="hidden" name="id_product" value="<?php echo $info_products['id_product'] ?>">
                                                    <input type="hidden" name="id_user" value="<?php echo $_SESSION['user']['id_user'] ?>">

                                                </form>
                                          <?php }        

                                        }
                                        //ET SI LA WISH LIST EST VIDE
                                        elseif(empty($wish_list)){?>

                                        <!-- CREATION ET ACTIVATION DE L'ITEM DANS LA WISH LIST-->
                                        <form action="" method="POST">

                                            <button type="submit" name="add_wish_list" class="wish_button fa_heart" ></button>
                                            <input type="hidden" name="id_product" value="<?php echo $info_products['id_product'] ?>">
                                            <input type="hidden" name="id_user" value="<?php echo $_SESSION['user']['id_user'] ?>">

                                        </form>

                                        <?php }


                                    }?>
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
    <script type="text/javascript" src="js/autocompletion.js"></script>
</body>
</html>
<?php ob_end_flush();?>