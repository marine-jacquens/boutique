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
        <link rel="stylesheet" type="text/css" href="css/admin_space_head_page.css">
        <link rel="stylesheet" href="css/admin_general.css">
        <link rel="stylesheet" href="css/footer.css">

        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200&display=swap" rel="stylesheet">
    </head>
    <body>
    <header>
        <?php include("includes/header.php") ?>
    </header>
    <main>
        <?php if (isset($_SESSION['user']['id_user']) and $_SESSION['user']['account_type'] === 'admin') { ?>

            <section class="banner">
            </section>

            <section class="forme" id="account_management">
                <?php include("includes/admin_space_head_page.php"); ?>
                <div class="bar">
                    <div class="progression-bar_account"></div>
                </div>

                <?php

                //RECUPERATION DES INFOS UTILISATEURS
                $get_info_users = $connexion_db->prepare(" SELECT users.*, newsletter.* FROM users,newsletter WHERE users.id_user = newsletter.id_user ");
                $get_info_users->execute();
                ?>

                <table class="table_admin account" id="table_account">
                    <thead>
                    <tr>
                        <th colspan="14" class="table_title">INFORMATIONS UTILISATEURS</th>
                    </tr>
                    <tr>
                        <th>Id utilisateur</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Sexe</th>
                        <th>Date de naissance</th>
                        <th>Téléphone</th>
                        <th>Mail</th>
                        <th>Date d'inscription</th>
                        <th>Dernière modification</th>
                        <th>Type de compte</th>
                        <th>Autorisation RGPD</th>
                        <th>Autorisation Newsletter</th>
                        <th>Modifier</th>
                        <th>Supprimer</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php while ($user_info = $get_info_users->fetch()) { ?>
                        <tr>
                            <td class="table_middle"><?php echo $user_info['id_user'] ?></td>
                            <td class="table_middle"><?php echo $user_info['lastname'] ?></td>
                            <td class="table_middle"><?php echo $user_info['firstname'] ?></td>


                            <td class="table_middle"><?php

                                switch ($user_info['gender']) {
                                    case $user_info['gender'] == "female" :
                                        ?> <i class="fal fa-venus"></i> <?php
                                        break;
                                    case $user_info['gender'] == "male" :
                                        ?> <i class="fal fa-mars"></i> <?php
                                        break;
                                    case $user_info['gender'] == "no_gender" :
                                        ?> <i class="fal fa-genderless"></i> <?php
                                        break;

                                }

                                ?></td>

                            <td class="table_middle"><?php echo $user_info['birthday'] ?></td>
                            <td class="table_middle"><?php echo $user_info['phone'] ?></td>
                            <td class="table_middle"><?php echo $user_info['mail'] ?></td>
                            <td class="table_middle"><?php echo $user_info['date_joined'] ?></td>
                            <td class="table_middle"><?php echo $user_info['date_modified'] ?></td>
                            <td class="table_middle"><?php echo $user_info['account_type'] ?></td>
                            <td class="table_middle"><?php if ($user_info['autorisation_rgpd'] == true) { ?> <i
                                        class="fal fa-check"></i> <?php } else { ?> <i
                                        class="fal fa-times"></i> <?php } ?></td>
                            <td class="table_middle"><?php if ($user_info['autorisation'] == true) { ?> <i
                                        class="fal fa-check"></i> <?php } else { ?> <i
                                        class="fal fa-times"></i> <?php } ?></td>
                            <td class="table_middle">
                                <!-- CREATION "SOUS PAGE" POUR MODIFIER UNIQUEMENT LA LIGNE CONTENANT L'ID DU PRODUIT -->
                                <a href="account_management.php?user_edit=<?php echo $user_info['id_user'] ?>#edit_management"><i
                                            class="fas fa-edit"></i></a>
                            </td>
                            <td class="table_middle">
                                <?php if (isset($_POST['delete_user'])) {
                                    $user->delete($_POST['id_user']);
                                } ?>
                                <form method="post" action="">
                                    <button type="submit" name="delete_user"><i class="fas fa-trash-alt"></i></button>
                                    <!-- EFFACE UNIQUEMENT LA LIGNE CONTENANT L'ID DU PRODUIT -->
                                    <input type="hidden" name="id_user" value="<?php echo $user_info['id_user'] ?>">
                                </form>
                            </td>
                        </tr>
                    <?php }
                    $get_info_users->closeCursor(); ?>
                    </tbody>
                </table>

                <?php

                if (isset($_GET['user_edit'])) {

                    $get_id_user = $_GET['user_edit'];

                    if (isset($_POST['submit_update'])) {


                        $user->update(
                            $_POST['lastname'],
                            $_POST['firstname'],
                            $_POST['gender'],
                            $_POST['birthday'],
                            $_POST['phone'],
                            $_POST['mail'],
                            $_POST['password'],
                            $_POST['password_check'],
                            $_POST['account_type'],
                            $_POST['rgpd'],
                            $_POST['newsletter'],
                            $_POST['id_user']

                        );

                    }

                    //RECUPERATION DES DONNEES DE L'UTILISATEUR
                    $get_user_info = $connexion_db->prepare(" SELECT users.*, newsletter.* FROM users,newsletter WHERE users.id_user = $get_id_user AND users.id_user = newsletter.id_user ");
                    $get_user_info->execute();
                    $user_info = $get_user_info->fetch(PDO::FETCH_ASSOC);
                    ?>

                    <form action="" method="post" class="form_admin" id="edit_management">
                        <h1>Modifier le compte utilisateur n°<?php echo $user_info['id_user'] ?></h1>
                        <div class="form_admin_body">
                            <input type="hidden" name="id_user" value="<?php echo $user_info['id_user'] ?>">
                            <div class="form_admin_position">

                                <?php
                                $gender_check = $user_info['gender'];
                                $check = ($gender_check == "male") ? true : false;
                                $check2 = ($gender_check == "female") ? true : false;
                                $check3 = ($gender_check == "no_gender") ? true : false;
                                ?>

                                <div class="gender">

                                    <input type="radio" name="gender" id="male" value="male"
                                           class="input_admin" <?php if ($check == true) {
                                        echo "checked";
                                    } else {
                                        echo "";
                                    } ?>>
                                    <label for="male">Homme</label>

                                    <input type="radio" name="gender" id="female" value="female"
                                           class="input_admin" <?php if ($check2 == true) {
                                        echo "checked";
                                    } else {
                                        echo "";
                                    } ?>>
                                    <label for="female">Femme</label>

                                    <input type="radio" name="gender" id="no_gender" value="no_gender"
                                           class="input_admin" <?php if ($check3 == true) {
                                        echo "checked";
                                    } else {
                                        echo "";
                                    } ?>>
                                    <label for="no_gender">Non genré</label>
                                </div>

                                <label for="lastname">Nom de famille</label>
                                <input type="text" name="lastname" placeholder="<?php echo $user_info['lastname'] ?>"
                                       class="input_admin">

                                <label for="firstname">Prénom</label>
                                <input type="text" class="input" name="firstname"
                                       placeholder="<?php echo $user_info['firstname'] ?>" class="input_admin">

                                <label for="birthday">Date de naissance</label>
                                <input type="date" name="birthday" value="<?php echo $user_info['birthday'] ?>"
                                       class="input_admin">

                                <label for="phone">N° de téléphone</label>
                                <input type="text" name="phone" placeholder="<?php echo $user_info['phone'] ?>"
                                       class="input_admin">

                            </div>

                            <div class="form_admin_position">

                                <label for="mail">Email</label>
                                <input type="text" name="mail" placeholder="<?php echo $user_info['mail'] ?>"
                                       class="input_admin">

                                <label for="account_type">Type de compte</label>
                                <input type="text" name="account_type"
                                       placeholder="<?php echo $user_info['account_type'] ?>" class="input_admin">

                                <label for="password">Nouveau mot de passe</label>
                                <input type="password" name="password" placeholder="Entrez votre mot de passe"
                                       class="input_admin">

                                <label for="password_check">Confirmation nouveau mot de passe</label>
                                <input type="password" name="password_check" placeholder="Confirmez votre mot de passe"
                                       class="input_admin">

                                <div>
                                    <input type="checkbox" id="autorisation_rgpd" name="rgpd"
                                           value="<?php if ($user_info['autorisation_rgpd'] == true) {
                                               echo "denial";
                                           } else {
                                               echo "autorisation";
                                           } ?>">
                                    <label for="autorisation_rgpd"><?php if ($user_info['autorisation_rgpd'] == true) {
                                            echo 'Refuser collecte d\'information (RGPD)';
                                        } else {
                                            echo 'Autoriser collecte d\'information (RGPD)';
                                        } ?></label>
                                </div>

                                <div>
                                    <input type="checkbox" id="autorisation_newsletter" name="newsletter"
                                           value="<?php if ($user_info['autorisation'] == true) {
                                               echo "denial";
                                           } else {
                                               echo "autorisation";
                                           } ?>">
                                    <label for="autorisation_newsletter"
                                           class="autorisation_newsletter"><?php if ($user_info['autorisation'] == true) {
                                            echo 'Ne plus recevoir la newsletter';
                                        } else {
                                            echo 'Autoriser newsletter';
                                        } ?></label>
                                </div>


                            </div>

                        </div>
                        <div class="button_admin_position"><input type="submit" name="submit_update" value="ENVOYER"
                                                                  class="button_admin"></div>
                    </form>

                    <?php

                    ?>


                <?php } ?>




                <?php

                //RECUPERATION LISTE D'ENVIE DES UTILISATEURS

                $saved_for_later = true;

                $get_wish_list = $connexion_db->prepare(" SELECT wish_list_items.*, products.* FROM wish_list_items, products WHERE wish_list_items.id_product = products.id_product AND wish_list_items.saved_for_later = $saved_for_later ");
                $get_wish_list->execute();

                ?>

                <table class="table_admin wish" id="table_account_wish">
                    <thead>
                    <tr>
                        <th colspan="5" class="table_title">LISTE D'ENVIES UTILISATEUR</th>
                    </tr>
                    <tr>
                        <th>Id utilisateur</th>
                        <th>Id produit</th>
                        <th>Produit(s)</th>
                        <th>Image</th>
                        <th>Date d'ajout</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php while ($wish_list_info = $get_wish_list->fetch()) { ?>
                        <tr>
                            <td class="table_middle"><?php echo $wish_list_info['id_user'] ?></td>
                            <td class="table_middle"><?php echo $wish_list_info['id_product'] ?></td>
                            <td>
                                <a href="product_page.php?prod=<?php echo $wish_list_info['id_product'] ?>"><?php echo $wish_list_info['product_name'] ?></a>
                            </td>
                            <td class="table_middle"><img src="<?php echo $wish_list_info['picture'] ?>"
                                                          alt="<?php echo $wish_list_info['picture'] ?>" width="70">
                            </td>
                            <td class="table_middle"><?php echo $wish_list_info['time_added'] ?></td>
                        </tr>
                    <?php }
                    $get_wish_list->closeCursor(); ?>
                    </tbody>
                </table>

                <?php if (isset($_POST['definitive_delete'])) {
                    $wish->delete();
                } ?>

                <div class="definitive_delete">
                    <form action="" method="POST">
                        <button type="submit" name="definitive_delete">SUPPRIMER LES ANCIENNES ENTREES</button>
                    </form>
                </div>


                <?php

                //RECUPERATION LISTE D'ENVIE DES UTILISATEURS

                $saved_for_later = true;

                $get_cart_list = $connexion_db->prepare(" SELECT cart_items.*, products.*,product_details.*  FROM cart_items, products,product_details WHERE cart_items.id_product_detail = product_details.id_product_detail AND product_details.id_product = products.id_product AND cart_items.saved_for_later = $saved_for_later ");
                $get_cart_list->execute();

                ?>

                <table class="table_admin cart" id="table_account_cart">
                    <thead>
                    <tr>
                        <th colspan="6" class="table_title">LISTE ARTICLES PANIER UTILISATEUR</th>
                    </tr>
                    <tr>
                        <th>Id utilisateur</th>
                        <th>Id produit</th>
                        <th>Produit(s)</th>
                        <th>Image</th>
                        <th>Quantité</th>
                        <th>Date d'ajout</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php while ($cart_info = $get_cart_list->fetch()) { ?>
                        <tr>
                            <td class="table_middle"><?php echo $cart_info['id_user'] ?></td>
                            <td class="table_middle"><?php echo $cart_info['id_product'] ?></td>
                            <td>
                                <a href="product_page.php?prod=<?php echo $cart_info['id_product'] ?>"><?php echo $cart_info['product_name'] ?></a>
                            </td>
                            <td class="table_middle"><img src="<?php echo $cart_info['picture'] ?>"
                                                          alt="<?php echo $cart_info['picture'] ?>" width="70">
                            </td>
                            <td class="table_middle"><?php echo $cart_info['quantity'] ?></td>
                            <td class="table_middle"><?php echo $cart_info['time_added'] ?></td>
                        </tr>
                    <?php }
                    $get_cart_list->closeCursor(); ?>
                    </tbody>
                </table>

                <?php if (isset($_POST['definitive_delete_cart'])) {
                    $cart->delete();
                } ?>

                <div class="definitive_delete">
                    <form action="" method="POST">
                        <button type="submit" name="definitive_delete_cart">SUPPRIMER LES ANCIENNES ENTREES</button>
                    </form>
                </div>

            </section>
            <?php

        } else {
            header('Location:index.php');
            exit;
        }

        ?>
    </main>
    <footer>
        <?php include("includes/footer.php") ?>
    </footer>
    <script type="text/javascript" src="js/modal.js"></script>
    </body>
    </html>

<?php ob_end_flush(); ?>