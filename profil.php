<?php
ob_start();


?>

    <!DOCTYPE html>
    <html lang="fr" dir="ltr">
    <head>
        <title>Boutique - Profil</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, user-scalable=yes">
        <link rel="shortcut icon" type="image/x-icon" href="images/logo.png">
        <link rel="stylesheet" href="fontawesome/all.css">
        <link rel="stylesheet" href="css/general.css">
        <link rel="stylesheet" href="css/header.css">
        <link rel="stylesheet" href="css/footer.css">
        <link rel="stylesheet" href="css/personal_space_head_page.css">
        <link rel="stylesheet" href="css/profil.css">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200&display=swap" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    </head>
    <body>
    <header>
        <?php include("includes/header.php") ?>
    </header>
    <main>

        <section class="banner">
        </section>

        <section class="forme" id="detail_account">

            <?php include("includes/personal_space_head_page.php"); ?>

            <div class="profil_page_head">
                <p>
                    <strong>DÉTAILS DU COMPTE</strong> <br><br>

                    Enregistrez les informations de votre compte, ajoutez-en de nouvelles et modifiez-les au besoin.<br><br>

                    Champs obligatoires<span>*</span>
                </p>
            </div>

            <?php

            //Si une session correspondant à l'id user de conneixon est en cours...
            if (isset($_SESSION['user']['id_user']) && $_SESSION['user']['id_user'] == $_GET['id_user']) {

            } // Sinon redirection vers la page d'accueil
            else {
                header("Location:index.php");
                exit;
            }

            $id_user = $_GET['id_user'];

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


            ?>

            <form action="" method="post" class="update_form">
                <div class="form_image">
                    <div>
                        <?php
                        $gender_check = $_SESSION['user']['gender'];
                        $check = ($gender_check == "male") ? true : false;
                        $check2 = ($gender_check == "female") ? true : false;
                        $check3 = ($gender_check == "no_gender") ? true : false;

                        ?>
                        <div class="gender">
                            <p>Sexe *</p>
                            <input type="radio" name="gender" id="male" value="male" <?php if ($check == true) {
                                echo "checked";
                            } else {
                                echo "";
                            } ?>>
                            <label for="male">Homme</label>

                            <input type="radio" name="gender" id="female" value="female" <?php if ($check2 == true) {
                                echo "checked";
                            } else {
                                echo "";
                            } ?>>
                            <label for="female">Femme</label>

                            <input type="radio" name="gender" id="no_gender"
                                   value="no_gender" <?php if ($check3 == true) {
                                echo "checked";
                            } else {
                                echo "";
                            } ?> >
                            <label for="no_gender">Non genré</label><br>
                        </div>


                        <label for="lastname">Nom de famille</label><br>
                        <input type="text" class="input" name="lastname"
                               placeholder="<?php echo $_SESSION['user']['lastname'] ?>"><br>
                        <label for="firstname">Prénom</label><br>
                        <input type="text" class="input" name="firstname"
                               placeholder="<?php echo $_SESSION['user']['firstname'] ?>"><br>


                        <label for="birthday">Date de naissance</label><br>
                        <input type="date" class="input" name="birthday"
                               value="<?php echo $_SESSION['user']['birthday'] ?>"><br>
                        <label for="phone">N° de téléphone</label><br>
                        <input type="text" class="input" name="phone"
                               placeholder="<?php echo $_SESSION['user']['phone'] ?>"><br>
                        <label for="mail">Email</label><br>
                        <input type="text" class="input" name="mail"
                               placeholder="<?php echo $_SESSION['user']['mail'] ?>"><br>


                        <label for="password">Nouveau mot de passe</label><br>
                        <input type="password" class="input" name="password"
                               placeholder="Entrez votre mot de passe"><br>
                        <label for="password_check">Confirmation nouveau mot de passe</label><br>
                        <input type="password" class="input" name="password_check"
                               placeholder="Confirmez votre mot de passe"><br>

                        <label for="account_type">Type de compte</label><br>
                        <input type="text" class="input" name="account_type"
                               placeholder="<?php echo $_SESSION['user']['account_type'] ?>" disabled><br>

                        <div class="newsletter">
                            <p>
                                <strong>ABONNEMENT À LA NEWSLETTER</strong><br><br>

                                Inscrivez-vous pour découvrir les coulisses du monde des dupes et être au courant des
                                nouveautés, des promotions exclusives et des actualités de la marque avant tout le
                                monde.
                            </p>

                        </div>
                    </div>

                    <div class="profil_picture">
                        <img src="images/blanca-suarez.jpg" alt="blanca-suarez.jpg">
                    </div>

                </div>
                <div class="check_box">
                    <div class="checkbox_detail">
                        <p>
                            Vos renseignements personnels seront utilisés par DUPEZ et le groupe LES SILENCIEUX
                            (gestionnaire du site) afin d'améliorer la navigation du site Web, d'accélérer le processus
                            d'achat, de vous garantir un accès à des espaces réservés, de vous offrir les services de la
                            newsletter (sur demande) et en général d'améliorer la qualité de service que nous vous
                            offrons.<br><br>

                            DUPEZ et le groupe LES SILENCIEUX conservent vos renseignements personnels.<br><br>

                            Veuillez consulter la Politique de Confidentialité pour plus d'informations.
                        </p>
                    </div>
                    <div class="checkbox_column">

                        <div class="checkbox-position">
                            <?php
                            if ($_SESSION['user']['autorisation_newsletter'] == false) {
                                ?>
                                <input type="checkbox" id="autorisation_newsletter" name="newsletter"
                                       value="<?php echo "autorisation" ?>">
                                <label for="autorisation_newsletter" class="autorisation_newsletter">
                                    Je souhaite recevoir par email des newsletters, des promotions personnalisées, des
                                    informations ainsi que de la communication par courrier de DUPEZ. <br>
                                    J’autorise DUPEZ et le groupe LES SILENCIEUX (gestionnaire du site) à traiter mes
                                    données personnelles à cette fin.
                                </label>

                            <?php } else {
                                ?>
                                <input type="checkbox" id="autorisation1" name="newsletter"
                                       value="<?php echo "denial" ?>">
                                <label for="autorisation1" class="autorisation1">
                                    Je ne souhaite plus recevoir par email des newsletters, des promotions
                                    personnalisées, des informations ainsi que de la communication par courrier de
                                    DUPEZ. <br>
                                    Je n’autorise plus DUPEZ et le groupe LES SILENCIEUX (gestionnaire du site) à
                                    traiter mes données personnelles à cette fin.
                                </label>
                            <?php } ?>

                        </div>
                        <div class="checkbox-position">
                            <?php
                            if ($_SESSION['user']['autorisation_rgpd'] == false) {
                                ?>
                                <input type="checkbox" id="autorisation2" name="rgpd"
                                       value="<?php echo "autorisation" ?>">
                                <label for="autorisation_rgpd">
                                    J'autorise DUPEZ et le groupe LES SILENCIEUX (gestionnaire du site) à collecter mes
                                    renseignements personnels afin de créer le profil de mes habitudes d'achat.
                                </label>
                            <?php } else {
                                ?>
                                <input type="checkbox" id="autorisation_rgpd" name="rgpd"
                                       value="<?php echo "denial" ?>">
                                <label for="autorisation_rgpd">
                                    Je n'autorise plus DUPEZ et le groupe LES SILENCIEUX (gestionnaire du site) à
                                    collecter mes renseignements personnels afin de créer le profil de mes habitudes
                                    d'achat.
                                </label>
                            <?php } ?>


                        </div>
                        <input type="hidden" name="id_user" value="<?php $id_user = $_SESSION['user']['id_user'];
                        echo $id_user ?>">
                        <input type="submit" class="update-button" name="submit_update" value="ENVOYER">
                    </div>
                </div>


            </form>

        </section>


    </main>
    <footer>
        <?php include("includes/footer.php") ?>
    </footer>

    <script type="text/javascript" src="js/modal.js"></script>
    <script type="text/javascript" src="js/autocompletion.js"></script>
    </body>
    </html>
<?php ob_end_flush(); ?>