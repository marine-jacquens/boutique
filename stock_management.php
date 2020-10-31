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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200&display=swap" rel="stylesheet">
</head>
<body>
	<header>
		<?php include("includes/header.php")?>
	</header>
    <main>
        <?php if(isset($_SESSION['user']['id_user']) AND $_SESSION['user']['id_user'] = 'admin'){?>

        <section class="banner">
        </section>

        <section class="profil" id="stock_management">

            <?php

                include("includes/admin_space_head_page.php");

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

            <h1>Ajouter un produit</h1>

            <form action="" method="post" enctype="multipart/form-data">

                <label for="category">Sélectionnez la catégorie du produit</label><br>
                <select name="category">
                    <option value="" disabled selected>--</option>
                    <option value="women">Femme</option>
                    <option value="men">Homme</option>
                    <option value="child">Enfant</option>
                </select><br>

                <label for="sub_category">Sélectionnez la sous-catégorie du produit</label><br>
                <select name="sub_category">
                    <option value="" disabled selected>--</option>
                    <option value="influencer">Influenceuses</option>
                    <option value="series">Les séries</option>
                    <option value="movies">Les films</option>
                    <option value="music">Musique</option>
                </select><br>

                <label for="product_name">Entrez le nom du produit</label><br>
                <input type="text" name="product_name"><br>

                <label for="description">Entrez une descripton détaillée de votre produit</label><br>
                <textarea type="textarea" name="description"></textarea><br>

                <label for="file">Choisir une photo</label><br>
                <input id="file" type="file" name="picture" class="input-file"><br>

                <label for="price">Entrez le prix</label><br>
                <input type="number" name="price" step="0.01"><br>

                <label for="color">Sélectionnez une couleur</label><br>
                <select name="color">
                    <option value="">--</option>
                    <option value="noir">noir</option>
                    <option value="blanc">blanc</option>
                    <option value="gris">gris</option>
                    <option value="rouge">rouge</option>
                    <option value="bleu">bleu</option>
                    <option value="vert">vert</option>
                    <option value="jaune">jaune</option>
                </select><br>

                <label for="size">Sélectionnez une taille</label><br>
                <select name="size">
                    <option value="">--</option>
                    <option value="unique">Unique</option>
                    <option value="XS">XS</option>
                    <option value="S">S</option>
                    <option value="M">M</option>
                    <option value="L">L</option>
                </select><br>

                <label for="stock">Entrez le nombre de produits disponibles en stock</label><br>
                <input type="number" name="stock"><br>

                <input type="submit" name="insert_product" value="ENREGISTRER">
            </form>

            <?php    

                $connexion_db = $db->connectDb();

                $get_all_products = $connexion_db->prepare("SELECT 
                products.id_product,
                product_details.id_product, 
                stock_products.id_product, 
                product_details.id_product_detail,
                stock_products.id_product_detail,
                 
                products.id_category, 
                products.id_sub_category, 
                products.product_name, 
                products.description,
                products.picture, 
                products.price, 
                product_details.size, 
                product_details.color, 
                stock_products.stock

                FROM 

                products, product_details, stock_products

                WHERE  
                products.id_product = product_details.id_product 
                AND products.id_product = product_details.id_product
                AND products.id_product = stock_products.id_product
                AND product_details.id_product_detail = stock_products.id_product_detail

                ");

                $get_all_products->execute();
                $all_products = $get_all_products->fetchAll(PDO::FETCH_ASSOC);

            ?>

            <table>
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
                        <td>
                            <?php

                            switch($info_products['id_category'])
                            {
                                case 1 : 
                                echo "femme";
                                break; 

                                case 2 : 
                                echo "homme";
                                break;

                                case 3 : 
                                echo "enfant";
                                break;

                                default:
                                echo "catégorie non définit";
                            }
                            ?>
                        </td>
                        <td>
                            <?php
                            switch($info_products['id_sub_category'])
                            {
                                case 1 : 
                                echo "influenceur";
                                break; 

                                case 2 : 
                                echo "séries";
                                break;

                                case 3 : 
                                echo "films";
                                break;

                                default:
                                echo "musique";
                            } 
                             
                            ?>
                        </td>
                        <td><?php echo $info_products['id_product'] ?></td>
                        <td><?php echo $info_products['product_name'] ?></td>
                        <td><?php echo $info_products['description'] ?></td>
                        <td><?php echo $info_products['size'] ?></td>
                        <td><?php echo $info_products['color'] ?></td>
                        <td><?php echo $info_products['price']." €" ?></td>
                        <td><?php echo $info_products['stock'] ?></td>
                        <td>
                            <img src="<?php echo $info_products['picture']?>" width="100">
                        </td>
                        <td>
                            <!-- CREATION "SOUS PAGE" POUR MODIFIER UNIQUEMENT LA LIGNE CONTENANT L'ID DU PRODUIT -->
                            <a href="stock_management.php?product_edit=<?php echo $info_products['id_product'] ?>#modify">MODIFIER</a>
                        </td>
                        <td>
                            <form method="post" action="">
                                <button type="submit" name="delete_product"><i class="far fa-trash-alt"></i></button>
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

                <form method="post" action="" enctype="multipart/form-data">
                    <h3 id="modify">Modifier ce produit</h3><br/>
                    <label for="category">Sélectionner une nouvelle catégorie du produit</label><br>
                    <select name="category">
                        <option value="">--</option>
                        <option value="1">Femme</option>
                        <option value="2">Homme</option>
                        <option value="3">Enfant</option>
                    </select><br>

                        <label for="sub_category">Sélectionner une nouvelle sous-catégorie du produit</label><br>
                        <select name="sub_category">
                            <option value="">--</option>
                            <option value="1">Influenceuses</option>
                            <option value="2">Les séries</option>
                            <option value="3">Les films</option>
                            <option value="4">Musique</option>
                        </select><br>

                        <label for="product_name">Entrez un nouveau nom du produit</label><br>
                        <input type="text" name="product_name"><br>

                        <label for="description">Entrez une nouvelle descripton du produit</label><br>
                        <textarea type="textarea" name="description"></textarea><br>

                        <label for="file">Choisir une nouvelle photo</label><br>
                        <input id="file" type="file" name="picture" class="input-file"><br>

                        <label for="price">Entrez un nouveau prix</label><br>
                        <input type="number" name="price" step="0.01"><br>

                        <label for="color">Sélectionnez une nouvelle couleur</label><br>
                        <select name="color">
                            <option value="">--</option>
                            <option value="noir">noir</option>
                            <option value="blanc">blanc</option>
                            <option value="gris">gris</option>
                            <option value="rouge">rouge</option>
                            <option value="bleu">bleu</option>
                            <option value="vert">vert</option>
                            <option value="jaune">jaune</option>
                        </select><br>

                        <label for="size">Sélectionnez une taille</label><br>
                        <select name="size">
                            <option value="">--</option>
                            <option value="unique">Unique</option>
                            <option value="XS">XS</option>
                            <option value="S">S</option>
                            <option value="M">M</option>
                            <option value="L">L</option>
                        </select><br>

                        <label for="stock">Entrez le nombre de produits disponibles en stock</label><br>
                        <input type="number" name="stock"><br>

                        <!-- RECUPERATION DE L'ID DU PRODUIT ENVOYE PAR HREF-->
                        <input type="hidden" name="id_product" value="<?php echo $get_id_product ?>">
                        <input type="submit" name="update_product" value="ENREGISTRER LES MODIFICATIONS">

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