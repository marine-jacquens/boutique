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

  	public function register($id_user,$lastname,$firstname,$bill_address,$bill_postcode,$bill_city,$bill_country,$id_delivery_address,$delivery_city,$delivery_country,$delivery_postcode,$phone,$mail,$total)
  	{

  		$connexion_db = $this->db->connectDb();

  		//ENREGISTRER LES INFORMATIONS DANS LA BDD
  		if(!empty($id_user && $lastname && $firstname && $bill_address && $bill_postcode && $bill_city && $bill_country && $id_delivery_address && $delivery_city && $delivery_country && $delivery_postcode && $phone && $mail && $total))
  		{

  			$new_delivery_address = " INSERT into deliveries_addresses (id_user,delivery_address,city,country,postcode,fistname,lastname, phone,mail) VALUES (:id_user,:delivery_address,:city,:country,:postcode,:fistname,:lastname,:phone,mail) ";
  			$insert_delivery_address=$connexion_db->prepare($new_delivery_address);
  			$insert_delivery_address->bindParam(':id_user',intval($id_user),PDO::PARAM_INT);
  			$insert_delivery_address->bindParam(':delivery_address',$delivery_address,PDO::PARAM_STR);
  			$insert_delivery_address->bindParam(':city',$delivery_city,PDO::PARAM_STR);
  			$insert_delivery_address->bindParam(':country',$delivery_country,PDO::PARAM_STR);
  			$insert_delivery_address->bindParam(':postcode',$delivery_postcode,PDO::PARAM_STR);
  			$insert_delivery_address->bindParam(':fistname',$firstname,PDO::PARAM_STR);
  			$insert_delivery_address->bindParam(':lastname',$lastname,PDO::PARAM_STR);
  			$insert_delivery_address->bindParam(':phone',$phone,PDO::PARAM_STR);
  			$insert_delivery_address->bindParam(':mail',$mail,PDO::PARAM_STR);
  			$insert_delivery_address->execute();

  			$new_bill_address = " INSERT into bill_addresses (id_user,bill_address,city,country,postcode,fistname,lastname, phone,mail) VALUES (:id_user,:bill_address,:city,:country,:postcode,:fistname,:lastname,:phone,mail) ";
  			$insert_bill_address=$connexion_db->prepare($new_delivery_address);
  			$insert_bill_address->bindParam(':id_user',intval($id_user),PDO::PARAM_INT);
  			$insert_bill_address->bindParam(':bill_address',$bill_address,PDO::PARAM_STR);
  			$insert_bill_address->bindParam(':city',$bill_city,PDO::PARAM_STR);
  			$insert_bill_address->bindParam(':country',$bill_country,PDO::PARAM_STR);
  			$insert_bill_address->bindParam(':postcode',$bill_postcode,PDO::PARAM_STR);
  			$insert_bill_address->bindParam(':fistname',$firstname,PDO::PARAM_STR);
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

  			$new_order = "INSERT into orders (id_user,id_bill_address,id_delivery_address,date_created,date_modified,status,amount) VALUES (:id_user,:id_bill_address,:id_delivery_address,:date_created,:status,:amount) ";
  			$insert_order = $connexion_db->prepare($new_order);
  			$insert_order->bindParam(':id_user',intval($id_user),PDO::PARAM_INT);
  			$insert_order->bindParam(':id_bill_address',intval($id_bill_address),PDO::PARAM_INT);
  			$insert_order->bindParam(':id_delivery_address',intval($id_delivery_address),PDO::PARAM_INT);
  			$insert_order->bindParam(':date_created',$date_created,PDO::PARAM_STR);
  			$insert_order->bindParam(':status',$status,PDO::PARAM_STR);
  			$insert_order->bindParam(':amount',$total,PDO::PARAM_INT);
  			$insert_order->execute();

  			//RECUPERERATION ITEMS ET QUANTITE

  			$saved_for_later = true;

  			$get_items = $connexion_db->prepare(" SELECT * FROM cart_items WHERE id_user = $id_user AND saved_for_later = $saved_for_later ");
  			$get_items->execute();

  			while($item = $get_items->fetch()){

  				$new_order_item = "INSERT into order_items (id_order,id_product_detail,quantity) VALUES (:id_order,:id_product_detail,:quantity) ";
  				$insert_order_item = $connexion_db->prepare($new_order_item); 
  				$insert_order_item->bindParam(':id_order',intval($id_user),PDO::PARAM_INT);
  				$insert_order_item->bindParam(':id_product_detail',intval($item['id_product_detail']),PDO::PARAM_INT);
  				$insert_order_item->bindParam(':quantity',intval($item['quantity']),PDO::PARAM_INT);
  				$insert_order_item->execute();

  			}

  			header('Location:order.php');
  			




  		}else{echo"<span>Veuillez remplir tous les champs</span>";}
  	}

}

?>