<aside id="connexion-modal" class="modal" aria-hidden="true" role="dialog" aria-labelledby="titlemodal"
       style="display: none;">

    <div class="modal-wrapper js-modal-stop">

        <div class="close-btn close-btn-top">
            <button class="js-modal-close"><i class="fal fa-times"></i></button>
        </div>

        <?php

        if (isset($_SESSION['user']['id_user'])) {
            $id_user = $_SESSION['user']['id_user'];
            if (isset($_POST['submit_deconnexion'])) {
                $user->disconnect();
            }

            ?>
            <div class="personal_space">
                <h1>Bonjour <?php echo $_SESSION['user']['firstname'] ?></h1>

                <table class="table_personal_space">
                    <thead>
                    <tr>
                        <th><a href="profil.php?id_user=<?php echo $id_user ?>">Mon profil</a></th>
                        <th><a href="wish_list.php?id_user=<?php echo $id_user ?>">Ma liste d'envies</a></th>
                        <!-- <th>Mes info facturation et livraison</th> -->
                        <th><a href="order.php?id_user=<?php echo $id_user ?>">Mes commandes</a></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td><a href="profil.php?id_user=<?php echo $id_user ?>"><i class="fas fa-address-card"></i></a>
                        </td>
                        <td><a href="wish_list.php?id_user=<?php echo $id_user ?>"><i class="fas fa-heart"></i></a></td>
                        <!-- <td><a href="bills_delivery.php"><i class="fad fa-credit-card-front"></i></a></td> -->
                        <td><a href="order.php?id_user=<?php echo $id_user ?>"><i class="fad fa-truck-loading"></i></a>
                        </td>
                    </tr>
                    </tbody>
                </table>

                <form action="" method="post">
                    <input type="submit" name="submit_deconnexion" value="Se déconnecter" class="submit_deconnexion">
                </form>
            </div>

            <?php
        } else {
            ?>

            <form action="" method="post" class="connexion-form">

                <?php

                if (isset($_POST['submit_connexion'])) {

                    $user->connect(
                        $_POST['mail'],
                        $_POST['password']
                    );
                }

                ?>

                <h1>Mon compte</h1>

                <p>Identifiez-vous avec votre e-mail et votre mot de passe.</p>

                <p>Champs obligatoires*</p>

                <label for="mail">Adresse mail*</label>
                <input type="text" name="mail" class="mail" placeholder=""><br>

                <label for="password">Mot de passe* (8 - 15 CARACTÈRES)</label>
                <input type="password" name="password" class="password" placeholder=""><br>

                <a href="" class="forgotten-password">Mot de passe oublié ?</a><br>

                <input type="submit" name="submit_connexion" class="identification" value="S'IDENTIFIER">

                <p>ou Créez votre compte personnel pour une expérience de shopping exclusive.</p>

                <a href="inscription.php" class="subscribe">S'INSCRIRE</a>

            </form>

        <?php } ?>

    </div>

</aside>

