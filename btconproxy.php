<?php
// proxy_btc_to_usd.php

$url = "https://api.blockcypher.com/v1/btc/main"; // BlockCypher BTC rate

// Use cURL to make the request
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

// Output the response
echo $response;
?>
