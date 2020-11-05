<?php

class Products
{
	public $category;
	public $sub_category;
	public $sub_category_2;
	public $description_sub_category_2;
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

  	public function register($category, $sub_category,$sub_category_2,$description_sub_category_2, $product_name,$description,$price,$size,$color,$stock){

	  	$connexion_db = $this->db->connectDb();

	  	/*var_dump(intval($category));
	  	var_dump(intval($sub_category));
	  	var_dump($sub_category_2);
	  	var_dump($description_sub_category_2);*/


	    if(!empty($category && $sub_category && $sub_category_2 && $description_sub_category_2 && $product_name && $description && $price && $size && $color && $stock)){

	    	if($_SERVER["REQUEST_METHOD"] == "POST"){

	  		// Vérifie si le fichier image a été uploadé sans erreur.
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
		                /*echo $_FILES["picture"]["name"] . " existe déjà.";*/
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

	    // VERIFICATION EXISTENCE COMBINAISON DE L'ID CATEGORIE, ID SOUS CATEGORIE ET NOM DE LA SOUS CATEGORIE 2

	    	$id_category = intval($category);
	    	$id_sub_category = intval($sub_category);

	    	$check_sub_category = $connexion_db->prepare("SELECT * FROM sub_categories_2 WHERE id_category = $category AND id_sub_category = $sub_category AND name_sub_category_2 = '$sub_category_2' ");
	    	$check_sub_category->execute();
	    	$checked_sub_category = $check_sub_category->fetchAll(PDO::FETCH_ASSOC);


	    	if(empty($checked_sub_category[0])){

	    		//INSERTION DES ID CATEGORIE ET ID SOUS CATEGORIE DANS LA TABLE SOUS CATEGORIE 2

	    		$insert_sub_category = "INSERT into sub_categories_2 (id_category, id_sub_category, name_sub_category_2, description_sub_category_2) VALUES (:id_category,:id_sub_category,:name_sub_category_2,:description_sub_category_2) ";
	    		$exec_insert_sub_category = $connexion_db->prepare($insert_sub_category); 
	    		$exec_insert_sub_category->bindParam(':id_category',$id_category,PDO::PARAM_INT);
	    		$exec_insert_sub_category->bindParam(':id_sub_category',$id_sub_category,PDO::PARAM_INT);
	    		$exec_insert_sub_category->bindParam(':name_sub_category_2',$sub_category_2,PDO::PARAM_STR);
	    		$exec_insert_sub_category->bindParam(':description_sub_category_2',$description_sub_category_2,PDO::PARAM_STR);
	    		$exec_insert_sub_category->execute();
	    	}

	    	//DEFINITION DES VARIABLES STOCKANT LA PHOTO ET LE CHEMIN VERS LA PHOTO
	        $file_name=$_FILES["picture"]["name"];
	        $picture="uploads/$file_name";

	        //SELECTION DE L'ID DE LA SOUS CATEGORIE 2 CORRESPONDANT AUX FORMULAIRE
	        $get_id_sub_category_2 = $connexion_db->prepare("SELECT id_sub_category_2 FROM sub_categories_2 WHERE id_category = $id_category AND id_sub_category = $id_sub_category AND name_sub_category_2 = '$sub_category_2' "); 
	        $get_id_sub_category_2->execute();
	        $selected_id_sub_category_2 = $get_id_sub_category_2->fetch();
	        $id_sub_category_2 = intval($selected_id_sub_category_2[0]);

	  		$insert_product = "INSERT into products (id_sub_category_2,product_name,description,picture,price) VALUES (:id_sub_category_2,:product_name,:description,:picture,:price)";
	  		$exec_insert_product = $connexion_db->prepare($insert_product);
	  		$exec_insert_product->bindParam(':id_sub_category_2',$id_sub_category_2,PDO::PARAM_INT);
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


			/*header('Location:stock_management.php#stock_management.php');
			exit;*/
		}
		else{
		  	echo '<span>Veuillez remplir tous les champs</span>';
		} 

  	}

  	public function update($category, $sub_category, $product_name,$description,$price,$size,$color,$stock,$id_product)
  	{
  		$connexion_db = $this->db->connectDb();

  		if(!empty($category)){

		    $id_category = intval($category);

			$new_category = "UPDATE products SET id_category = :id_category WHERE id_product = $id_product ";
	      	$update_category = $connexion_db->prepare($new_category);
	      	$update_category->bindParam(':id_category',$id_category, PDO::PARAM_INT);
	      	$update_category->execute(); 

	    }

	    if(!empty($sub_category)){

	    	$id_sub_category = intval($sub_category);

		    $new_sub_category = "UPDATE products SET id_sub_category = :id_sub_category WHERE id_product = $id_product ";
	      	$update_sub_category = $connexion_db -> prepare($new_sub_category);
	      	$update_sub_category->bindParam(':id_sub_category',$id_sub_category, PDO::PARAM_INT);
	      	$update_sub_category->execute(); 
	    }

	    if(!empty($product_name)){

	    	$new_product_name = "UPDATE products SET product_name = :product_name WHERE id_product = $id_product ";
	      	$update_product_name = $connexion_db -> prepare($new_product_name);
	      	$update_product_name->bindParam(':product_name',$product_name, PDO::PARAM_STR);
	      	$update_product_name->execute(); 

	      	$new_product_name_stock = "UPDATE stock_products SET product_name = :product_name WHERE id_product = $id_product ";
	      	$update_product_name_stock = $connexion_db -> prepare($new_product_name_stock);
	      	$update_product_name_stock->bindParam(':product_name',$product_name, PDO::PARAM_STR);
	      	$update_product_name_stock->execute();
	    }

	    if(!empty($description)){

	    	$new_description = "UPDATE products SET description = :description WHERE id_product = $id_product ";
	      	$update_description = $connexion_db -> prepare($new_description);
	      	$update_description->bindParam(':description',$description, PDO::PARAM_STR);
	      	$update_description->execute(); 
	    }


  			

			

			 if($_SERVER["REQUEST_METHOD"] == "POST")
                   {
                        // Vérifie si le fichier a été uploadé sans erreur.
                        if(isset($_FILES["picture"]) && $_FILES["picture"]["error"] == 0){

                        	$file_name=$_FILES["picture"]["name"];
							$picture="uploads/$file_name";

							var_dump($picture);

							$new_picture = "UPDATE products SET picture = :picture WHERE id_product = $id_product ";
							$update_picture = $connexion_db -> prepare($new_picture);
							$update_picture->bindParam(':picture',$picture, PDO::PARAM_STR);
							$update_picture->execute();


                            $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png");
                            $filename = $_FILES["picture"]["name"];
                            $filetype = $_FILES["picture"]["type"];
                            $filesize = $_FILES["picture"]["size"];

                            // Vérifie l'extension du fichier
                            $ext = pathinfo($filename, PATHINFO_EXTENSION);
                            if(!array_key_exists($ext, $allowed)) die("Erreur : Veuillez sélectionner un format de fichier valide.<br>");
                            // Vérifie la taille du fichier - 5Mo maximum
                            $maxsize = 5 * 1024 * 1024;
                            if($filesize > $maxsize) die("Error: La taille du fichier est supérieure à la limite autorisée.<br>");
                            // Vérifie le type MIME du fichier
                            if(in_array($filetype, $allowed)){
                                // Vérifie si le fichier existe avant de le télécharger.
                                if(file_exists("uploads/".$_FILES["picture"]["name"])){
                                    echo $_FILES["picture"]["name"] . " existe déjà.";
                                }
                                else
                                {
                                    move_uploaded_file($_FILES["picture"]["tmp_name"], "uploads/" . $_FILES["picture"]["name"]);
                                    header('location:profil.php');
                                } 
                            }
                            else
                            {
                                echo "Error: Il y a eu un problème de téléchargement de votre fichier. Veuillez réessayer.<br>";
                                echo "Error: Téléchargement du fichier impossible. Veuillez réessayer.<br>";
                                        }
                        }
                        else
                        {
                            echo "Error: " . $_FILES["picture"]["error"];
                        }
                    } 

  		

	    if(!empty($price)){

	    	$new_price = "UPDATE products SET price = :price WHERE id_product = $id_product ";
	      	$update_price = $connexion_db -> prepare($new_price);
	      	$update_price->bindParam(':price',$price, PDO::PARAM_INT);
	      	$update_price->execute(); 
	    }

	    if(!empty($size)){

	    	$new_size = "UPDATE product_details SET size = :size WHERE id_product = $id_product ";
	      	$update_size = $connexion_db -> prepare($new_size);
	      	$update_size->bindParam(':size',$size, PDO::PARAM_STR);
	      	$update_size->execute(); 
	    }

	    if(!empty($color)){

	    	$new_color = "UPDATE product_details SET color = :color WHERE id_product = $id_product ";
	      	$update_color = $connexion_db -> prepare($new_color);
	      	$update_color->bindParam(':color',$color, PDO::PARAM_STR);
	      	$update_color->execute(); 
	    }

	    if(!empty($stock)){

	    	$new_stock = "UPDATE stock_products SET stock = :stock WHERE id_product = $id_product ";
	      	$update_stock = $connexion_db -> prepare($new_stock);
	      	$update_stock->bindParam(':stock',$stock, PDO::PARAM_STR);
	      	$update_stock->execute(); 
	    }

	  	header('Location:stock_management.php#stock_management.php');
	  	exit;


  		
	    
  	}

  	public function delete($id_product)
  	{
  		$connexion_db = $this->db->connectDb();

  		$delete_product = $connexion_db->prepare("DELETE FROM products WHERE id_product = $id_product");
        $delete_product->execute();


  	}








}



?>

