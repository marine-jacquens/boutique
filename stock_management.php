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

                 




            ?>

            <table>
                <thead>
                    <tr>
                        <th>Nom du produit</th>
                        <th>Description</th>
                        <th>Taille</th>
                        <th>Couleur</th>
                        <th>Prix unitaire</th>
                        <th>Stock</th>
                        <th>Images</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>

            <h1>Ajouter un produit</h1>

            <form action="" method="post" enctype="multipart/form-data">

                <label for="category">Sélectionnez la catégorie du produit</label><br>
                <select name="category">
                    <option value="">--</option>
                    <option value="women">Femme</option>
                    <option value="men">Homme</option>
                    <option value="child">Enfant</option>
                </select><br>

                <label for="sub_category">Sélectionnez la sous-catégorie du produit</label><br>
                <select name="sub_category">
                    <option value="">--</option>
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
            <!-- <form enctype="multipart/form-data">
                <label for="file" class="label-file">Choisir une photo</label>
                <input id="file" type="file" name="photo" class="input-file">
                <input type="submit" name="send" value="ENVOYER">
                <button type="submit" name="delete"><i class="fas fa-trash-alt"></i></button>
            </form> -->

        </section>

    </main>
    <footer>
        <?php include("includes/footer.php")?>
    </footer>
    <script type="text/javascript" src="js/modal.js"></script>
</body>
</html>

<?php ob_end_flush();?>