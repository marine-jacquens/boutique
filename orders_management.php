<?php
	ob_start();
?>

<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
	<title>Boutique - Accueil</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=image">
    <link rel="shortcut icon" type="image/x-icon" href="images/logo.png">
    <link rel="stylesheet" href="fontawesome/all.css">
    <link rel="stylesheet" href="css/general.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" type="text/css" href="css/admin_space_head_page.css">
    <link rel="stylesheet" href="css/admin_general.css">
    <link rel="stylesheet" href="css/footer.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200&display=swap" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
	<header>
		<?php include("includes/header.php")?>
	</header>
	<main>
		<section class="banner">
        </section>
        <section class="forme orders_management" id="orders_management">
        	<?php include("includes/admin_space_head_page.php"); ?>
        	<div class="bar">
                <div class="progression-bar_orders"></div>
            </div>

            <?php 

                if(isset($_SESSION['user']['id_user']) && $_SESSION['user']['account_type'] == "admin"){}else{header('Location:index.php');exit;};

            	//RECUPERER LES COMMANDES 
            	$get_orders = $connexion_db->prepare(" SELECT DISTINCT users.*,orders.*,deliveries_addresses.*,bills_addresses.* FROM users,orders,deliveries_addresses,bills_addresses WHERE users.id_user = orders.id_user AND orders.id_delivery_address = deliveries_addresses.id_delivery_address AND orders.id_bill_address = bills_addresses.id_bill_address ORDER BY date_created DESC ");
            	$get_orders->execute();
                $orders_info = $get_orders->fetchAll(PDO::FETCH_ASSOC);

            	if(!empty($orders_info)){
            ?>
            <table class="table_admin order" id="table_orders">
            	<thead>
            		<tr>
            			<th colspan="8" class="table_title">GESTION DES COMMANDES</th>
            		</tr>
            		<tr>
            			<th>N°commande</th>
            			<th>Id user</th>
            			<th>Adresse</th>
            			<th>Produit(s)</th>
            			<th>Total</th>
            			<th>Statut</th>
                        <th>Dernière mise à jour</th>
            		</tr>
            	</thead>
            	<tbody>
            		<?php foreach($orders_info as $order_info){ ?>
            		<tr>
            			<td class="table_middle"><?php echo $order_info['id_order'] ?></td>
            			<td class="table_middle"><?php echo $order_info['id_user'] ?></td>
            			<td class="address_info">
            				<?php 
            				echo '<strong>Destinataire</strong> :  '.$order_info['lastname'].' '.$order_info['firstname'].'<br> <strong>Livraison</strong> :  '.$order_info['delivery_address'].' '.$order_info['delivery_postcode'].' '.$order_info['delivery_city'].' '.$order_info['delivery_country'].'<br> 
            					<strong>Facturation</strong> :  '.$order_info['bill_address'].' '.$order_info['bill_postcode'].' '.$order_info['bill_city'].' '.$order_info['bill_country'] ;
            				?>
            				
            			</td>

            			<?php 
            				$id_order = $order_info['id_order'];
            				$get_products_order = $connexion_db->prepare(" SELECT DISTINCT products.*, order_items.*, product_details.*,orders.* FROM products,order_items,product_details,orders WHERE order_items.id_order = $id_order AND order_items.id_order = orders.id_order AND product_details.id_product_detail = order_items.id_product_detail AND product_details.id_product = products.id_product ORDER BY date_created DESC ");
            				$get_products_order->execute();
                            $products_order = $get_products_order->fetchAll(PDO::FETCH_ASSOC);
            				
            			?>
            			<td class="product_info">
            				<?php foreach($products_order as $products){
            				 echo ' <i class="fas fa-circle"></i> n°'.$products['id_product'].' '.$products['product_name'].' _ taille '.$products['size'].' _ '.$products['color'].' _ € '.$products['price'].'(à l\'unité) x '.$products['quantity'].'<br>';
            				} ?>	
            			</td>
            			<td class="table_middle amount_position"><?php echo '€ '.$order_info['amount'] ?></td>
            			<td class="table_middle status_position" id="statusSize"><?php

            				switch($order_info['order_status']){
            					case $order_info['order_status'] == "pending" :
						        ?> <a href="orders_management.php?orders_edit=<?php echo $order_info['id_order'] ?>#order_edit" class="status pending">en attente</a><?php 
						        break;
    						    case $order_info['order_status'] == "processing" :
    						        ?> <a href="orders_management.php?orders_edit=<?php echo $order_info['id_order'] ?>#order_edit" class="status processing">en préparation</a><?php
    						        break;
    						    case $order_info['order_status'] == "shipped" :
    						        ?> <a href="orders_management.php?orders_edit=<?php echo $order_info['id_order'] ?>#order_edit" class="status shipped">expédiée</a><?php
    						        break;
    						    case $order_info['order_status'] == "delivered" :
    						        ?><a href="orders_management.php?orders_edit=<?php echo $order_info['id_order'] ?>#order_edit" class="status delivered">livrée</a><?php
    						        break;
    						    case $order_info['order_status'] == "cancelled" :
    						        ?> <a href="orders_management.php?orders_edit=<?php echo $order_info['id_order'] ?>#order_edit" class="status cancelled">annulée</a><?php
						        break;

            				}
            			?></td>
                        <td class="table_middle"><?php if(empty($order_info['date_modified'])){echo $order_info['date_created'] ; }else{echo $order_info['date_modified'] ; } ?></td>
            		</tr>
            		<?php } ?>
            	</tbody>

            </table>
            <?php } 

                if(isset($_GET['orders_edit'])){

                    $id_order = $_GET['orders_edit'];

                    if(isset($_POST['update_order'])){$order->update($_POST['id_order'],$_POST['status']);}?>

                    <form action="" method="POST" class="form_admin">
                        <h1 id="order_edit">Modifier le statut de la commande n°<?php echo $id_order ?></h1>
                        <div class="form_admin_body">
                            <div class="form_admin_position">
                                <label for="status">Sélectionnez un nouveau statut</label>
                                <select name="status" class="input_admin">
                                    <option value="">--</option>
                                    <option value="pending">En attente de validation</option>
                                    <option value="processing">En cours de préparation</option>
                                    <option value="shipped">Expédiée</option>
                                    <option value="delivered">Délivrée</option>
                                    <option value="cancelled">Annulée</option>
                                </select>
                                <input type="hidden" name="id_order" value="<?php echo $id_order ?>">
                            </div>
                        </div>
                        <div class="button_admin_position"><input type="submit" name="update_order" value="ENREGISTRER MODIFICATION" class="button_admin"></div>
                        
                        
                    </form>


               <?php }


            ?>


        </section>
	</main>
	<footer>
		<?php include("includes/footer.php")?>
	</footer>
	<script type="text/javascript" src="js/modal.js"></script>
    <script type="text/javascript" src="js/autocompletion.js"></script>
</body>
</html>

<?php ob_end_flush();?>