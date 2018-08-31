<?php 

session_start();
require_once("lib/autoload.php");

if(file_exists(__DIR__ . "/../.env")){
	$dotenv = new Dotenv\Dotenv(__DIR__ . "/../");
	$dotenv->load();
}

// Braintree_Configuration::environment('sandbox');
// Braintree_Configuration::merchantId('d5nmcbkhfszypcyv');
// Braintree_Configuration::publicKey('3f8n8ksnxkzw6q9f');
//Braintree_Configuration::privateKey('9d8e7983afd007268d78bdd0ddc5a2fe');
$gateway = new Braintree_Gateway([
  'environment' => 'sandbox',
  'merchantId' => 'd5nmcbkhfszypcyv',
  'publicKey' => '3f8n8ksnxkzw6q9f',
  'privateKey' => '9d8e7983afd007268d78bdd0ddc5a2fe'
]);
 ?>

