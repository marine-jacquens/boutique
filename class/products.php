<?php

class Products
{
	public $category;
	public $sub_category;
	public $id_product;
	public $product_name;
	public $description;
	public $picture;
	public $price;
	public $id_product_detail;
	public $size;
	public $color;
	public $id_stock_product;
	public $stock;

	public function __construct($db)
  	{
    $this->db = $db;
  	}

  	public function register($category, $sub_category, $product_name,$description,$price,$size,$color,$stock){

	  	$connexion_db = $this->db->connectDb();

	  	if($_SERVER["REQUEST_METHOD"] == "POST"){

	  		// Vérifie si le fichier a été uploadé sans erreur.
	        if(isset($_FILES["picture"]) && $_FILES["picture"]["error"] == 0){
	        	$allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png");
	            $filename = $_FILES["picture"]["name"];
	            $filetype = $_FILES["picture"]["type"];
	            $filesize = $_FILES["picture"]["size"];            

	            // Vérifie l'extension du fichier
	            $ext = pathinfo($filename, PATHINFO_EXTENSION);

	            if(!array_key_exists($ext, $allowed)) die("<span>Erreur: Veuillez sélectionner un format de fichier valide.</span>");
	            // Vérifie la taille du fichier - 5Mo maximum
	            $maxsize = 5 * 1024 * 1024;

	            if($filesize > $maxsize) die("<span>Erreur: La taille du fichier est supérieure à la limite autorisée.</span>");

	            // Vérifie le type MIME du fichier
	            if(in_array($filetype, $allowed)){

		            // Vérifie si le fichier existe avant de le télécharger.
		            if(file_exists("uploads/".$_FILES["picture"]["name"])){
		                echo $_FILES["picture"]["name"] . " existe déjà.";
		            }
		            else{
		                move_uploaded_file($_FILES["picture"]["tmp_name"], "uploads/" . $_FILES["picture"]["name"]);
		            } 
		        }                          
		        else{
		            echo "<span>Erreur: Il y a eu un problème de téléchargement de votre fichier. Veuillez réessayer.</span>";
		        }
		    }
		    else{
		    	//voir les types d'erreurs sur => https://www.php.net/manual/fr/features.file-upload.errors.php
		        echo "<span>Erreur " . $_FILES["picture"]["error"] . "</span> <br>";
		    }
	    }

	    if(!empty($category && $sub_category && $product_name && $description && $price && $size && $color && $stock)){

	  		$get_id_category = $connexion_db->prepare("SELECT id_category FROM categories WHERE name = '$category' ");
	      	$get_id_category->execute();
	      	$id_category_checked = $get_id_category->fetch(PDO::FETCH_ASSOC);
	      	$id_category = intval($id_category_checked['id_category']);

	      	$get_id_sub_category = $connexion_db->prepare("SELECT id_sub_category FROM sub_categories WHERE name = '$sub_category' ");
	      	$get_id_sub_category->execute();
	      	$id_sub_category_checked = $get_id_sub_category->fetch(PDO::FETCH_ASSOC);
	      	$id_sub_category = intval($id_sub_category_checked['id_sub_category']);

	    	//DEFINITION DES VARIABLES STOCKANT LA PHOTO ET LE CHEMIN VERS LA PHOTO
	        $file_name=$_FILES["picture"]["name"];
	        $picture="uploads/$file_name";

	  		$insert_product = "INSERT into products (id_category,id_sub_category,product_name,description,picture,price) VALUES (:id_category,:id_sub_category,:product_name,:description,:picture,:price)";
	  		$exec_insert_product = $connexion_db->prepare($insert_product);
	  		$exec_insert_product->bindParam(':id_category',$id_category,PDO::PARAM_INT);
	  		$exec_insert_product->bindParam(':id_sub_category',$id_sub_category,PDO::PARAM_INT);
	        $exec_insert_product->bindParam(':product_name',$product_name,PDO::PARAM_STR); 
	        $exec_insert_product->bindParam(':description',$description,PDO::PARAM_STR);
	        $exec_insert_product->bindParam(':picture',$picture,PDO::PARAM_STR);
	        $exec_insert_product->bindParam(':price',$price,PDO::PARAM_INT);
	        $exec_insert_product->execute();

	        $get_id_product = $connexion_db->prepare("SELECT id_product FROM products WHERE product_name = '$product_name' ");
	      	$get_id_product->execute();
	      	$id_product_checked = $get_id_product->fetch(PDO::FETCH_ASSOC);
	      	$id_product = intval($id_product_checked['id_product']);

	        $insert_detail_product = "INSERT into product_details (id_product,size,color) VALUES (:id_product,:size,:color)";
	  		$exec_insert_detail_product = $connexion_db->prepare($insert_detail_product);
	        $exec_insert_detail_product->bindParam(':id_product',$id_product,PDO::PARAM_INT); 
	        $exec_insert_detail_product->bindParam(':size',$size,PDO::PARAM_STR);
	        $exec_insert_detail_product->bindParam(':color',$color,PDO::PARAM_STR);
	        $exec_insert_detail_product->execute();

	        $get_id_product_detail = $connexion_db->prepare("SELECT id_product_detail FROM product_details WHERE id_product = $id_product ");
	      	$get_id_product_detail->execute();
	      	$id_product_detail_checked = $get_id_product_detail->fetch(PDO::FETCH_ASSOC);
	      	$id_product_detail = intval($id_product_detail_checked['id_product_detail']);

	        $insert_stock_product = "INSERT into stock_products (id_product,id_product_detail,product_name,stock) VALUES (:id_product,:id_product_detail,:product_name,:stock)";
	  		$exec_insert_stock_product = $connexion_db->prepare($insert_stock_product);
	        $exec_insert_stock_product->bindParam(':id_product',$id_product,PDO::PARAM_INT); 
	        $exec_insert_stock_product->bindParam(':id_product_detail',$id_product_detail,PDO::PARAM_INT);
	        $exec_insert_stock_product->bindParam(':product_name',$product_name,PDO::PARAM_STR);
	        $exec_insert_stock_product->bindParam(':stock',$stock,PDO::PARAM_INT);
	        $exec_insert_stock_product->execute();


			header('Location:stock_management.php#stock_management.php');
		}
		else{
		  	echo '<span>Veuillez remplir tous les champs</span>';
		} 

  	}








}



?>

