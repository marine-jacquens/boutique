<?php 

session_start();

require 'class/database.php';
require 'class/users.php';
require 'class/products.php';
require 'class/administration.php';
require 'class/wish_list.php';
require 'class/cart.php';
require 'class/orders.php';
$db = new Database();
$user = new Users($db);
$product = new Products($db);
$admin = new Admin($db);
$wish = new WishList($db);
$cart = new Cart($db);
$order = new Orders($db);

// Product Details 
// Minimum amount is $0.50 US 

$itemName = "Demo Product"; 
// $itemNumber = "PN12345"; 
// $itemPrice = 25; 
 $currency = "EUR"; 

$db->connectDb();
 
//Stripe API configuration  
define('STRIPE_API_KEY', 'sk_test_51HHZr4KvPYTLb4IFcrqKGUxzQI01HJQKErY2dU2T09NK7S7KyNtrwKthVViQkap7vcUELeMlTLmPU3kmJvSGvPpT00MvkeqGTd'); 
define('STRIPE_PUBLISHABLE_KEY', 'pk_test_51HHZr4KvPYTLb4IFKwDIsoLYEE84frZKDiTta9QcDeoZa3Uf5CbWMtL8h7W7Jiu6xaHQvF703UoMOxNX5rYSmy7g004PjAn9ji'); 
  
// Database configuration  
define('DB_HOST', 'localhost'); 
define('DB_USERNAME', 'root'); 
define('DB_PASSWORD', 'root'); 
define('DB_NAME', 'boutique');

$bdd = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);  


?>