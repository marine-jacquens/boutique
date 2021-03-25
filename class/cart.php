<?php

class Cart
{
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

    public function register($id_product_detail, $id_user)
    {

        $connexion_db = $this->db->connectDb();

        if (!empty($id_product_detail and $id_user)) {

            $id_product_detail_cart = intval($id_product_detail);
            $id_user_cart = intval($id_user);
            $saved_for_later = true;
            $quantity = 1;
            date_default_timezone_set('Europe/Paris');
            $time_added = date("Y-m-d H:i:s");

            //VERIFIER SI LE PRODUIT EST DEJA DANS LE CART DE L'UTILISATEUR
            $check_cart = $connexion_db->prepare("SELECT * FROM  cart_items WHERE id_product_detail = $id_product_detail_cart AND id_user = $id_user_cart ");
            $check_cart->execute();
            $checked_cart = $check_cart->fetch(PDO::FETCH_ASSOC);

            if (empty($checked_cart)) {

                $add_item = "INSERT into cart_items (id_product_detail,id_user,saved_for_later,quantity,time_added) VALUES (:id_product_detail,:id_user,:saved_for_later,:quantity,:time_added)";
                $execution_insert = $connexion_db->prepare($add_item);
                $execution_insert->bindParam(':id_product_detail', $id_product_detail_cart, PDO::PARAM_INT);
                $execution_insert->bindParam(':id_user', $id_user_cart, PDO::PARAM_INT);
                $execution_insert->bindParam(':saved_for_later', $saved_for_later, PDO::PARAM_BOOL);
                $execution_insert->bindParam(':quantity', $quantity, PDO::PARAM_INT);
                $execution_insert->bindParam(':time_added', $time_added, PDO::PARAM_STR);

                $execution_insert->execute();

                header("Refresh:0");
                exit;

            } /*$user_cart = $connexion_db->prepare("SELECT * FROM cart_items WHERE id_user = $id_user_wishList ");
		    $user_cart->execute();
		    $cart = $user_cart->fetch(PDO::FETCH_ASSOC);*/

            elseif (!empty($checked_cart) and $checked_cart['saved_for_later'] == false) {

                $new_cart = " UPDATE cart_items SET saved_for_later = :saved_for_later, quantity = :quantity, time_added = :time_added WHERE id_product_detail = $id_product_detail_cart AND id_user = $id_user_cart ";
                $update_cart = $connexion_db->prepare($new_cart);
                $update_cart->bindParam(':saved_for_later', $saved_for_later, PDO::PARAM_BOOL);
                $update_cart->bindParam(':quantity', $quantity, PDO::PARAM_INT);
                $update_cart->bindParam(':time_added', $time_added, PDO::PARAM_STR);
                $update_cart->execute();

                header("Refresh:0");
                exit;

            } else {
                echo "<span>Ce produit figure déjà dans votre panier</span>";
            }


        } else {
            echo "<span>Veuillez sélectionner une taille</span>";
        }

    }

    public function removeCart($id_product_detail, $id_user)
    {

        $connexion_db = $this->db->connectDb();

        $saved_for_later = false;

        $new_cart = " UPDATE cart_items SET saved_for_later = :saved_for_later WHERE id_product_detail = $id_product_detail AND id_user = $id_user ";
        $update_cart = $connexion_db->prepare($new_cart);
        $update_cart->bindParam(':saved_for_later', $saved_for_later, PDO::PARAM_BOOL);
        $update_cart->execute();

        header("Refresh:0");
        exit;

    }

    public function update($quantity, $id_user, $id_product_detail)
    {

        $connexion_db = $this->db->connectDb();

        $qt = intval($quantity);
        date_default_timezone_set('Europe/Paris');
        $time_added = date("Y-m-d H:i:s");

        $new_cart = " UPDATE cart_items SET quantity = :quantity, time_added = :time_added WHERE id_product_detail = $id_product_detail AND id_user = $id_user ";
        $update_cart = $connexion_db->prepare($new_cart);
        $update_cart->bindParam(':quantity', $qt, PDO::PARAM_INT);
        $update_cart->bindParam(':time_added', $time_added, PDO::PARAM_STR);
        $update_cart->execute();

        header("Refresh:0");
        exit;

    }

    public function delete()
    {

        $connexion_db = $this->db->connectDb();

        //SUPPRIMER LES ITEMS TROP ANCIEN DU TABLEAU DE LISTES D'ENVIES
        $get_cart_list = $connexion_db->prepare(" SELECT time_added FROM cart_items");
        $get_cart_list->execute();

        while ($time = $get_cart_list->fetch()) {

            $jour = $time['time_added'];
            $check_date = date("Y-m-d H:i:s", strtotime($jour . '+ 1 year'));


            $delete_cart_list = $connexion_db->prepare(" DELETE FROM cart_items WHERE time_added >= '$check_date' ");
            $delete_cart_list->execute();

            header("Location:account_management.php#table_account_cart");
            exit;

        }
    }

    public function getCartAmount($id_user)
    {

        $connexion_db = $this->db->connectDb();

        $saved_for_later = true;

        $get_cart_amount = $connexion_db->prepare("SELECT 
							products.id_product,
							products.price, 

							cart_items.id_product_detail,
							cart_items.id_user,
							cart_items.saved_for_later,
							cart_items.quantity, 

							product_details.id_product_detail,
							product_details.id_product,   

							SUM(products.price*cart_items.quantity) AS total 

							FROM products, product_details, cart_items 

							WHERE cart_items.id_user = ? AND 
							cart_items.saved_for_later = $saved_for_later AND 
							products.id_product = product_details.id_product AND 
							product_details.id_product_detail = cart_items.id_product_detail GROUP BY products.id_product,products.price, 

							cart_items.id_product_detail,
							cart_items.id_user,
							cart_items.saved_for_later,
							cart_items.quantity, 

							product_details.id_product_detail,
							product_details.id_product");

        $get_cart_amount->execute([$id_user]);

        $totalAmountCart = 0;

        while ($itemsCart = $itemsPrice = $get_cart_amount->fetch()) {

            $totalAmountCart += $itemsCart['total'];

        }

        return $totalAmountCart;

    }

    public function checkStock($id_user)
    {

        $connexion_db = $this->db->connectDb();
        $saved_for_later = true;

        //SELECTION DES ARTICLES DU PANIER
        $check_cart = $connexion_db->prepare("SELECT * FROM  cart_items WHERE id_user = ? AND saved_for_later = ?");
        $check_cart->execute([$id_user, $saved_for_later]);

        //VERIFIE SI LE STOCK DE CHAQUE PRODUIT EST ENCORE DISPO
        while ($checked_cart = $check_cart->fetch(PDO::FETCH_ASSOC)) {
            $id_detail = $checked_cart['id_product_detail'];

            $get_stock = $connexion_db->prepare("SELECT * FROM  stock_products WHERE  id_product_detail = ?");
            $get_stock->execute([$id_detail]);

            while($stockItem = $get_stock->fetch(PDO::FETCH_ASSOC)){

                if ($stockItem['stock'] >= $checked_cart['quantity']) {
                    return "success";
                } else {
                    return $stockItem['product_name']."<br>";
                }

            }



        }
    }

    public function refresh($id_user){

        $connexion_db = $this->db->connectDb();
        $quantity = 0;
        $saved_for_later = 0;

        $refresh_cart = $connexion_db->prepare(" UPDATE cart_items SET quantity = ?, saved_for_later = ? WHERE id_user = ? ");
        $refresh_cart ->execute([$quantity,$saved_for_later,$id_user]);




    }


}