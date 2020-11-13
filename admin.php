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

                        <h3>Créer une catégorie</h3>
                        <label for="name_category">Catégorie</label>
                        <input type="text" name="name_category" placeholder="exemple : femme" class="input_admin">

                        <label for="description_category">Descripton catégorie</label>
                        <textarea type="textarea" name="description_category"></textarea>

                        <h3>Créer une sous-catégorie</h3>
                        <label for="name_sub_category">Entrez le nom de votre sous-catégorie</label>
                        <input type="text" name="name_sub_category" placeholder="exemple : automne" class="input_admin">

                        <label for="description_sub_category">Descripton sous-catégorie</label>
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

                        <h3>Créer une sous-catégorie de niveau 2</h3>

                        <label for="name_sub_category_2">Sous-catégorie de niv 2</label>
                        <input type="text" name="name_sub_category_2" placeholder="exemple : influenceuse" class="input_admin">

                        <label for="description_sub_category_2">Description sous-catégorie de niv 2</label>
                        <textarea type="textarea" name="description_sub_category_2"></textarea>

                        <label for="category_parent">Catégorie à laquelle elle se rattache</label>
                        <select name="category_parent" class="input_admin">
                            <option value="">--</option>
                            <?php foreach($categories as $info_categories){?>
                            <option value="<?php echo $info_categories['id_category'] ?>"><?php echo $info_categories['name_category'] ?></option>
                            <?php } ?>
                        </select>

                        <label for="sub_category_parent">Sous-catégorie de niveau 1 à laquelle elle se rattache</label>
                        <select name="sub_category_parent" class="input_admin">
                            <option value="">--</option>
                            <?php foreach($sub_categories as $info_sub_categories){?>
                            <option value="<?php echo $info_sub_categories['id_sub_category'] ?>"><?php echo $info_sub_categories['name_sub_category'] ?></option>
                            <?php } ?>
                        </select>

                    </div>
                </div>
                <div class="button_admin_position">
                    <input type="submit" name="create_admin" value="ENREGISTRER" class="button_admin">
                </div>
            </form>

            <?php 

                $get_all_categories = $connexion_db->prepare("SELECT * FROM categories");
                $get_all_categories->execute();

                $get_all_sub_categories = $connexion_db->prepare("SELECT * FROM sub_categories");
                $get_all_sub_categories->execute();

                $get_all_sub_categories_2 = $connexion_db->prepare(" SELECT
                    categories.id_category,
                    categories.name_category,

                    sub_categories.id_sub_category,
                    sub_categories.name_sub_category,

                    sub_categories_2.id_sub_category_2,
                    sub_categories_2.id_category,
                    sub_categories_2.id_sub_category,
                    sub_categories_2.name_sub_category_2,
                    sub_categories_2.description_sub_category_2

                    FROM categories, sub_categories, sub_categories_2

                    WHERE 

                    sub_categories_2.id_category = categories.id_category
                    AND sub_categories_2.id_sub_category = sub_categories.id_sub_category

                    ORDER BY sub_categories_2.id_sub_category_2
                    ");

                $get_all_sub_categories_2->execute();



            ?>

            <table class="table_admin" id="categories">
                <thead>
                    <tr><th colspan="5" class="table_title">LES CATEGORIES</th></tr>
                    <tr>
                        <th>ID catégorie</th>
                        <th>Catégorie</th>
                        <th>Description catégorie</th>
                        <th>Modifier</th>
                        <th>Supprimer</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($info_categories = $get_all_categories->fetch()){ ?>
                    <tr>
                        <td class="table_middle"><?php echo $info_categories['id_category'] ?></td>
                        <td class="table_middle"><?php echo $info_categories['name_category'] ?></td>
                        <td class="table_justify"><?php echo $info_categories['description_category'] ?></td>
                        <td class="table_middle">
                            <!-- CREATION "SOUS PAGE" POUR MODIFIER UNIQUEMENT LA LIGNE CONTENANT L'ID DU PRODUIT -->
                            <a href="admin.php?category_edit=<?php echo $info_categories['id_category'] ?>#modify_admin"><i class="fas fa-edit"></i></a>
                        </td>

                        <?php 
                            if(isset($_POST['delete_category'])){
                                $admin->deleteCategory($_POST['id_category']);
                            }
                        ?>
                        <td class="table_middle">
                            <form method="post" action="">
                                <button type="submit" name="delete_category"><i class="fas fa-trash-alt"></i></button>
                                <!-- EFFACE UNIQUEMENT LA LIGNE CONTENANT L'ID DE LA CATEGORIE -->
                                <input type="hidden" name="id_category" value="<?php echo $info_categories['id_category'] ?>">
                            </form>
                        </td>
                    </tr>
                    <?php } $get_all_categories->closeCursor();?>
                </tbody>
            </table>

            <?php

                if (isset($_GET['category_edit'])) { 

                    $get_id_category = $_GET['category_edit'];

                    if(isset($_POST['update_category'])){
                        $admin->updateCategory(
                            $get_id_category,
                            $_POST['name_category'],
                            $_POST['description_category']
                            
                            );

                    }?>

                    <form action="" method="POST" class="form_admin" id="modify_admin">

                        <h1>Modifier la catégorie n° <?php echo $get_id_category ?></h1>

                        <div class="form_admin_body">

                            <div class="form_admin_position">

                                <label for="name_category">Nouveau nom de catégorie</label>
                                <input type="text" name="name_category" placeholder="exemple : femme" class="input_admin">

                                <label for="description_category">Nouvelle descripton de catégorie</label>
                                <textarea type="textarea" name="description_category"></textarea>

                            </div>

                        </div>
                        <div class="button_admin_position">
                            <input type="submit" name="update_category" value="ENREGRISTRER LES MODIFICATIONS" class="button_admin">
                        </div>
                        
                    </form>

            <?php } ?>




            <table class="table_admin" id="sub_categories">
                <thead>
                    <tr><th colspan="5" class="table_title">LES SOUS CATEGORIES</th></tr>
                    <tr>
                        <th>ID sous-catégorie</th>
                        <th>Sous-catégorie</th>
                        <th>Description sous-catégorie</th>
                        <th>Modifier</th>
                        <th>Supprimer</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($info_sub_categories = $get_all_sub_categories->fetch()){ ?>
                    <tr>
                        <td class="table_middle"><?php echo $info_sub_categories['id_sub_category'] ?></td>
                        <td class="table_middle"><?php echo $info_sub_categories['name_sub_category'] ?></td>
                        <td class="table_justify"><?php echo $info_sub_categories['description_sub_category'] ?></td>
                        <td class="table_middle">
                            <!-- CREATION "SOUS PAGE" POUR MODIFIER UNIQUEMENT LA LIGNE CONTENANT L'ID DU PRODUIT -->
                            <a href="admin.php?sub_category_edit=<?php echo $info_sub_categories['id_sub_category'] ?>#modify_admin"><i class="fas fa-edit"></i></a>
                        </td>

                        <?php 
                            if(isset($_POST['delete_sub_category'])){
                                $admin->deleteSubCategory($_POST['id_sub_category']);
                            }
                        ?>
                        <td class="table_middle">
                            <form method="post" action="">
                                <button type="submit" name="delete_sub_category"><i class="fas fa-trash-alt"></i></button>
                                <!-- EFFACE UNIQUEMENT LA LIGNE CONTENANT L'ID DE LA CATEGORIE -->
                                <input type="hidden" name="id_sub_category" value="<?php echo $info_sub_categories['id_sub_category'] ?>">
                            </form>
                        </td>
                    </tr>
                    <?php } $get_all_sub_categories->closeCursor(); ?>
                </tbody>
            </table>

            <?php

                if (isset($_GET['sub_category_edit'])) { 

                    $get_id_sub_category = $_GET['sub_category_edit'];

                    if(isset($_POST['update_sub_category'])){
                        $admin->updateSubCategory(
                            $get_id_sub_category,
                            $_POST['name_sub_category'],
                            $_POST['description_sub_category']
                            
                            );

                    }?>

                    <form action="" method="POST" class="form_admin" id="modify_admin">

                        <h1>Modifier la sous-catégorie n° <?php echo $get_id_sub_category ?></h1>

                        <div class="form_admin_body">

                            <div class="form_admin_position">

                                <label for="name_sub_category">Nouveau nom de sous-catégorie</label>
                                <input type="text" name="name_sub_category" placeholder="exemple : automne" class="input_admin">

                                <label for="description_sub_category">Nouvelle descripton de sous-catégorie</label>
                                <textarea type="textarea" name="description_sub_category"></textarea>

                            </div>

                        </div>
                        <div class="button_admin_position">
                            <input type="submit" name="update_sub_category" value="ENREGRISTRER LES MODIFICATIONS" class="button_admin">
                        </div>
                        
                    </form>

            <?php } ?>

            <table class="table_admin" id="sub_category_2">
                <thead>
                    <tr><th colspan="7" class="table_title">LES SOUS CATEGORIES DE NIVEAU 2</th></tr>
                    <tr>
                        <th>ID sous-catégorie niveau 2</th>
                        <th>Sous-catégorie niveau 2</th>
                        <th>Sous-catégorie parent</th>
                        <th>Catégorie parent</th>
                        <th>Description sous-catégorie niveau 2</th>
                        <th>Modifier</th>
                        <th>Supprimer</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($info_sub_categories_2 = $get_all_sub_categories_2->fetch()){ ?>
                    <tr>
                        <td class="table_middle"><?php echo $info_sub_categories_2['id_sub_category_2'] ?></td>
                        <td class="table_middle"><?php echo $info_sub_categories_2['name_sub_category_2'] ?></td>
                        <td class="table_middle"><?php echo $info_sub_categories_2['name_sub_category'] ?></td>
                        <td class="table_middle"><?php echo $info_sub_categories_2['name_category'] ?></td>
                        <td class="table_justify"><?php echo $info_sub_categories_2['description_sub_category_2'] ?></td>
                        <td class="table_middle">
                            <!-- CREATION "SOUS PAGE" POUR MODIFIER UNIQUEMENT LA LIGNE CONTENANT L'ID DU PRODUIT -->
                            <a href="admin.php?sub_category_2_edit=<?php echo $info_sub_categories_2['id_sub_category_2'] ?>#modify_admin"><i class="fas fa-edit"></i></a>
                        </td>

                        <?php 
                            if(isset($_POST['delete_sub_category_2'])){
                                $admin->deleteSubCategory2($_POST['id_sub_category_2']);
                            }
                        ?>
                        <td class="table_middle">
                            <form method="post" action="">
                                <button type="submit" name="delete_sub_category_2"><i class="fas fa-trash-alt"></i></button>
                                <!-- EFFACE UNIQUEMENT LA LIGNE CONTENANT L'ID DE LA CATEGORIE -->
                                <input type="hidden" name="id_sub_category_2" value="<?php echo $info_sub_categories_2['id_sub_category_2'] ?>">
                            </form>
                        </td>
                    </tr>
                    <?php } $get_all_sub_categories_2->closeCursor(); ?>
                </tbody>
            </table>

            <?php

                if (isset($_GET['sub_category_2_edit'])) { 

                    $get_id_sub_category_2 = $_GET['sub_category_2_edit'];

                    if(isset($_POST['update_category'])){
                        $admin->updateSubCategory_2(
                            $get_id_sub_category_2,
                            $_POST['name_sub_category_2'],
                            $_POST['description_sub_category_2'],
                            $_POST['category_parent'],
                            $_POST['sub_category_parent']
                            
                            );

                    }?>

                    <form action="" method="POST" class="form_admin" id="modify_admin">

                        <h1>Modifier la sous catégorie niv2 n° <?php echo $get_id_sub_category_2 ?></h1>

                        <div class="form_admin_body">

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

                                <label for="name_sub_category_2">Nouvelle sous-catégorie de niv 2</label>
                                <input type="text" name="name_sub_category_2" placeholder="exemple : influenceuse" class="input_admin">

                                <label for="description_sub_category_2">Nouvelle description sous-catégorie de niv 2</label>
                                <textarea type="textarea" name="description_sub_category_2"></textarea>

                                <label for="category_parent">Catégorie à laquelle elle se rattache</label>
                                <select name="category_parent" class="input_admin">
                                    <option value="">--</option>
                                    <?php foreach($categories as $info_categories){?>
                                    <option value="<?php echo $info_categories['id_category'] ?>"><?php echo $info_categories['name_category'] ?></option>
                                    <?php } ?>
                                </select>

                                <label for="sub_category_parent">Sous-catégorie de niveau 1 à laquelle elle se rattache</label>
                                <select name="sub_category_parent" class="input_admin">
                                    <option value="">--</option>
                                    <?php foreach($sub_categories as $info_sub_categories){?>
                                    <option value="<?php echo $info_sub_categories['id_sub_category'] ?>"><?php echo $info_sub_categories['name_sub_category'] ?></option>
                                    <?php } ?>
                                </select>

                            </div>

                        </div>
                        
                        <div class="button_admin_position">
                            <input type="submit" name="update_category" value="ENREGRISTRER LES MODIFICATIONS" class="button_admin">
                        </div>
                        
                    </form>

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