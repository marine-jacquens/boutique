<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
    <title>Boutique - Page catégorie produits</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/x-icon" href="images/logo.png">
    <link rel="stylesheet" href="fontawesome/all.css">
    <link rel="stylesheet" href="css/general.css">
    <link rel="stylesheet" href="css/check_payment.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200&display=swap" rel="stylesheet">
</head>
<body class="checkPaymentBackground">


<?php
// Include configuration file  
require_once 'config.php';

$payment_id = $statusMsg = '';
$ordStatus = 'error';
$id_user = $_SESSION['user']['id_user'];

$check_cart = $cart->checkStock($id_user);

if ($check_cart == "success") {

// Vérifier si le token de stripe n'est pas vide
    if (!empty($_POST['stripeToken'])) {


        //Récupére le token de stripe, la carte et les informations sur l'utilisateur à partir des données du formulaire soumis.
        $token = $_POST['stripeToken'];
        $name = strip_tags($_POST['name']);
        $totalAmount = intval($_POST['amount']);
        $email = strip_tags($_POST['mail']);
        $lastname = strip_tags($_POST['lastname']);
        $firstname = strip_tags($_POST['firstname']);
        $bill_address = strip_tags($_POST['bill_address']);
        $bill_postcode = strip_tags($_POST['bill_postcode']);
        $bill_city = strip_tags($_POST['bill_city']);
        $bill_country = strip_tags($_POST['bill_country']);
        $delivery_address = strip_tags($_POST['delivery_address']);
        $delivery_city = strip_tags($_POST['delivery_city']);
        $delivery_country = strip_tags( $_POST['delivery_country']);
        $delivery_postcode = strip_tags($_POST['delivery_postcode']);
        $phone = strip_tags($_POST['phone']);
        $mail = strip_tags($_POST['mail']);
        $amount = strip_tags($_POST['amount']);



        // Inclut la bibliothèque PHP de Stripe
        require_once 'stripe-php/init.php';

        // Définition de la clé API
        \Stripe\Stripe::setApiKey(STRIPE_API_KEY);

        // Ajout d'un client sur stripe
        try {
            $customer = \Stripe\Customer::create(array(
                'email' => $email,
                'source' => $token
            ));
        } catch (Exception $e) {
            $api_error = $e->getMessage();
        }

        if (empty($api_error) && $customer) {

            // Conversion du prix en centimes
            $itemPriceCents = ($totalAmount * 100);

            // Chargez une carte de crédit ou de débit
            try {

                $charge = \Stripe\Charge::create(array(
                    'customer' => $customer->id,
                    'amount' => $itemPriceCents,
                    'currency' => $currency,
                    'description' => $name

                ));
            } catch (Exception $e) {

                $api_error = $e->getMessage();
            }

            if (empty($api_error) && $charge) {

                // Récupération détails de la charge
                $chargeJson = $charge->jsonSerialize();

                // Vérifie sur la charge est un succès
                if ($chargeJson['amount_refunded'] == 0 && empty($chargeJson['failure_code']) && $chargeJson['paid'] == 1 && $chargeJson['captured'] == 1) {


                    // Transaction details
                    $transactionID = $chargeJson['balance_transaction'];
                    $paidAmount = $chargeJson['amount'];
                    $paidAmount = ($paidAmount / 100);
                    $paidCurrency = $chargeJson['currency'];
                    $payment_status = $chargeJson['status'];


                    // Insertion des données de transaction dans la bdd
                    $payment_id = $order->register(
                        $id_user,
                        $lastname,
                        $firstname,
                        $bill_address,
                        $bill_postcode,
                        $bill_city,
                        $bill_country,
                        $delivery_address,
                        $delivery_city,
                        $delivery_country,
                        $delivery_postcode,
                        $phone,
                        $mail,
                        $amount,
                        $name,
                        $transactionID,
                        $payment_status

                    );


                    // Si la commande est un succès
                    if ($payment_status === 'succeeded') {
                        $ordStatus = 'success';
                        $statusMsg = 'Votre achat a bien été pris en compte!';
                    } else {
                        $statusMsg = "Votre achat a échoué!";
                    }
                } else {
                    $statusMsg = "La transaction a échoué!";
                }
            } else {
                $statusMsg = "Echec de la transaction! $api_error";
            }
        } else {
            $statusMsg = " Informations de la carte invalides! $api_error";
        }
    } else {
        $statusMsg = "Erreur de soumission.";
    }
    ?>

    <div class="containerCheckPayment">
        <div class="status">
            <?php if (!empty($payment_id)) { ?>
                <h1 class="<?php echo $ordStatus; ?>"><?php echo $statusMsg; ?></h1>

                <h4>Information achat</h4>
                <p>Numéro de commande : <?php echo $payment_id; ?></p>
                <p>Numéro de transaction : <?php echo $transactionID; ?></p>
                <p>Montant total : <?php echo $paidAmount . ' ' . $paidCurrency; ?></p>
                <p>Statut du paiement: <?php echo "réussi"; ?></p>

                <h4>Informations complémentaires</h4>
                <p>Nom de l'acheteur : <?php echo $name; ?></p>
                <p>Adresse de livraison
                    : <?php echo $_POST['delivery_address'] . ' ' . $_POST['delivery_city'] . ' ' . $_POST['delivery_postcode']; ?></p>
            <?php } else { ?>
                <h1 class="error">Votre paiement a échoué</h1>
            <?php } ?>
        </div>
        <a href="order.php?id_user=<?php echo $id_user ?>" class="btn-link">Retour aux commandes</a>
    </div>

<?php } else { ?>
    <article class="containerCheckPayment">
        <h1>Le ou les produits ci-dessous sont momentanéments indisponibles, veuillez retenter plus tard. Votre carte
            n'a pas été débitée.</h1>
        <?php $cart->refresh($id_user);?>
        <p><?php echo $check_cart; ?></p>
        <a href='index.php'>Rafraîchir mon panier</a>
    </article>
    <?php
}

?>


<script type='text/javascript' src='config.js'></script>
<script type="text/javascript" src="js/payment.js"></script>
</body>
</html>