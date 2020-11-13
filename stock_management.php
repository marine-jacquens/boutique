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
                        $_POST['sub_category_2'],
                        $_POST['description_sub_category_2'],
                        $_POST['product_name'],
                        $_POST['description'],
                        $_POST['price'],
                        $_POST['size'],
                        $_POST['color'], 
                        $_POST['stock']    
                    );      

                }

            ?>

            <form action="" method="post" enctype="multipart/form-data" class="form_admin">
                <h1>Ajouter un produit</h1>
                <div class="form_admin_body">
                    <div class="form_admin_position">
                        <?php

                            $get_all_categories = $connexion_db->prepare("SELECT * FROM categories"); 
                            $get_all_categories->execute(); 

                            $get_all_sub_categories = $connexion_db->prepare("SELECT * FROM sub_categories"); 
                            $get_all_sub_categories->execute();

                            $get_all_sub_categories_2 = $connexion_db->prepare("SELECT DISTINCT name_sub_category_2 FROM sub_categories_2");
                            $get_all_sub_categories_2->execute();
                        ?>

                        <label for="category">Catégorie du produit</label>
                        <select name="category" class="input_admin">
                            <option value="">--</option>
                            <?php while($option = $get_all_categories->fetch()){?>
                            <option value="<?php echo $option['id_category'] ?>"><?php echo $option['name_category'] ?></option>
                            <?php } $get_all_categories->closeCursor();?>
                        </select>

                        <label for="sub_category">Sous-catégorie du produit</label>
                        <select name="sub_category" class="input_admin">
                            <option value="">--</option>
                            <?php while($option = $get_all_sub_categories->fetch()){?>
                            <option value="<?php echo $option['id_sub_category'] ?>"><?php echo $option['name_sub_category'] ?></option>
                            <?php } $get_all_sub_categories->closeCursor();?>
                        </select>

                        <label for="sub_category_2">Sous-catégorie 2 du produit</label>
                        <select name="sub_category_2" class="input_admin">
                            <option value="">--</option>
                            <?php while($option = $get_all_sub_categories_2->fetch()){?>
                            <option value="<?php echo $option['name_sub_category_2'] ?>"><?php echo $option['name_sub_category_2'] ?></option>
                            <?php } $get_all_sub_categories_2->closeCursor();?>
                        </select>
                       
                        <label for="description_sub_categories_2">Descripton de votre sous-catégorie 2</label>
                        <textarea type="textarea" name="description_sub_category_2"></textarea>
  
                    </div>

                    <div class="form_admin_position">

                        <label for="product_name">Nom du produit</label>
                        <input type="text" name="product_name" class="input_admin">

                        <label for="description">Descripton de votre produit</label>
                        <textarea type="textarea" name="description"></textarea>

                        <label for="file">Choisir une photo</label>
                        <input id="file" type="file" name="picture" class="input_admin input_file">


                        <label for="price">Entrez le tarif</label>
                        <input type="number" name="price" step="0.01" class="input_admin">

                                          
                    </div>
                    <div class="form_admin_position">
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

                        <label for="stock">Nombre de produits disponibles en stock</label>
                        <input type="number" name="stock" class="input_admin">  
                    </div>
                    
                </div>
                <div class="button_admin_position">
                    <input type="submit" name="insert_product" value="ENREGISTRER" class="button_admin">
                </div>
                
            </form>

            <?php

                //CREATION PAGINATION TABLEAU PRODUIT

                //définition du nbr de messages visibles par page
                $produitsParPage = 5; 
                //récupération du total des messages en bdd
                $total_produits = $connexion_db->prepare("SELECT COUNT(*) AS total FROM products, product_details, stock_products, categories, sub_categories, sub_categories_2 WHERE  
                products.id_product = product_details.id_product 
                AND products.id_sub_category_2 = sub_categories_2.id_sub_category_2
                AND sub_categories_2.id_category = categories.id_category
                AND sub_categories_2.id_sub_category = sub_categories.id_sub_category
                AND product_details.id_product_detail = stock_products.id_product_detail");
                $total_produits->execute();
                $donnees_total = $total_produits->fetch();
                $total = $donnees_total['total'];

                //calcul du nbr de pages à générer en fonction du nbr de messages souhaités par page et du nbr total de messages 
                $nombreDePages = ceil($total/$produitsParPage);// ceil => arrondit au nbr supérieur
                
                 
                if(isset($_GET['page'])) // Si la variable $_GET['page'] existe...
                {
                    $pageActuelle = intval($_GET['page']); // intval retourne un nombre entier
                 
                    if($pageActuelle > $nombreDePages) 
                    {
                        $pageActuelle = $nombreDePages;
                    }
                }
                else // Sinon
                {
                     $pageActuelle = 1; // La page actuelle est la n°1    
                }

                $premiereEntree = ($pageActuelle-1)*$produitsParPage; // On calcul la première entrée à lire
 
                // La requête sql pour récupérer les messages de la page actuelle.
                $retour_produits = $connexion_db->prepare('SELECT  
                products.id_product,
                products.id_sub_category_2,
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

                sub_categories_2.id_category,
                categories.id_category,
                sub_categories_2.id_sub_category,
                sub_categories.id_sub_category,
                sub_categories.name_sub_category,
                categories.name_category,
                sub_categories_2.id_sub_category_2,
                sub_categories_2.name_sub_category_2

                FROM products, product_details, stock_products, categories, sub_categories, sub_categories_2

                WHERE  
                products.id_product = product_details.id_product 
                AND products.id_sub_category_2 = sub_categories_2.id_sub_category_2
                AND sub_categories_2.id_category = categories.id_category
                AND sub_categories_2.id_sub_category = sub_categories.id_sub_category
                AND product_details.id_product_detail = stock_products.id_product_detail

                ORDER BY products.id_product DESC LIMIT '.$premiereEntree.', '.$produitsParPage.'');
                $retour_produits->execute();

            ?>


            <table class="table_admin" id="table_products">
                <thead>
                    <tr><th colspan="13" class="table_title">LES PRODUITS</th></tr>
                    <tr>
                        <th>Catégorie</th>
                        <th>Sous catégorie</th>
                        <th>Sous catégorie 2</th>
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
                    <?php while($donnees_messages = $retour_produits->fetch()) {?>
                    <tr>
                        <td class="table_middle"><?php echo $donnees_messages['name_category']?></td>
                        <td class="table_middle"><?php echo $donnees_messages['name_sub_category']?></td>
                        <td class="table_middle"><?php echo $donnees_messages['name_sub_category_2']?></td>
                        <td class="table_middle"><?php echo $donnees_messages['id_product'] ?></td>
                        <td><?php echo $donnees_messages['product_name'] ?></td>
                        <td class="table_justify"><?php echo $donnees_messages['description'] ?></td>
                        <td class="table_middle"><?php echo $donnees_messages['size'] ?></td>
                        <td><?php echo $donnees_messages['color'] ?></td>
                        <td class="table_middle"><?php echo $donnees_messages['price']." €" ?></td>
                        <td class="table_middle"><?php echo $donnees_messages['stock'] ?></td>
                        <td class="table_middle">
                            <img src="<?php echo $donnees_messages['picture']?>" width="100">
                        </td>
                        <td class="table_middle">
                            <!-- CREATION "SOUS PAGE" POUR MODIFIER UNIQUEMENT LA LIGNE CONTENANT L'ID DU PRODUIT -->
                            <a href="stock_management.php?product_edit=<?php echo $donnees_messages['id_product'] ?>#modify"><i class="fas fa-edit"></i></a>
                        </td>

                        <?php 
                            if(isset($_POST['delete_product'])){
                                $product->delete($_POST['id_product']);
                            }
                        ?>
                        <td class="table_middle">
                            <form method="post" action="">
                                <button type="submit" name="delete_product"><i class="fas fa-trash-alt"></i></button>
                                <!-- EFFACE UNIQUEMENT LA LIGNE CONTENANT L'ID DU PRODUIT -->
                                <input type="hidden" name="id_product" value="<?php echo $donnees_messages['id_product'] ?>">
                            </form>
                        </td>
                    </tr><?php } ?>
                </tbody>
            </table>

            <?php
                echo '<p class="pagination">';
                for($i=1; $i<=$nombreDePages; $i++)
                {
                
                     if($i==$pageActuelle) //S'il s'agit de la page actuelle...
                     {
                         echo '<span class="actual_page">'.$i.'</span> '; 
                     }    
                     else //Sinon...
                     {
                          echo ' <a href="stock_management.php?page='.$i.'#table_products" class="other_pages">'.$i.'</a> ';
                     }
                }
                echo '</p>';
             


                //FORM GENERE EN FONCTION DES INFORMATIONS TRANSMISES DANS LE HREF
                if (isset($_GET['product_edit'])) { 

                    $get_id_product = $_GET['product_edit'];

                     

                    if(isset($_POST['update_product'])){
                    $product->update(
                        $_POST['category'],
                        $_POST['sub_category'],
                        $_POST['sub_category_2'],
                        $_POST['description_sub_category_2'],
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
                            <?php

                                $get_all_categories = $connexion_db->prepare("SELECT * FROM categories"); 
                                $get_all_categories->execute(); 

                                $get_all_sub_categories = $connexion_db->prepare("SELECT * FROM sub_categories"); 
                                $get_all_sub_categories->execute();

                                $get_all_sub_categories_2 = $connexion_db->prepare("SELECT DISTINCT name_sub_category_2 FROM sub_categories_2");
                                $get_all_sub_categories_2->execute();
                        

                            ?>
                            <label for="category">Nouvelle catégorie </label>
                            <select name="category" class="input_admin">
                                <option value="">--</option>
                                <?php while($option = $get_all_categories->fetch()){?>
                                <option value="<?php echo $option['id_category'] ?>"><?php echo $option['name_category'] ?></option>
                                <?php } $get_all_categories->closeCursor();?>
                            </select>

                            <label for="sub_category">Nouvelle sous-catégorie de niveau 1 </label>
                            <select name="sub_category" class="input_admin">
                                <option value="">--</option>
                                <?php while($option = $get_all_sub_categories->fetch()){?>
                                <option value="<?php echo $option['id_sub_category'] ?>"><?php echo $option['name_sub_category'] ?></option>
                                <?php } $get_all_sub_categories->closeCursor();?>
                            </select>

                            <label for="sub_category_2">Sous-catégorie de niveau 2</label>
                            <select name="sub_category_2" class="input_admin">
                                <option value="">--</option>
                                <?php while($option = $get_all_sub_categories_2->fetch()){?>
                                <option value="<?php echo $option['name_sub_category_2'] ?>"><?php echo $option['name_sub_category_2'] ?></option>
                                <?php } $get_all_sub_categories_2->closeCursor();?>
                            </select>

                            <label for="description_sub_categories_2">Descripton de votre sous-catégorie 2</label>
                            <textarea type="textarea" name="description_sub_category_2"></textarea>
                            
                        </div>

                        <div class="form_admin_position">

                            <label for="product_name">Nom de produit</label>
                            <input type="text" name="product_name" class="input_admin">

                            <label for="description">Descripton du produit</label>
                            <textarea type="textarea" name="description"></textarea>

                            <label for="file">Nouvelle photo</label>
                            <input id="file" type="file" name="picture" class="input_admin input_file">

                            <label for="price">Nouveau tarif</label>
                            <input type="number" name="price" step="0.01" class="input_admin">

                        </div>

                        <div class="form_admin_position">

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
                            </select>

                            <label for="size">Sélectionnez une nouvelle taille</label>
                            <select name="size" class="input_admin">
                                <option value="">--</option>
                                <option value="unique">Unique</option>
                                <option value="XS">XS</option>
                                <option value="S">S</option>
                                <option value="M">M</option>
                                <option value="L">L</option>
                            </select>

                            <label for="stock">Nombre de produits disponibles en stock</label>
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