<?php 

require_once("braintree_init.php");
require_once("lib/Braintree.php");

echo($clientToken = $gateway->clientToken()->generate());
//echo($clientToken = "sandbox_z38zgf98_d5nmcbkhfszypcyv");


 ?>