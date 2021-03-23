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

// Vérifier si le token de stripe n'est pas vide 
if (!empty($_POST['stripeToken'])) {


    //Récupére le token de stripe, la carte et les informations sur l'utilisateur à partir des données du formulaire soumis.
    $token = $_POST['stripeToken'];
    $name = $_POST['name'];
    $totalAmount = intval($_POST['amount']);
    $email = $_POST['mail'];
    $id_user = $_SESSION['user']['id_user'];

    // Include Stripe PHP library 
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


        // Convert price to cents 
        $itemPriceCents = ($totalAmount * 100);

        // Charge a credit or a debit card 
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


            // Retrieve charge details 
            $chargeJson = $charge->jsonSerialize();

            // Check whether the charge is successful 
            if ($chargeJson['amount_refunded'] == 0 && empty($chargeJson['failure_code']) && $chargeJson['paid'] == 1 && $chargeJson['captured'] == 1) {


                // Transaction details  
                $transactionID = $chargeJson['balance_transaction'];
                $paidAmount = $chargeJson['amount'];
                $paidAmount = ($paidAmount / 100);
                $paidCurrency = $chargeJson['currency'];
                $payment_status = $chargeJson['status'];


                // Insert transaction data into the database
                $payment_id = $order->register(
                    $id_user,
                    $_POST['lastname'],
                    $_POST['firstname'],
                    $_POST['bill_address'],
                    $_POST['bill_postcode'],
                    $_POST['bill_city'],
                    $_POST['bill_country'],
                    $_POST['delivery_address'],
                    $_POST['delivery_city'],
                    $_POST['delivery_country'],
                    $_POST['delivery_postcode'],
                    $_POST['phone'],
                    $_POST['mail'],
                    $_POST['amount'],
                    $name,
                    $transactionID,
                    $payment_status

                );


                // If the order is successful 
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
        $statusMsg = "Carte informations invalides! $api_error";
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
            <p>Adresse de livraison : <?php echo $_POST['delivery_address'] . ' ' . $_POST['delivery_city'] . ' ' . $_POST['delivery_postcode']; ?></p>
        <?php } else { ?>
            <h1 class="error">Votre paiement a échoué </h1>
        <?php } ?>
    </div>
    <a href="order.php?id_user=<?php echo $id_user ?>" class="btn-link">Retour aux commandes</a>
</div>
<script type='text/javascript' src='config.js'></script>
<script type="text/javascript" src="js/payment.js"></script>
</body>
</html>