<?php
	ob_start();
	session_start();
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

            	//RECUPERER LES COMMANDES 
            	$get_orders = $connexion_db->prepare(" SELECT DISTINCT orders.*,order_items.*,deliveries_addresses.*,bills_addresses.* FROM orders,order_items,deliveries_addresses,bills_addresses WHERE orders.id_order = order_items.id_order AND orders.id_delivery_address = deliveries_addresses.id_delivery_address AND orders.id_bill_address = bills_addresses.id_bill_address  ORDER BY date_created DESC ");
            	$get_orders->execute();

            	if(!empty($get_orders->fetch())){
            ?>
            <table class="table_admin" id="table_orders">
            	<thead>
            		<tr>
            			<th colspan="8" class="table_title">LES COMMANDES</th>
            		</tr>
            		<tr>
            			<th>N°commande</th>
            			<th>Id user</th>
            			<th>Adresse</th>
            			<th>Produit(s)</th>
            			<th>Total</th>
            			<th>Statut</th>
            			<th>Modifier</th>
            			<th>Annuler</th>
            		</tr>
            	</thead>
            	<tbody>
            		<?php while($order = $get_orders->fetch()){ ?>
            		<tr>
            			<td><?php echo $order['id_order'] ?></td>
            			<td class="table_middle"><?php echo $order['id_user'] ?></td>
            			<td>
            				<?php 
            				echo 'Livraison :  '.$order['delivery_address'].' '.$order['delivery_postcode'].' '.$order['delivery_city'].' '.$order['delivery_country'].'<br> 
            					Facturation :  '.$order['bill_address'].' '.$order['bill_postcode'].' '.$order['bill_city'].' '.$order['bill_country'] 
            				?>
            				
            			</td>

            			<?php 
            				$id_order = $order['id_order'];
            				$get_products_order = $connexion_db->prepare(" SELECT DISTINCT products.*, order_items.*, product_details.*,orders.* FROM products,order_items,product_details,orders WHERE order_items.id_order = $id_order AND order_items.id_order = orders.id_order AND product_details.id_product_detail = order_items.id_product_detail AND product_details.id_product = products.id_product ORDER BY date_created DESC ");
            				$get_products_order->execute();
            				
            			?>
            			<td>
            				<?php while($products = $get_products_order->fetch()){
            				 echo ' - n°'.$products['id_product'].' '.$products['product_name'].' _ '.$products['size'].' _ '.$products['color'].' x'.$products['quantity'].'<br>';
            				} ?>	
            			</td>
            			<td class="table_middle"><?php echo '€'.$order['amount'] ?></td>
            			<td class="table_middle"><?php

            				switch($order['status']){
            					case $order['status'] == "en attente de validation" :
						        ?> <p class="status pending">en attente</p> <?php 
						        break;
						    case $order['status'] == "validée - en préparation" :
						        ?> <p class="status processing">en préparation</p> <?php
						        break;
						    case $order['status'] == "en cours d'expédition" :
						        ?> <p class="status shipped">expédiée</p> <?php
						        break;
						    case $order['status'] == "livrée" :
						        ?> <p class="status delivered">livrée</p> <?php
						        break;
						    case $order['status'] == "annulée" :
						        ?> <p class="status cancelled">annulée</p> <?php
						        break;

            				}
            			?></td>
            			<td class="table_middle">
            				<!-- CREATION "SOUS PAGE" POUR MODIFIER UNIQUEMENT LA LIGNE CONTENANT L'ID DE LA COMMANDE -->
                            <a href="orders_management.php?orders_edit=<?php echo $order['id_order'] ?>#order_edit"><i class="fas fa-edit"></i></a>
                        </td>
                         <?php 
                            if(isset($_POST['canceled_order'])){
                                $order->cancel($_POST['id_order']);
                            }
                        ?>
                        <td class="table_middle">
                            <form method="post" action="">
                                <button type="submit" name="canceled_order"><i class="fal fa-times-circle"></i></button>
                                <!-- EFFACE UNIQUEMENT LA LIGNE CONTENANT L'ID DU PRODUIT -->
                                <input type="hidden" name="id_order" value="<?php echo $order['id_order'] ?>">
                            </form>
                        </td>
            		</tr>
            		<?php } ?>
            	</tbody>

            </table>
            <?php } ?>
        </section>
	</main>
	<footer>
		<?php include("includes/footer.php")?>
	</footer>
	<script type="text/javascript" src="js/modal.js"></script>
</body>
</html>

<?php ob_end_flush();?>