<aside id="wish-modal" class="modal" aria-hidden="true" role="dialog" aria-labelledby="titlemodal"
       style="display: none;">

    <div class="modal-wrapper js-modal-stop">

        <div class="close-btn close-btn-top">
            <button class="js-modal-close"><i class="fal fa-times"></i></button>
        </div>

        <div class="empty-wish">
            <h1>Aperçu des derniers articles ajoutés à la liste d'envies</h1>
            <?php


            $connexion_db = $db->connectDb();

            if (isset($_SESSION['user']['id_user'])) {

                //SI ON RETIRE UN ITEM DE LA WISH LIST
                if (isset($_POST['remove_wish_list'])) {
                    $wish->update($_POST['id_product'], $_POST['id_user']);
                }

                //SI ON AJOUTE UN ITEM DE LA WISH LIST DANS LE PANIER
                /*if(isset($_POST['add_cart'])){
                $cart->update($_POST['id_product'],$_POST['id_user']);
                }*/

                $saved_for_later = true;

                $get_wish_list = $connexion_db->prepare(" 
                SELECT DISTINCT wish_list_items.id_user,wish_list_items.time_added,wish_list_items.id_product,
                wish_list_items.saved_for_later, products.id_product, products.product_name,products.picture, 
                products.price,product_details.id_product,product_details.color 
                FROM wish_list_items,products,product_details 
                WHERE wish_list_items.id_user = ? 
                AND wish_list_items.saved_for_later = ? 
                AND wish_list_items.id_product =  products.id_product 
                AND products.id_product = product_details.id_product 
                ORDER BY time_added DESC LIMIT 0,3 ");
                $get_wish_list->execute([$id_user, $saved_for_later]);
                $wish_list_modals = $get_wish_list->fetchAll();

                $id_user = $_SESSION['user']['id_user'];

                $count_list_items = $connexion_db->prepare("SELECT COUNT(*) AS nb_items FROM wish_list_items WHERE id_user = $id_user AND saved_for_later = $saved_for_later");
                $count_list_items->execute();
                $items_number = $count_list_items->fetch(PDO::FETCH_ASSOC);

            }

            if (!empty($wish_list_modals[0])) { ?>

                <section class="wish_cart_overview">
                    <h3>Votre liste d'envies comprend <?php echo '<strong>' . $items_number['nb_items'] . '</strong> ';
                        if ($items_number['nb_items'] > 1) {
                            echo "articles";
                        } else {
                            echo "article";
                        } ?></h3>

                    <?php if ($items_number['nb_items'] > 3) { ?> <a href="wish_list.php?id_user=<?php echo $id_user ?>"
                                                                     class="linkWishItems">VOIR TOUS LES
                        ARTICLES</a> <?php } ?>

                    <div class="wish_cart_products">

                        <?php foreach ($wish_list_modals as $wish_list_detail) { ?>

                            <div class="wish_cart_list">

                                <div class="containerWish">

                                    <a href="product_page.php?prod=<?php echo $wish_list_detail['id_product'] ?>">
                                        <img src="<?php echo $wish_list_detail['picture'] ?>"
                                             alt="<?php echo $wish_list_detail['product_name'] ?>" class="imageWish">
                                    </a>
                                    <div class="middleWish">
                                        <a href="product_page.php?prod=<?php echo $wish_list_detail['id_product'] ?>"
                                           class="textWish">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </div>

                                </div>

                                <h4><?php echo $wish_list_detail['product_name'] ?></h4>
                                <div class="wishPriceColor">
                                    <p>€ <?php echo $wish_list_detail['price'] ?></p>
                                    <p>Couleur : <?php echo $wish_list_detail['color'] ?></p>
                                    <form action="" method="POST" class="remove_wish_cart">
                                        <button type="submit" name="remove_wish_list" class="miniDelete"><i
                                                    class="fal fa-trash-alt"></i></button>
                                        <input type="hidden" name="id_user" value="<?php echo $id_user ?>">
                                        <input type="hidden" name="id_product"
                                               value="<?php echo $wish_list_detail['id_product'] ?>">
                                    </form>
                                </div>


                            </div>

                        <?php } ?>

                    </div>
                </section>

            <?php } else { ?>

                <p>Votre liste d'envies est actuellement vide</p>

            <?php }

            ?>


        </div>

    </div>

</aside>

<aside id="cart-modal" class="modal" aria-hidden="true" role="dialog" aria-labelledby="titlemodal"
       style="display: none;">

    <div class="modal-wrapper js-modal-stop">

        <div class="close-btn close-btn-top">
            <button class="js-modal-close"><i class="fal fa-times"></i></button>
        </div>

        <div class="empty-wish">
            <h1>Aperçu des derniers articles ajoutés au panier</h1>
            <?php

            $connexion_db = $db->connectDb();

            if (isset($_SESSION['user']['id_user'])) {

                $id_user = $_SESSION['user']['id_user'];

                //SI ON RETIRE UN ITEM DU PANIER
                if (isset($_POST['remove_cart'])) {
                    $cart->removeCart($_POST['id_product'], $_POST['id_user']);
                }

                //RECUPERATION DU PANIER

                $saved_for_later_modals = true;

                $get_cart_items_modals = $connexion_db->prepare(" SELECT DISTINCT cart_items.*,products.*,product_details.*, stock_products.* FROM cart_items,products,product_details,stock_products WHERE 
							cart_items.id_user = $id_user AND 
							cart_items.saved_for_later = $saved_for_later_modals  AND 
							cart_items.id_product_detail = product_details.id_product_detail AND 
							products.id_product = product_details.id_product AND 
							product_details.id_product_detail = stock_products.id_product_detail ORDER BY time_added DESC LIMIT 0,3 ");
                $get_cart_items_modals->execute();
                $cart_items_info = $get_cart_items_modals->fetchAll(PDO::FETCH_ASSOC);

                //NBR D'ITEMS DANS LE PANIER
                $count_cart_items = $connexion_db->prepare("SELECT COUNT(*) AS nb_items FROM cart_items WHERE id_user = $id_user AND saved_for_later = $saved_for_later");
                $count_cart_items->execute();
                $nb_items = $count_cart_items->fetch(PDO::FETCH_ASSOC);

                //TOTAL MONTANT PANIER
                $amount_cart = $connexion_db->prepare("SELECT 
							products.id_product,
							products.price, 

							cart_items.id_product_detail,
							cart_items.id_user,
							cart_items.saved_for_later,
							cart_items.quantity, 

							product_details.id_product_detail,
							product_details.id_product,   

							SUM(products.price*cart_items.quantity) AS total 

							FROM products, product_details, cart_items 

							WHERE cart_items.id_user = $id_user AND 
							cart_items.saved_for_later = $saved_for_later AND 
							products.id_product = product_details.id_product AND 
							product_details.id_product_detail = cart_items.id_product_detail GROUP BY products.id_product,products.price, 

							cart_items.id_product_detail,
							cart_items.id_user,
							cart_items.saved_for_later,
							cart_items.quantity, 

							product_details.id_product_detail,
							product_details.id_product ");

                $amount_cart->execute();

                $totalAmountCart = 0;

                while ($total_amount_cart = $amount_cart->fetch()) {
                    $totalAmountCart += $total_amount_cart['total'];
                }

            }


            //SI LE PANIER EST PLEIN
            if (!empty($cart_items_info[0])) { ?>

                <section class="wish_cart_overview">
                    <h3>Votre panier comprend <?php echo '<strong>' . $nb_items['nb_items'] . '</strong> ';
                        if ($nb_items['nb_items'] > 1) {
                            echo "articles";
                        } else {
                            echo "article";
                        } ?></h3>

                    <a href="cart_items.php?id_user=<?php echo $id_user ?>" class="linkCartItems">VOIR ET MODIFIER VOTRE
                        PANIER</a>

                    <div class="wish_cart_products">

                        <?php foreach ($cart_items_info as $cart_items_detail) { ?>

                            <div class="wish_cart_list">
                                <div class="wish_cart_picture">
                                    <img src="<?php echo $cart_items_detail['picture'] ?>"
                                         alt="<?php echo $cart_items_detail['product_name'] ?>" width="50">
                                </div>
                                <h4><?php echo $cart_items_detail['product_name'] ?></h4>
                                <div class="items_details">
                                    <p>€ <?php echo $cart_items_detail['price'] ?></p>
                                    <p>Taille : <?php echo $cart_items_detail['size'] ?></p>
                                    <p>Couleur : <?php echo $cart_items_detail['color'] ?></p>
                                    <p>Qt : <?php echo $cart_items_detail['quantity'] ?></p>
                                    <form action="" method="POST" class="remove_wish_cart">
                                        <button type="submit" name="remove_cart" class="miniDelete"><i
                                                    class="fal fa-trash-alt"></i></button>
                                        <input type="hidden" name="id_user" value="<?php echo $id_user ?>">
                                        <input type="hidden" name="id_product"
                                               value="<?php echo $cart_items_detail['id_product_detail'] ?>">
                                    </form>
                                </div>


                            </div>

                        <?php } ?>

                    </div>

                    <div class="total_amount">
                        <div class="total_line"><p>Total € <?php echo '<strong>' . $totalAmountCart . '</strong>' ?></p>
                        </div>
                        <div class="total_line payment"><a href="payment.php">POURSUIVRE LA COMMANDE</a></div>
                    </div>


                </section>

            <?php } else { ?>

                <p>Votre panier est actuellement vide</p>

            <?php } ?>


        </div>

    </div>

</aside>

<aside id="search-modal" class="modal" aria-hidden="true" role="dialog" aria-labelledby="titlemodal"
       style="display: none;">

    <div class="modal-wrapper js-modal-stop">

        <div class="close-btn close-btn-top">
            <button class="js-modal-close"><i class="fal fa-times"></i></button>
        </div>

        <div class="search-title"><h1>Rechercher</h1></div>

        <div class="search-console">
            <article class="product-suggestion">
                <h2>ARTICLES RECOMMANDÉS</h2>
                <div class="product-description">
                    <?php

                    /*$connexion_db = $db->connectDb();*/
                    $get_last_products = $connexion_db->prepare(" SELECT DISTINCT products.id_product,products.product_name,products.picture,products.price,product_details.id_product, product_details.color FROM products, product_details WHERE products.id_product = product_details.id_product LIMIT 0,3  ");
                    $get_last_products->execute();
                    $last_products = $get_last_products->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($last_products as $product_wish) {

                        ?>
                        <div class="article">

                            <div class="container">

                                <a href="product_page.php?prod=<?php echo $product_wish['id_product'] ?>"><img
                                            src="<?php echo $product_wish['picture'] ?>"
                                            alt="<?php echo $product_wish['picture'] ?>" class="image"></a>
                                <div class="middle">
                                    <a href="product_page.php?prod=<?php echo $product_wish['id_product'] ?>"
                                       class="text"><i class="fas fa-eye"></i></div>
                                </a>
                            </div>

                            <h5>
                                <a href="product_page.php?prod=<?php echo $product_wish['id_product'] ?>"><?php echo $product_wish['product_name'] ?></a>
                            </h5>
                            <div class="items_details">

                                <p>Couleur : <?php echo $product_wish['color'] ?></p>
                                <p><?php echo $product_wish['price'] . '€' ?></p>

                            </div>
                        </div>
                    <?php } ?>
                </div>
            </article>
            <div class="search-form" id="formulaire">

                <form action="" method="POST" id="formSearch">
                    <input type="text" name="search" class="search" id="searchNav" placeholder="Tapez votre recherche">
                    <button type="submit" class="search-button" value="Search!"><i class="fal fa-search"></i></button>
                    <div class="autocompletion" id="autocompletion"></div>
                </form>

            </div>
        </div>
    </div>

</aside>

<aside id="admin-modal" class="modal" aria-hidden="true" role="dialog" aria-labelledby="titlemodal"
       style="display: none;">

    <div class="modal-wrapper js-modal-stop">

        <div class="close-btn close-btn-top">
            <button class="js-modal-close"><i class="fal fa-times"></i></button>
        </div>

        <div class="personal_space">

            <h1>Bonjour <?php echo $_SESSION['user']['firstname'] ?></h1>

            <table class="table_personal_space">

                <thead>

                <tr>
                    <th><a href="admin.php">Administration générale</a></th>
                    <th><a href="stock_management.php">Les articles</a></th>
                    <th><a href="orders_management.php">Les commandes</a></th>
                    <th><a href="account_management.php">Infos utilisateurs</a></th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td><a href="admin.php"><i class="fas fa-folder-open"></i></a></td>
                    <td><a href="stock_management.php"><i class="fas fa-cart-plus"></i></a></td>
                    <td><a href="orders_management.php"><i class="fas fa-truck-loading"></i></a></td>
                    <td><a href="account_management.php"><i class="fas fa-users-cog"></i></a></td>
                </tr>
                </tbody>
            </table>

            <form action="" method="post">
                <input type="submit" name="submit_deconnexion" value="Se déconnecter" class="submit_deconnexion">
            </form>
        </div>


    </div>

</aside>


