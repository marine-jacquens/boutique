<?php
ob_start();
session_start();
?>

<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
	<title>Boutique - Inscription</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=image">
    <link rel="shortcut icon" type="image/x-icon" href="images/logo.png">
    <link rel="stylesheet" href="fontawesome/all.css">
    <link rel="stylesheet" href="css/general.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" type="text/css" href="css/admin_space_head_page.css">
    <link rel="stylesheet" type="text/css" href="css/admin_general.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200&display=swap" rel="stylesheet">
</head>
<body>
	<header>
		<?php include("includes/header.php")?>
	</header>
    <main>
        <section class="banner">
        </section>
        <section class="forme" id="admin">

        <?php include("includes/admin_space_head_page.php");  ?>    

        <div class="bar">
            <div class="progression-bar_admin">
            </div>
        </div>

            <?php 

                if(isset($_POST['create_admin'])){

                   $admin->register(
                        $_POST['name_category'],
                        $_POST['description_category'],
                        $_POST['name_sub_category'],
                        $_POST['description_sub_category'],
                        $_POST['name_sub_category_2'],
                        $_POST['description_sub_category_2'],
                        $_POST['category_parent'],
                        $_POST['sub_category_parent']


    
                    );      


                }


            ?>

            <form action="" method="post" class="form_admin">

                <h1>Ajouter un nouveau champs à administrer</h1>

                <div class="form_admin_body">

                    <div class="form_admin_position">

                        <h3>Créer une nouvelle catégorie</h3>
                        <label for="name_category">Entrez le nom de votre catégorie</label>
                        <input type="text" name="name_category" placeholder="exemple : femme" class="input_admin">

                        <label for="description_category">Entrez une descripton de votre catégorie</label>
                        <textarea type="textarea" name="description_category"></textarea>

                        <h3>Créer une nouvelle sous-catégorie</h3>
                        <label for="name_sub_category">Entrez le nom de votre sous-catégorie</label>
                        <input type="text" name="name_sub_category" placeholder="exemple : automne" class="input_admin">

                        <label for="description_sub_category">Entrez une descripton de votre sous-catégorie</label>
                        <textarea type="textarea" name="description_sub_category"></textarea>

                    </div>

                    <div class="form_admin_position">

                        <?php 

                            $connexion_db = $db->connectDb();

                            $get_categories = $connexion_db->prepare("SELECT * FROM categories");
                            $get_categories->execute();
                            $categories = $get_categories->fetchAll(PDO::FETCH_ASSOC);

                            $get_sub_categories = $connexion_db->prepare("SELECT * FROM sub_categories");
                            $get_sub_categories->execute();
                            $sub_categories = $get_sub_categories->fetchAll(PDO::FETCH_ASSOC);
                        ?>

                        <h3>Créer une nouvelle sous-catégorie de niveau 2</h3>

                        <label for="name_sub_category_2">Entrez le nom de votre sous-catégorie de niv 2</label>
                        <input type="text" name="name_sub_category_2" placeholder="exemple : influenceuse" class="input_admin">

                        <label for="description_sub_category_2">Entrez une descripton de votre sous-catégorie de niv 2</label>
                        <textarea type="textarea" name="description_sub_category_2"></textarea>

                        <label for="category_parent">Entrez la catégorie à laquelle elle se rattache</label>
                        <select name="category_parent" class="input_admin">
                            <option value="">--</option>
                            <?php foreach($categories as $info_categories){?>
                            <option value="<?php echo $info_categories['name_category'] ?>"><?php echo $info_categories['name_category'] ?></option>
                            <?php } ?>
                        </select>

                        <label for="sub_category_parent">Entrez la sous-catégorie de niveau 1 à laquelle elle se rattache</label>
                        <select name="sub_category_parent" class="input_admin">
                            <option value="">--</option>
                            <?php foreach($sub_categories as $info_sub_categories){?>
                            <option value="<?php echo $info_sub_categories['name_sub_category'] ?>"><?php echo $info_sub_categories['name_sub_category'] ?></option>
                            <?php } ?>
                        </select>

                    </div>
                </div>
                <div class="button_admin_position">
                    <input type="submit" name="create_admin" value="ENREGISTRER" class="button_admin">
                </div>
            </form>

        </section>
    </main>
    <footer>
        <?php include("includes/footer.php")?>
    </footer>
    <script type="text/javascript" src="js/modal.js"></script>
</body>
</html>

<?php ob_end_flush();?>