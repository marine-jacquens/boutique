<?php

class Cart{
	private $id_cart_item;
	public $id_product;
	private $id_user;
	public $saved_for_later;
	public $quantity;
	public $time_added;

	public function __construct($db)
  	{
    	$this->db = $db;
  	} 

  	public function register($id_product_detail,$id_user){

  		$connexion_db = $this->db->connectDb();

		if(!empty($id_product_detail AND $id_user)){

			$id_product_detail_cart = intval($id_product_detail );
			$id_user_cart = intval($id_user);
			$saved_for_later = true;
			$quantity = 1 ;
			date_default_timezone_set('Europe/Paris');
    		$time_added = date("Y-m-d H:i:s");

			//VERIFIER SI LE PRODUIT EST DEJA DANS LE CART DE L'UTILISATEUR
    		$check_cart = $connexion_db->prepare("SELECT * FROM  cart_items WHERE id_product_detail = $id_product_detail_cart AND id_user = $id_user_cart ");
    		$check_cart->execute();
    		$checked_cart = $check_cart->fetch(PDO::FETCH_ASSOC);

    		if(empty($checked_cart)){

    			$add_item = "INSERT into cart_items (id_product_detail,id_user,saved_for_later,quantity,time_added) VALUES (:id_product_detail,:id_user,:saved_for_later,:quantity,:time_added)";
				$execution_insert = $connexion_db->prepare($add_item);
				$execution_insert->bindParam(':id_product_detail',$id_product_detail_cart,PDO::PARAM_INT);
				$execution_insert->bindParam(':id_user',$id_user_cart,PDO::PARAM_INT);
				$execution_insert->bindParam(':saved_for_later',$saved_for_later,PDO::PARAM_BOOL);
				$execution_insert->bindParam(':quantity',$quantity,PDO::PARAM_INT);
				$execution_insert->bindParam(':time_added',$time_added,PDO::PARAM_STR);

				$execution_insert->execute();

				header("Refresh:0");
	    		exit;

    		}

    		/*$user_cart = $connexion_db->prepare("SELECT * FROM cart_items WHERE id_user = $id_user_wishList ");
		    $user_cart->execute();
		    $cart = $user_cart->fetch(PDO::FETCH_ASSOC);*/

    		elseif(!empty($checked_cart) AND $checked_cart['saved_for_later'] == false){

    			$new_cart = " UPDATE cart_items SET saved_for_later = :saved_for_later, quantity = :quantity, time_added = :time_added WHERE id_product_detail = $id_product_detail_cart AND id_user = $id_user_cart ";
    			$update_cart = $connexion_db->prepare($new_cart);
	    		$update_cart->bindParam(':saved_for_later',$saved_for_later,PDO::PARAM_BOOL); 
	    		$update_cart->bindParam(':quantity',$quantity,PDO::PARAM_INT);
	    		$update_cart->bindParam(':time_added',$time_added,PDO::PARAM_STR); 
	    		$update_cart->execute();

	    		header("Refresh:0");
	    		exit;

    		}else{echo "<span>Ce produit figure déjà dans votre panier</span>" ; }

			
		}else{echo "<span>Veuillez sélectionner une taille</span>" ; }

  	}

  	public function removeCart($id_product_detail,$id_user){

	 	$connexion_db = $this->db->connectDb();

		$saved_for_later = false;
		date_default_timezone_set('Europe/Paris');
    	$time_added = date("Y-m-d H:i:s");

    	$new_cart = " UPDATE cart_items SET saved_for_later = :saved_for_later, time_added = :time_added WHERE id_product_detail = $id_product_detail AND id_user = $id_user ";
    	$update_cart = $connexion_db->prepare($new_cart);
	    $update_cart->bindParam(':saved_for_later',$saved_for_later,PDO::PARAM_BOOL); 
	    $update_cart->bindParam(':time_added',$time_added,PDO::PARAM_STR); 
	    $update_cart->execute();

	    header("Refresh:0");
	    exit;

	}

	public function update($quantity,$id_product_detail,$id_user){

	 	$connexion_db = $this->db->connectDb();

	 	$qt=intval($quantity);
		date_default_timezone_set('Europe/Paris');
    	$time_added = date("Y-m-d H:i:s");

    	$new_cart = " UPDATE cart_items SET quantity = :quantity, time_added = :time_added WHERE id_product_detail = $id_product_detail AND id_user = $id_user ";
    	$update_cart = $connexion_db->prepare($new_cart);
    	$update_cart->bindParam(':quantity',$qt,PDO::PARAM_STR);
	    $update_cart->bindParam(':time_added',$time_added,PDO::PARAM_STR); 
	    $update_cart->execute();

	    header("Refresh:0");
	    exit;

	}




}