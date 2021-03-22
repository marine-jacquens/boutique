<?php
ob_start();
?>

    <!DOCTYPE html>
    <html lang="fr" dir="ltr">
    <head>

        <title>Boutique - Paiement</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=image">
        <link rel="shortcut icon" type="image/x-icon" href="images/logo.png">
        <link rel="stylesheet" href="fontawesome/all.css">
        <link rel="stylesheet" href="css/general.css">
        <link rel="stylesheet" href="css/header.css">
        <link rel="stylesheet" href="css/payment.css">
        <link rel="stylesheet" href="css/footer.css">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200&display=swap" rel="stylesheet">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://js.stripe.com/v3/"></script>

    </head>
    <body>
    <header>
        <?php include("includes/header.php") ?>
    </header>
    <main>

        <?php if (isset($_SESSION['user']['id_user'])) { ?>

            <section class="payment_page">
                <div class="info_delivery">
                    <form method="POST" action="payment.php#paymentFrm">
                        <div class="form_position_name">
                            <h3>Civilité</h3>
                            <div class="lastname_firstname">
                                <div class="name_position">
                                    <label for="lastname">Nom</label>
                                    <input type="text" name="lastname"
                                           value="<?php echo $_SESSION['user']['lastname'] ?>" required>
                                </div>
                                <div class="name_position">
                                    <label for="firstname">Prénom</label>
                                    <input type="text" name="firstname"
                                           value="<?php echo $_SESSION['user']['firstname'] ?>" required>
                                </div>
                            </div>
                        </div>

                        <div class="form_position_part">
                            <h3>Adresse de livraison</h3>
                            <label for="delivery_address">Adresse</label>
                            <input type="text" name="delivery_address" value="21 cours Mirabeau" required>

                            <label for="delivery_postcode">Code postal</label>
                            <input type="number" name="delivery_postcode" value="13100" required>

                            <label for="delivery_city">Ville</label>
                            <input type="text" name="delivery_city" value="Aix-en-Provence" required>

                            <label for="delivery_country">Pays</label>
                            <input type="text" name="delivery_country" value="France" required>
                        </div>
                        <div class="form_position_part">
                            <h3>Adresse de facturation</h3>
                            <label for="bill_address">Adresse</label>
                            <input type="text" name="bill_address" value="21 cours Mirabeau" required>

                            <label for="bill_postcode">Code postal</label>
                            <input type="number" name="bill_postcode" value="13100" required>

                            <label for="bill_city">Ville</label>
                            <input type="text" name="bill_city" value="Aix-en-Provence" required>

                            <label for="bill_country">Pays</label>
                            <input type="text" name="bill_country" value="France" required>
                        </div>
                        <div class="form_position_part">
                            <h3>Coordonnées</h3>
                            <label for="mail">Mail</label>
                            <input type="email" name="mail" value="<?php echo $_SESSION['user']['mail'] ?>" required>
                            <label for="phone">Numéro de téléphone</label>
                            <input type="text" name="phone" value="<?php echo $_SESSION['user']['phone'] ?>" required>
                        </div>
                        <div>
                            <input type="submit" name="register_delivery" value="CONFIRMER SES INFORMATIONS"
                                   class="button_info_delivery">
                        </div>
                    </form>
                </div>
                <div class="info_payment">
                    <div class="cart_items_modify">
                        <?php
                        //COUNT NBR D'ITEMS DANS LE PANIER
                        $saved_for_later = true;
                        $get_item_number = $connexion_db->prepare("SELECT COUNT(*) AS item_count FROM cart_items WHERE id_user = $id_user AND saved_for_later = $saved_for_later");
                        $get_item_number->execute();
                        $item_number = $get_item_number->fetch(PDO::FETCH_ASSOC);

                        ?>
                        <p><strong>Panier </strong>(<?php if ($item_number['item_count'] > 1) {
                                echo $item_number['item_count'] . ' articles';
                            } else {
                                echo $item_number['item_count'] . ' article';
                            } ?>)</p>
                        <a href="cart_items.php?id_user=<?php echo $id_user ?>" class="cart_modify_access"><i
                                    class="fal fa-pencil"></i> MODIFIER</a>
                    </div>
                    <?php

                    //RECUPERATION ARTICLE PANIER
                    $get_items = $connexion_db->prepare(" SELECT cart_items.*,products.*,product_details.* FROM cart_items,products,product_details WHERE product_details.id_product = products.id_product AND cart_items.id_product_detail = product_details.id_product_detail AND cart_items.id_user = $id_user AND cart_items.saved_for_later = $saved_for_later ORDER BY cart_items.time_added DESC ");
                    $get_items->execute(); ?>
                    <div class="list-items_frame">
                        <?php while ($items = $get_items->fetch()) { ?>
                            <div class="list-items">

                                <div class="payment_picture_product">
                                    <a href="product_page.php?prod=<?php echo $items['id_product'] ?>"><img
                                                src="<?php echo $items['picture'] ?>"
                                                alt="<?php echo $items['picture'] ?>"></a>
                                </div>
                                <div class="payment_info_product">
                                    <h3><?php echo $items['product_name'] ?></h3>
                                    <p>€ <?php echo $items['price'] ?></p>
                                    <p>Taille : <?php echo $items['size'] ?></p>
                                    <p>Couleur : <?php echo $items['color'] ?></p>
                                    <p>Quantité : <?php echo $items['quantity'] ?></p>
                                    <?php
                                    //SI ON RETIRE UN ITEM DU PANIER
                                    if (isset($_POST['remove_cart'])) {
                                        $cart->removeCart($_POST['id_product'], $_POST['id_user']);
                                    }
                                    ?>
                                    <form action="" method="POST" class="remove_wish_cart cart_button">
                                        <button type="submit" name="remove_cart"><i class="fal fa-trash-alt"></i>
                                            SUPPRIMER
                                        </button>
                                        <input type="hidden" name="id_user" value="<?php echo $id_user ?>">
                                        <input type="hidden" name="id_product"
                                               value="<?php echo $items['id_product_detail'] ?>">
                                    </form>
                                </div>
                            </div>
                        <?php }
                        $get_items->closeCursor(); ?>
                    </div>
                    <div class="sous_total">
                        <?php

                        //TOTAL PANIER
                        $amount_cart = $cart->getCartAmount($id_user);

                        ?>
                        <div class="calculation_detail">
                            <div class="detail_price">
                                <h4>SOUS TOTAL </h4>
                                <p> € <?php echo $amount_cart ?></p>
                            </div>
                            <div class="detail_price">
                                <div>
                                    <h4>MOYEN DE LIVRAISON</h4>
                                    <h5>Standard </br> Livraison dans un délai de 4-6 jours ouvrables</h5>
                                </div>
                                <div>
                                    <p>Gratuite</p>
                                </div>
                            </div>
                            <div class="detail_price">
                                <div>
                                    <h4>MOYEN DE PAIEMENT</h4>
                                    <h5>Carte de crédit</h5>
                                </div>
                                <div>
                                    <p>Gratuit</p>
                                </div>

                            </div>
                        </div>
                        <div class="total_amount_line">
                            <div class="detail_price">
                                <h4>TOTAL</h4>
                                <p> € <?php echo $amount_cart ?></p>
                            </div>
                        </div>

                    </div>
                    <?php if (isset($_POST['register_delivery'])) { ?>


                        <div class="payment_frame" id="payment">



                            <!-- Afficher les erreurs renvoyées par createToken -->
                            <div id="paymentResponse"></div>

                            <form action="check_payment.php" method="POST" class="form_payment" id="paymentFrm">

                                <p>Vos informations ont été pré-enregistrées, veuillez procéder au paiement</p>

                                <label for="cardholder_firstname">Nom du titulaire</label>
                                <input type="text" name="name"
                                       value="<?php echo $_SESSION['user']['firstname'] . ' ' . $_SESSION['user']['lastname'] ?>"
                                       required>

                                <label for="card_number">Numéro de carte</label>
                                <div id="card_number" class="paymentFormInput"></div>

                                <label for="card_expiry">Date d'expiration</label>
                                <div id="card_expiry" class="paymentFormInput"></div>

                                <label for="card_cvc">Code de sécurité</label>
                                <div id="card_cvc" class="paymentFormInput"></div>

                                <input type="hidden" name="lastname" value="<?php echo $_POST['lastname'] ?>">
                                <input type="hidden" name="lastname" value="<?php echo $_POST['lastname'] ?>">
                                <input type="hidden" name="firstname" value="<?php echo $_POST['firstname'] ?>">
                                <input type="hidden" name="bill_address" value="<?php echo $_POST['bill_address'] ?>">
                                <input type="hidden" name="bill_postcode" value="<?php echo $_POST['bill_postcode'] ?>">
                                <input type="hidden" name="bill_city" value="<?php echo $_POST['bill_city'] ?>">
                                <input type="hidden" name="bill_country" value="<?php echo $_POST['bill_country'] ?>">
                                <input type="hidden" name="delivery_address"
                                       value="<?php echo $_POST['delivery_address'] ?>">
                                <input type="hidden" name="delivery_city" value="<?php echo $_POST['delivery_city'] ?>">
                                <input type="hidden" name="delivery_country"
                                       value="<?php echo $_POST['delivery_country'] ?>">
                                <input type="hidden" name="delivery_postcode"
                                       value="<?php echo $_POST['delivery_postcode'] ?>">
                                <input type="hidden" name="mail" value="<?php echo $_POST['mail'] ?>">
                                <input type="hidden" name="phone" value="<?php echo $_POST['phone'] ?>">
                                <input type="hidden" name="amount" value="<?php echo $amount_cart ?>">

                                <input type="submit" name="proceed_payment" value="CONFIRMER LE PAIEMENT"
                                       class="payment_button">

                            </form>

                        </div>
                    <?php } ?>


                </div>
            </section>

        <?php } else {
            header('Location:index.php');
        } ?>
    </main>
    <footer>
        <?php include("includes/footer.php") ?>
    </footer>

    <script type='text/javascript' src='config.js'></script>
    <script type="text/javascript" src="js/payment.js"></script>
    <script type="text/javascript" src="js/modal.js"></script>
    <script type="text/javascript" src="js/autocompletion.js"></script>
    </body>
    </html>

<?php ob_end_flush(); ?>