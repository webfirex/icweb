<?php
// proxy_btc.php

if (isset($_GET['txId'])) {
    $txId = $_GET['txId'];
    $url = "https://api.blockcypher.com/v1/btc/main/txs/" . $txId;

    // Use cURL to make the request
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

    // Output the response
    echo $response;
} else {
    echo json_encode(["error" => "Transaction ID not provided."]);
}
?>
