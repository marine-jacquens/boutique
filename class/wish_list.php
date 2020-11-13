<?php

class WishList{
	private $id_wish_list;
	public $id_product;
	private $id_user;
	public $saved_for_later;
	public $time_added;

	public function __construct($db)
  	{
    	$this->db = $db;
  	} 

	public function register($id_product,$id_user){

		$connexion_db = $this->db->connectDb();

		if(!empty($id_product AND $id_user)){

			$id_product_wishList = intval($id_product);
			$id_user_wishList = intval($id_user);
			$saved_for_later = true;
			date_default_timezone_set('Europe/Paris');
    		$time_added = date("Y-m-d H:i:s");

			//VERIFIER SI LE PRODUIT EST DEJA DANS LA WISHLIST DE L'UTILISATEUR
    		$check_wish_list = $connexion_db->prepare("SELECT * FROM  wish_list_items WHERE id_product = $id_product_wishList AND id_user = $id_user_wishList ");
    		$check_wish_list->execute();
    		$checked_wish_list = $check_wish_list->fetch(PDO::FETCH_ASSOC);

    		if(empty($checked_wish_list)){

    			$add_wish = "INSERT into wish_list_items (id_product,id_user,saved_for_later,time_added) VALUES (:id_product,:id_user,:saved_for_later,:time_added)";
				$execution_insert = $connexion_db->prepare($add_wish);
				$execution_insert->bindParam(':id_product',$id_product_wishList,PDO::PARAM_INT);
				$execution_insert->bindParam(':id_user',$id_user_wishList,PDO::PARAM_INT);
				$execution_insert->bindParam(':saved_for_later',$saved_for_later,PDO::PARAM_BOOL);
				$execution_insert->bindParam(':time_added',$time_added,PDO::PARAM_STR);

				$execution_insert->execute();

				$user_wish_list = $connexion_db->prepare("SELECT * FROM wish_list_items WHERE id_user = $id_user_wishList ");
		      	$user_wish_list->execute();
		      	$wish_list = $user_wish_list->fetch(PDO::FETCH_ASSOC);

    		}

			
		}
	}

	 public function disconnect()
	{
	    $this->id_wish_list = "";
	    $this->id_product = "";
	    $this->id_user = "";
	    $this->saved_for_later = "";
	    $this->time_added = "";
	    session_unset();
	    session_destroy();
	}











}

?>