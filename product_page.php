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
        <link rel="stylesheet" href="css/product_page.css">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200&display=swap" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    </head>
    <body>
    <header>
        <?php include("includes/header.php") ?>
    </header>
    <main>
        <?php

        if (isset($_GET['prod'])) {

            $id_prod = $_GET['prod'];


            $get_info_product = $connexion_db->prepare(" SELECT categories.*,sub_categories.*,sub_categories_2.*,products.*,product_details.* FROM products, categories, sub_categories, sub_categories_2,product_details WHERE products.id_sub_category_2 = sub_categories_2.id_sub_category_2
	            AND sub_categories_2.id_category =  categories.id_category
	            AND sub_categories_2.id_sub_category =  sub_categories.id_sub_category
	            AND products.id_product = $id_prod
	            AND products.id_product = product_details.id_product ");

            $get_info_product->execute();
            $info_product = $get_info_product->fetch(PDO::FETCH_ASSOC);

            //ENVOI FORMULAIRE WISH LIST
            if (isset($_POST['add_wish_list'])) {
                $wish->register($_POST['id_product'], $_POST['id_user']);
            }

            if (isset($_POST['remove_wish_list'])) {
                $wish->update($_POST['id_product'], $_POST['id_user']);
            }


            ?>

            <section class="page_product">
                <div class="breadcrumb_line">
                    <ul>
                        <li>
                            <a href="category.php?cat=<?php echo $info_product['id_category'] ?>"><?php echo $info_product['name_category'] ?></a>
                            /
                        </li>

                        <li>
                            <a href="sub_category.php?cat=<?php echo $info_product['id_category'] ?>&amp;sub_cat=<?php echo $info_product['id_sub_category'] ?>"><?php echo $info_product['name_sub_category'] ?></a>
                            /
                        </li>

                        <li>
                            <a href="sub_category_2.php?cat=<?php echo $info_product['id_category'] ?>&amp;sub_cat=<?php echo $info_product['id_sub_category'] ?>&amp;sub_cat_2=<?php echo $info_product['id_sub_category_2'] ?>"><?php echo $info_product['name_sub_category_2'] ?></a>
                        </li>
                    </ul>
                </div>
                <div class="picture_details">
                    <div class="picture_product"><img src="<?php echo $info_product['picture'] ?>" alt="<?php echo $info_product['picture'] ?>"></div>
                    <div class="details">
                        <div class="title_heart">
                            <h3><?php echo $info_product['product_name'] ?></h3>
                            <?php

                            if (isset($_SESSION['user']['id_user'])) {

                                //VERIFICATION WISH LIST UTILISATEUR PLEINE OU VIDE
                                $id_user = $_SESSION['user']['id_user'];

                                $get_wish_list = $connexion_db->prepare("SELECT * FROM wish_list_items WHERE id_user = $id_user AND id_product = $id_prod ");
                                $get_wish_list->execute();
                                $wish_list = $get_wish_list->fetch(PDO::FETCH_ASSOC);

                                //SI ELLE EST PLEINE
                                if (!empty($wish_list)) {

                                    //ET SI L'OPTION SAUVEGARDE A VALEUR VRAI
                                    if ($wish_list['saved_for_later'] == true) {
                                        ?>

                                        <!-- COEUR NOIR REMPLI ET POSSIBILITE D'ENLEVER L'ITEM DE LA LISTE-->
                                        <form action="" method="POST">

                                            <button type="submit" name="remove_wish_list"
                                                    class="wish_button fas_heart"></button>
                                            <input type="hidden" name="id_product" value="<?php echo $id_prod ?>">
                                            <input type="hidden" name="id_user"
                                                   value="<?php echo $_SESSION['user']['id_user'] ?>">

                                        </form>


                                    <?php } //SI L'OPTION SAUVEGARDE A VALEUR FAUX REACTIVER L'ITEM EXISTANT DANS LA WISH LIST
                                    else { ?>

                                        <form action="" method="POST">

                                            <button type="submit" name="add_wish_list"
                                                    class="wish_button fa_heart"></button>
                                            <input type="hidden" name="id_product" value="<?php echo $id_prod ?>">
                                            <input type="hidden" name="id_user"
                                                   value="<?php echo $_SESSION['user']['id_user'] ?>">

                                        </form>
                                    <?php }

                                } //ET SI LA WISH LIST EST VIDE
                                elseif (empty($wish_list)) {
                                    ?>

                                    <!-- CREATION ET ACTIVATION DE L'ITEM DANS LA WISH LIST-->
                                    <form action="" method="POST">

                                        <button type="submit" name="add_wish_list"
                                                class="wish_button fa_heart"></button>
                                        <input type="hidden" name="id_product" value="<?php echo $id_prod ?>">
                                        <input type="hidden" name="id_user"
                                               value="<?php echo $_SESSION['user']['id_user'] ?>">

                                    </form>

                                <?php }


                            } ?>
                        </div>
                        <div class="price_color">
                            <p>€ <?php echo $info_product['price'] ?></p>
                            <h3>DESCRIPTION</h3>
                            <p><?php echo $info_product['description'] ?></p>
                            <h3>DETAILS</h3>
                            <p>Couleur : <?php echo $info_product['color'] ?></p>
                        </div>
                        <div class="size">
                            <?php

                            $get_size_product = $connexion_db->prepare(" SELECT product_details.*, stock_products.* FROM product_details, stock_products WHERE product_details.id_product = $id_prod AND product_details.id_product_detail  = stock_products.id_product_detail ");
                            $get_size_product->execute();
                            $get_size = $get_size_product->fetchAll(PDO::FETCH_ASSOC);

                            if (isset($_POST['add_cart'])) {
                                $cart->register($_POST['size'], $_POST['id_user']);
                            }

                            if (isset($_SESSION['user']['id_user'])) {
                                ?>


                                <form action="" method="POST">
                                    <div class="select_size">
                                        <p>Sélectionnez la taille : </p>
                                        <select name="size">
                                            <?php foreach ($get_size as $available_size) { ?>
                                                <option value="<?php echo $available_size['id_product_detail'] ?>" <?php if ($available_size['stock'] == 0) {
                                                    echo "disabled";
                                                } ?> ><?php echo $available_size['size'];
                                                    if ($available_size['stock'] == 0) {
                                                        echo " (indisponible)";
                                                    } ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="cart_button">
                                        <input type="hidden" name="id_user" value="<?php echo $id_user ?>">
                                        <input type="submit" name="add_cart" class="add_cart_button"
                                               value="AJOUTER AU PANIER">

                                    </div>

                                </form>
                            <?php } else {
                                echo " <br> Pensez à vous inscrire/connecter pour acheter nos produits ";
                            } ?>

                        </div>


                    </div>


                </div>

                <div class="delivery">
                    <div class="delivery_terms">
                        <p>
                            <strong>LIVRAISONS & RETOURS</strong></p></br>

                        Livraison standard </br>
                        GRATUIT</br>
                        Livraison dans un délai de 4-6 jours ouvrables
                        Les jours ouvrés sont du lundi au vendredi, exceptés les jours fériés. Les commandes sont
                        expédiées depuis l'Italie.
                        Nous vous offrons les frais de port pour le retour de vos articles qui est à effectuer sous 14
                        jours francs à compter de la date de livraison de votre commande.


                        Découvrez tous les détails des livraisons et retours dans la section <a href="#">Service
                            clients</a>

                        <img src="images/emballage.png" alt="emballage_cadeau" class="delivery_picture">
                        </p>
                    </div>
                </div>


            </section>

            <?php

            $id_sub_cat_2 = $info_product['id_sub_category_2'];
            //RECUPERATION DES PRODUITS SIMILAIRES
            $get_similar_products = $connexion_db->prepare(" SELECT DISTINCT 

			            sub_categories_2.id_sub_category_2,

			            products.id_product,
			            products.id_sub_category_2,
			            products.product_name,
			            products.picture,
			            products.price,

			            product_details.id_product,
			            product_details.color

			            FROM 

			            products,sub_categories_2, product_details

			            WHERE  

			            sub_categories_2.id_sub_category_2 = $id_sub_cat_2 AND 
			            products.id_sub_category_2 = sub_categories_2.id_sub_category_2 AND
			            products.id_product != $id_prod AND 
			            products.id_product = product_details.id_product 

			            LIMIT 0,3
			            ");
            $get_similar_products->execute();
            $similar_products = $get_similar_products->fetchAll(PDO::FETCH_ASSOC);

            if (!empty($similar_products)) {
                ?>

                <section class="similar_products">
                    <h3>VOUS AIMEREZ AUSSI</h3>
                    <div class="products_suggestion">
                        <?php foreach ($similar_products as $suggestion) { ?>
                            <div class="product_card">
                                <div class="product_card_pic"><img src="<?php echo $suggestion['picture'] ?>" alt="<?php echo $suggestion['picture'] ?>"></div>
                                <h4><?php echo $suggestion['product_name'] ?></h4>
                                <div class="infoProduct">
                                    <p>€ <?php echo $suggestion['price'] ?></p>
                                    <p>Couleur : <?php echo $suggestion['color'] ?></p>
                                </div>
                                <a href="product_page.php?prod=<?php echo $suggestion['id_product'] ?>"
                                   class="see_item">VOIR L'ARTICLE</a>
                            </div>
                        <?php } ?>
                    </div>
                </section>

            <?php } ?>

            <section class="banner_delivery">

                <div class="banner_delivery_section">
                    <i class="fal fa-truck"></i>
                    <p>LIVRAISON STANDARD</p>
                </div>
                <div class="banner_delivery_section">
                    <i class="fal fa-tags"></i>
                    <p>LES DERNIERES TENDANCES A PETIT PRIX</p>
                </div>
                <div class="banner_delivery_section">
                    <i class="fal fa-unlock-alt"></i>
                    <p>PAIEMENT SECURISE</p>
                </div>
                <div class="banner_delivery_section">
                    <i class="fal fa-gift"></i>
                    <p>EMBALLAGE OFFERT</p>
                </div>

            </section>


        <?php } else {
            header('Location:index.php');
        } ?>

    </main>
    <footer>
        <?php include("includes/footer.php") ?>
    </footer>
    <script type="text/javascript" src="js/modal.js"></script>
    <script type="text/javascript" src="js/autocompletion.js"></script>
    </body>
    </html>

<?php ob_end_flush(); ?>