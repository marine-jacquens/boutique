<?php

class Orders
{
	private $id_bill_address;
	private $id_user; 
	private $bill_address;
	public $bill_city;
	public $bill_postcode;
	public $bill_country;
	private $firstname;
	private $lastname;
	private $id_delivery_address;
	private $delivery_address;
	public $delivery_city;
	public $delivery_postcode;
	public $delivery_country;
	private $phone;
	private $mail;

	public function __construct($db)
  	{
    	$this->db = $db;
  	}

  	public function register($id_user,$lastname,$firstname,$bill_address,$bill_postcode,$bill_city,$bill_country,$delivery_address,$delivery_city,$delivery_country,$delivery_postcode,$phone,$mail,$amount)
  	{

  		$connexion_db = $this->db->connectDb();

  		//ENREGISTRER LES INFORMATIONS DANS LA BDD
  		if(!empty($id_user && $lastname && $firstname && $bill_address && $bill_postcode && $bill_city && $bill_country && $delivery_address && $delivery_city && $delivery_country && $delivery_postcode && $phone && $mail && $amount))
  		{

  			$new_delivery_address = " INSERT into deliveries_addresses (id_user,delivery_address,delivery_city,delivery_country,delivery_postcode,firstname,lastname,phone,mail) VALUES (:id_user,:delivery_address,:delivery_city,:delivery_country,:delivery_postcode,:firstname,:lastname,:phone,:mail) ";
  			$insert_delivery_address=$connexion_db->prepare($new_delivery_address);
  			$insert_delivery_address->bindParam(':id_user',intval($id_user),PDO::PARAM_INT);
  			$insert_delivery_address->bindParam(':delivery_address',$delivery_address,PDO::PARAM_STR);
  			$insert_delivery_address->bindParam(':delivery_city',$delivery_city,PDO::PARAM_STR);
  			$insert_delivery_address->bindParam(':delivery_country',$delivery_country,PDO::PARAM_STR);
  			$insert_delivery_address->bindParam(':delivery_postcode',$delivery_postcode,PDO::PARAM_STR);
  			$insert_delivery_address->bindParam(':firstname',$firstname,PDO::PARAM_STR);
  			$insert_delivery_address->bindParam(':lastname',$lastname,PDO::PARAM_STR);
  			$insert_delivery_address->bindParam(':phone',$phone,PDO::PARAM_STR);
  			$insert_delivery_address->bindParam(':mail',$mail,PDO::PARAM_STR);
  			$insert_delivery_address->execute();

  			$new_bill_address = " INSERT into bills_addresses (id_user,bill_address,bill_city,bill_country,bill_postcode,firstname,lastname, phone,mail) VALUES (:id_user,:bill_address,:bill_city,:bill_country,:bill_postcode,:firstname,:lastname,:phone,:mail) ";
  			$insert_bill_address=$connexion_db->prepare($new_bill_address);
  			$insert_bill_address->bindParam(':id_user',intval($id_user),PDO::PARAM_INT);
  			$insert_bill_address->bindParam(':bill_address',$bill_address,PDO::PARAM_STR);
  			$insert_bill_address->bindParam(':bill_city',$bill_city,PDO::PARAM_STR);
  			$insert_bill_address->bindParam(':bill_country',$bill_country,PDO::PARAM_STR);
  			$insert_bill_address->bindParam(':bill_postcode',$bill_postcode,PDO::PARAM_STR);
  			$insert_bill_address->bindParam(':firstname',$firstname,PDO::PARAM_STR);
  			$insert_bill_address->bindParam(':lastname',$lastname,PDO::PARAM_STR);
  			$insert_bill_address->bindParam(':phone',$phone,PDO::PARAM_STR);
  			$insert_bill_address->bindParam(':mail',$mail,PDO::PARAM_STR);
  			$insert_bill_address->execute();

  			//SELECTION DES ID BILL ET DELIVERIES DE LA COMMANDE EN COURS
  			$get_id_delivery = $connexion_db->prepare("SELECT * FROM deliveries_addresses LIMIT 0,1");
  			$get_id_delivery->execute();
  			$delivery_info = $get_id_delivery->fetch(PDO::FETCH_ASSOC);
  			$id_delivery = intval($delivery_info['id_delivery_address']);

  			$get_id_bill = $connexion_db->prepare("SELECT * FROM bills_addresses LIMIT 0,1");
  			$get_id_bill->execute();
  			$bill_info = $get_id_bill->fetch(PDO::FETCH_ASSOC);
  			$id_bill = intval($bill_info['id_bill_address']);

			  date_default_timezone_set('Europe/Paris');
  			$date_created = date("Y-m-d H:i:s");
  			$status = "en attente de validation";

  			$new_order = "INSERT into orders (id_user,id_bill_address,id_delivery_address,date_created,status,amount) VALUES (:id_user,:id_bill_address,:id_delivery_address,:date_created,:status,:amount) ";
  			$insert_order = $connexion_db->prepare($new_order);
  			$insert_order->bindParam(':id_user',intval($id_user),PDO::PARAM_INT);
  			$insert_order->bindParam(':id_bill_address',intval($id_bill),PDO::PARAM_INT);
  			$insert_order->bindParam(':id_delivery_address',intval($id_delivery),PDO::PARAM_INT);
  			$insert_order->bindParam(':date_created',$date_created,PDO::PARAM_STR);
  			$insert_order->bindParam(':status',$status,PDO::PARAM_STR);
  			$insert_order->bindParam(':amount',intval($amount),PDO::PARAM_INT);
  			$insert_order->execute();

        //RECUPERATION DU NUMERO DE COMMANDE
        $get_id_order = $connexion_db->prepare(" SELECT * FROM orders LIMIT 0,1 ");
        $get_id_order->execute();
        $order = $get_id_order->fetch(PDO::FETCH_ASSOC);
        $id_order = intval($order['id_order']);

  			//RECUPERERATION ITEMS ET QUANTITE
  			$saved_for_later = true;

  			$get_items = $connexion_db->prepare(" SELECT * FROM cart_items WHERE id_user = $id_user AND saved_for_later = $saved_for_later ");
  			$get_items->execute();

  			while($item = $get_items->fetch()){

  				$new_order_item = "INSERT into order_items (id_order,id_product_detail,quantity) VALUES (:id_order,:id_product_detail,:quantity) ";
  				$insert_order_item = $connexion_db->prepare($new_order_item); 
  				$insert_order_item->bindParam(':id_order',$id_order,PDO::PARAM_INT);
  				$insert_order_item->bindParam(':id_product_detail',intval($item['id_product_detail']),PDO::PARAM_INT);
  				$insert_order_item->bindParam(':quantity',intval($item['quantity']),PDO::PARAM_INT);
  				$insert_order_item->execute();

          //SUPPRIMER LE PANIER 
          $saved_for_later = false;
          $id_product_detail = intval($item['id_product_detail']);

          $new_cart = " UPDATE cart_items SET saved_for_later = :saved_for_later WHERE id_product_detail = $id_product_detail AND id_user = $id_user ";
          $update_cart = $connexion_db->prepare($new_cart);
          $update_cart->bindParam(':saved_for_later',$saved_for_later,PDO::PARAM_BOOL); 
          $update_cart->execute();



  			}



  			header('Location:order.php');
  			




  		}else{echo"<span>Veuillez remplir tous les champs</span>";}
  	}

}

?>