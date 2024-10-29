<?php
// proxy.php

if (isset($_GET['txId'])) {
    $txId = $_GET['txId'];
    $url = "https://api.tronscan.org/api/transaction-info?hash={$txId}";
    $response = file_get_contents($url);
    echo $response;
} else {
    echo json_encode(["error" => "Transaction ID not provided."]);
}
?>
