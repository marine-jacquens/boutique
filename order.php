<?php
ob_start();
?>

    <!DOCTYPE html>
    <html lang="fr" dir="ltr">
    <head>
        <title>Boutique - Profil</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, user-scalable=yes">
        <link rel="shortcut icon" type="image/x-icon" href="images/logo.png">
        <link rel="stylesheet" href="fontawesome/all.css">
        <link rel="stylesheet" href="css/general.css">
        <link rel="stylesheet" href="css/header.css">
        <link rel="stylesheet" href="css/footer.css">
        <link rel="stylesheet" href="css/personal_space_head_page.css">
        <link rel="stylesheet" href="css/order.css">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200&display=swap" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    </head>
    <body>
    <header>
        <?php include("includes/header.php") ?>
    </header>
    <main>
        <?php if (isset($_SESSION['user']['id_user']) && $_SESSION['user']['id_user'] == $_GET['id_user']) { ?>
            <section class="banner">
            </section>

            <section class="forme" id="detail_order">

                <?php include("includes/personal_space_head_page.php"); ?>
                <div class="profil_page_head">
                    <p>
                        <strong>MES COMMANDES</strong> <br><br>

                        Retrouvez dans cette section le détail de vos commandes et suivez ainsi les étapes
                        d'acheminement du produit.<br><br>

                    </p>
                </div>
                <div>
                    <?php
                    //RECUPERER LES COMMANDES DE L'UTILISATEUR
                    $get_orders_user = $connexion_db->prepare(" SELECT DISTINCT users.*,orders.*,deliveries_addresses.*,bills_addresses.* FROM users,orders,deliveries_addresses,bills_addresses WHERE users.id_user = $id_user AND orders.id_user = users.id_user AND orders.id_delivery_address = deliveries_addresses.id_delivery_address AND orders.id_bill_address = bills_addresses.id_bill_address ORDER BY date_created DESC ");
                    $get_orders_user->execute();
                    $orders_user_info = $get_orders_user->fetchAll(PDO::FETCH_ASSOC);


                    if (isset($_POST['update_order'])) {
                        $order->update($_POST['id_order'], $_POST['status']);
                    }
                    $status = "cancelled";


                    if (!empty($orders_user_info)) {
                        ?>
                        <table class="table_order_user">
                            <thead>
                            <tr>
                                <th>N°commande</th>
                                <th>Adresse</th>
                                <th>Produit(s)</th>
                                <th>Total</th>
                                <th>Statut</th>
                                <th>Dernière mise à jour</th>
                                <th>Annulation</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($orders_user_info as $order_user) { ?>
                                <tr>
                                    <td class="table_middle"><?php echo $order_user['id_order'] ?></td>
                                    <td class="address_info">
                                        <?php
                                        echo '<strong>Destinataire</strong> :  ' . $order_user['lastname'] . ' ' . $order_user['firstname'] . '<br> <strong>Livraison</strong> :  ' . $order_user['delivery_address'] . ' ' . $order_user['delivery_postcode'] . ' ' . $order_user['delivery_city'] . ' ' . $order_user['delivery_country'] . '<br> 
            					<strong>Facturation</strong> :  ' . $order_user['bill_address'] . ' ' . $order_user['bill_postcode'] . ' ' . $order_user['bill_city'] . ' ' . $order_user['bill_country'];
                                        ?>
                                    </td>
                                    <?php
                                    $id_order = $order_user['id_order'];
                                    $get_products_order = $connexion_db->prepare(" SELECT DISTINCT products.*, order_items.*, product_details.*,orders.* FROM products,order_items,product_details,orders WHERE orders.id_user = $id_user AND order_items.id_order = $id_order AND order_items.id_order = orders.id_order AND product_details.id_product_detail = order_items.id_product_detail AND product_details.id_product = products.id_product ORDER BY date_created DESC ");
                                    $get_products_order->execute();
                                    $products_order = $get_products_order->fetchAll(PDO::FETCH_ASSOC);

                                    ?>
                                    <td class="product_info">
                                        <?php foreach ($products_order as $products) {
                                            echo ' <i class="fas fa-circle"></i> n°' . $products['id_product'] . ' ' . $products['product_name'] . ' _ taille ' . $products['size'] . ' _ ' . $products['color'] . ' _ € ' . $products['price'] . '(à l\'unité) x ' . $products['quantity'] . '<br>';
                                        } ?>
                                    </td>
                                    <td class="price_td"><?php echo '€ ' . $order_user['amount'] ?></td>
                                    <td class="table_middle status_position"><?php

                                        switch ($order_user['order_status']) {
                                            case $order_user['order_status'] == "pending" :
                                                ?> <p class="status pending">en attente</p><?php
                                                break;
                                            case $order_user['order_status'] == "processing" :
                                                ?> <p class="status processing">en préparation</p><?php
                                                break;
                                            case $order_user['order_status'] == "shipped" :
                                                ?> <p class="status shipped">expédiée</p><?php
                                                break;
                                            case $order_user['order_status'] == "delivered" :
                                                ?><p class="status delivered">livrée</p><?php
                                                break;
                                            case $order_user['order_status'] == "cancelled" :
                                                ?> <p class="status cancelled">annulée</p><?php
                                                break;

                                        }
                                        ?></td>
                                    <td class="table_middle">
                                        <?php if (empty($order_user['date_modified'])) {
                                            echo $order_user['date_created'];
                                        } else {
                                            echo $order_user['date_modified'];
                                        } ?>
                                    </td>

                                    <td class="table_middle">
                                        <form action="" method="POST">
                                            <input type="hidden" name="id_order" value="<?php echo $id_order ?>">
                                            <input type="hidden" name="status" value="<?php echo $status ?>">
                                            <button type="submit" name="update_order" class="button_cancelled"><i
                                                        class="fal fa-trash-alt"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    <?php } else {
                        echo " Aucune commande n'a été enregistrée à ce jour ";
                    } ?>
                </div>
            </section>
        <?php } else {
            header('Location:index.php');
            exit;
        } ?>
    </main>
    <footer>
        <?php include("includes/footer.php") ?>
    </footer>
    <script type="text/javascript" src="js/modal.js"></script>
    <script type="text/javascript" src="js/autocompletion.js"></script>
    </body>
    </html>

<?php ob_end_flush(); ?>