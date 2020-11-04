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
    <link rel="stylesheet" href="css/admin_general.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200&display=swap" rel="stylesheet">
</head>
<body>
	<header>
		<?php include("includes/header.php")?>
	</header>
    <main>
        <?php if(isset($_SESSION['user']['id_user']) AND $_SESSION['user']['account_type'] === 'admin'){?>

        <section class="banner">
        </section>

        <section class="forme stock_management" id="stock_management">
            <?php include("includes/admin_space_head_page.php"); ?>
            <div class="bar">
                <div class="progression-bar_stock">
                </div>
            </div>

            <?php

                if(isset($_POST['insert_product'])){
                   $product->register(
                        $_POST['category'],
                        $_POST['sub_category'],
                        $_POST['product_name'],
                        $_POST['description'],
                        $_POST['price'],
                        $_POST['size'],
                        $_POST['color'], 
                        $_POST['stock']    
                    );      

                }

                if(isset($_POST['delete_product'])){
                    $product->delete($_POST['id_product']);
                }
                        

            ?>
            
            

            <form action="" method="post" enctype="multipart/form-data" class="form_admin">
                <h1>Ajouter un produit</h1>
                <div class="form_admin_body">
                    <div class="form_admin_position">
                        <label for="category">Sélectionnez la catégorie du produit</label>
                        <select name="category" class="input_admin">
                            <option value="">--</option>
                            <option value="femme">Femme</option>
                            <option value="homme">Homme</option>
                            <option value="enfant">Enfant</option>
                        </select>

                        <label for="sub_category">Sélectionnez la sous-catégorie du produit</label>
                        <select name="sub_category" class="input_admin">
                            <option value="">--</option>
                            <option value="automne">Automne</option>
                            <option value="hiver">Hiver</option>
                            <option value="printemps">Printemps</option>
                            <option value="été">Été</option>
                        </select>

                        <label for="product_name">Entrez le nom du produit</label>
                        <input type="text" name="product_name" class="input_admin">

                        <label for="description">Entrez une descripton détaillée de votre produit</label>
                        <textarea type="textarea" name="description"></textarea>

                           
                    </div>

                    <div class="form_admin_position">
                        <label for="file">Choisir une photo</label>
                        <input id="file" type="file" name="picture" class="input_admin input_file">


                        <label for="price">Entrez le tarif</label>
                        <input type="number" name="price" step="0.01" class="input_admin">

                        <label for="color">Sélectionnez une couleur</label>
                        <select name="color" class="input_admin">
                            <option value="">--</option>
                            <option value="noir">noir</option>
                            <option value="blanc">blanc</option>
                            <option value="gris">gris</option>
                            <option value="rouge">rouge</option>
                            <option value="bleu">bleu</option>
                            <option value="vert">vert</option>
                            <option value="jaune">jaune</option>
                            <option value="beige">beige</option>
                            <option value="arc-en-ciel">arc-en-ciel</option>
                        </select>

                        <label for="size">Sélectionnez une taille</label>
                        <select name="size" class="input_admin">
                            <option value="">--</option>
                            <option value="unique">Unique</option>
                            <option value="XS">XS</option>
                            <option value="S">S</option>
                            <option value="M">M</option>
                            <option value="L">L</option>
                        </select>

                        <label for="stock">Entrez le nombre de produits disponibles en stock</label>
                        <input type="number" name="stock" class="input_admin">                    
                    </div>
                    
                </div>
                <div class="button_admin_position">
                    <input type="submit" name="insert_product" value="ENREGISTRER" class="button_admin">
                </div>
                
            </form>

            <?php    

                $connexion_db = $db->connectDb();

                $get_all_products = $connexion_db->prepare("SELECT 
                products.id_product,
                products.id_sub_category,
                products.id_category,
                products.product_name,
                products.description,
                products.picture,
                products.price, 
                product_details.size, 
                product_details.color, 
                stock_products.stock,

                product_details.id_product, 
                product_details.id_product_detail,
                stock_products.id_product_detail,

                categories.name_category,
                sub_categories.name_sub_category

                FROM 

                products, product_details, stock_products, categories, sub_categories

                WHERE  
                products.id_product = product_details.id_product 
                AND products.id_category = categories.id_category
                AND products.id_sub_category = sub_categories.id_sub_category
                AND product_details.id_product_detail = stock_products.id_product_detail

                ");

                $get_all_products->execute();
                $all_products = $get_all_products->fetchAll(PDO::FETCH_ASSOC);

            ?>

            <table class="table_products">
                <thead>
                    <tr>
                        <th>Catégorie</th>
                        <th>Sous catégorie</th>
                        <th>ID produit</th>
                        <th>Nom du produit</th>
                        <th>Description</th>
                        <th>Taille</th>
                        <th>Couleur</th>
                        <th>Prix unitaire</th>
                        <th>Stock</th>
                        <th>Image</th>
                        <th>Modifier</th>
                        <th>Supprimer</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($all_products as $info_products) {?>
                    <tr>
                        <td class="table_middle"><?php echo $info_products['name_category']?></td>
                        <td class="table_middle"><?php echo $info_products['name_sub_category']?></td>
                        <td class="table_middle"><?php echo $info_products['id_product'] ?></td>
                        <td><?php echo $info_products['product_name'] ?></td>
                        <td class="table_justify"><?php echo $info_products['description'] ?></td>
                        <td class="table_middle"><?php echo $info_products['size'] ?></td>
                        <td><?php echo $info_products['color'] ?></td>
                        <td class="table_middle"><?php echo $info_products['price']." €" ?></td>
                        <td class="table_middle"><?php echo $info_products['stock'] ?></td>
                        <td class="table_middle">
                            <img src="<?php echo $info_products['picture']?>" width="100">
                        </td>
                        <td class="table_middle">
                            <!-- CREATION "SOUS PAGE" POUR MODIFIER UNIQUEMENT LA LIGNE CONTENANT L'ID DU PRODUIT -->
                            <a href="stock_management.php?product_edit=<?php echo $info_products['id_product'] ?>#modify"><i class="fas fa-edit"></i></a>
                        </td>
                        <td class="table_middle">
                            <form method="post" action="">
                                <button type="submit" name="delete_product"><i class="fas fa-trash-alt"></i></button>
                                <!-- EFFACE UNIQUEMENT LA LIGNE CONTENANT L'ID DU PRODUIT -->
                                <input type="hidden" name="id_product" value="<?php echo $info_products['id_product'] ?>">
                            </form>
                        </td>
                    </tr><?php } ?>
                </tbody>
            </table>

            <?php 

                //FORM GENERE EN FONCTION DES INFORMATIONS TRANSMISES DANS LE HREF
                if (isset($_GET['product_edit'])) { 

                    $get_id_product = $_GET['product_edit'];

                     

                    if(isset($_POST['update_product'])){
                    $product->update(
                        $_POST['category'],
                        $_POST['sub_category'],
                        $_POST['product_name'],
                        $_POST['description'],
                        $_POST['price'],
                        $_POST['size'],
                        $_POST['color'], 
                        $_POST['stock'], 
                        $_POST['id_product']
                        );







                }



                    ?>

                <form method="post" action="" enctype="multipart/form-data" class="form_admin">
                    <h1 id="modify">Modifier le produit n°<?php echo $get_id_product ?></h1>
                    <div class="form_admin_body">
                        <div class="form_admin_position">
                            <label for="category">Sélectionner une nouvelle catégorie de produit</label>
                            <select name="category" class="input_admin">
                                <option value="">--</option>
                                <option value="1">Femme</option>
                                <option value="2">Homme</option>
                                <option value="3">Enfant</option>
                            </select>

                            <label for="sub_category">Sélectionner une nouvelle sous-catégorie de produit</label>
                            <select name="sub_category" class="input_admin">
                                <option value="">--</option>
                                <option value="1">Automne</option>
                                <option value="2">Hiver</option>
                                <option value="3">Printemps</option>
                                <option value="4">Été</option>
                            </select>

                            <label for="product_name">Entrez un nouveau nom de produit</label>
                            <input type="text" name="product_name" class="input_admin">

                            <label for="description">Entrez une nouvelle descripton du produit</label>
                            <textarea type="textarea" name="description"></textarea>
                        </div>
                        <div class="form_admin_position">
                            <label for="file">Choisissez une nouvelle photo</label>
                            <input id="file" type="file" name="picture" class="input_admin input_file">

                            <label for="price">Entrez un nouveau tarif</label>
                            <input type="number" name="price" step="0.01" class="input_admin">

                            <label for="color">Sélectionnez une nouvelle couleur</label>
                            <select name="color" class="input_admin">
                                <option value="">--</option>
                                <option value="noir">noir</option>
                                <option value="blanc">blanc</option>
                                <option value="gris">gris</option>
                                <option value="rouge">rouge</option>
                                <option value="bleu">bleu</option>
                                <option value="vert">vert</option>
                                <option value="jaune">jaune</option>
                                <option value="beige">beige</option>
                                <option value="arc-en-ciel">arc-en-ciel</option>
                            </select><br>

                            <label for="size">Sélectionnez une nouvelle taille</label>
                            <select name="size" class="input_admin">
                                <option value="">--</option>
                                <option value="unique">Unique</option>
                                <option value="XS">XS</option>
                                <option value="S">S</option>
                                <option value="M">M</option>
                                <option value="L">L</option>
                            </select>

                            <label for="stock">Entrez le nombre de produits disponibles en stock</label>
                            <input type="number" name="stock" class="input_admin">

                            <!-- RECUPERATION DE L'ID DU PRODUIT ENVOYE PAR HREF-->
                            <input type="hidden" name="id_product" value="<?php echo $get_id_product ?>">
                        </div>
                    </div>
                    <div class="button_admin_position"><input type="submit" name="update_product" value="ENREGISTRER LES MODIFICATIONS" class="button_admin"></div>

                        
                        

                </form>



                

                <?php }
            ?>

            


        </section>
        <?php 

            }else{header('Location:index.php'); exit;}

        ?>
    </main>
    <footer>
        <?php include("includes/footer.php")?>
    </footer>
    <script type="text/javascript" src="js/modal.js"></script>
</body>
</html>

<?php ob_end_flush();?>