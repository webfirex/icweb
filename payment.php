<?php

  require_once "includes/order.inc.php";
  require_once "includes/class_autoloader.php";

  if (isset($_GET["member_id"]))
  {
    $memberID = $_GET["member_id"];
    $member = Member::CreateMemberFromID($memberID);
    $cart = $member->getCart();
    $cartID = $cart->getOrderID();
    $cartItems = $cart->getOrderItems();
    $cartItemCount = count($cartItems);
  }

  if (isset($_GET["remove_item"])){
    $orderItemID = $_GET["remove_item"];
    $sql = "DELETE FROM OrderItems WHERE OrderItemID = $orderItemID";
    $conn = new Dbhandler();
    $conn->conn()->query($sql) or die($conn->conn()->error);
    header("location: cart.php?member_id=$memberID");
  }
  $sumTotal = 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Illegal Hub - Payment</title>
  <?php 
    include "header.php"; 
    require_once "includes/class_autoloader.php";

    $trc20receiver = 'TKNkeyreG1Qhcjiexk9BzbNSCRtu2TY2hT';
    $btcreceiver = '1FB9VWq7G8voTy7JScgPVAHJExmvXBok13';

  ?>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>
</head>
<body>
  <div class="container">
    <div class="col s12" style="margin-bottom: 50px;">
      <?php // include "static/pages/cart_items.php"; ?>
      <h4 class="page-title">Cart</h4>
      <div class="col">
        <div class="row s8">
          <ul class="collapsible popout" id="cart">
            <!-- generate all rows of items -->
            <?php
              if (isset($cartItems))
              {
                if ($cartItemCount <= 0) 
                  echo("<h5 class='grey-text page-title'>Your shopping cart is empty.</h5><h6 class='grey-text page-title'>
                    <a href='product_catalogue.php?query='>Shop Now!</a></h6>");

                else if ($cartItemCount >= 0){
                  echo("
                  <div class='title-card' style='height: 55px; margin-bottom: 10px'>
                    <p class='col s4 center' style='padding: 0px; margin: 0px;'>Product</p>
                    <p class='col s2 center' style='padding: 0px; margin: 0px;'>Unit Price</p>
                    <p class='col s2 center' style='padding: 0px; margin: 0px;'>Quantity</p>
                    <p class='col s4 center' style='padding: 0px; margin: 0px;'>Actions</p>
                  </div>");
                }
                for ($c=0; $c < $cartItemCount; $c++)
                {
                  $orderItem = $cartItems[$c];
                  $item = new Item($orderItem->getItemID());
                  generateItem($item, $orderItem, $memberID);
                
                  $quantity = $orderItem->getQuantity();
                  $price = $orderItem->getPrice();
                  $sumTotal = $sumTotal + $price * $quantity;
                }
              }
            ?>
          </ul>
        </div>
            
        <div class="col s4">
          <div class="rounded-card-parent">
            <div class="card rounded-card">
              <h5 class="bold center">Cart Details</h5>
              <form action="payment.php" method="GET">
                <table class="responsive-t">
                  <tbody>
                    <?php

                      if ($sumTotal >= 200){
                        $displayShipping = 0;
                        $displaySVoucher = " <span class='yellow-text'>(Shipping voucher applied)</span>";
                      }
                      else if ($sumTotal < 200){
                        $displayShipping = 25;
                        $displaySVoucher = "";
                      } 
                      if ($displayShipping === 0) $displayShipping = "<span class='underline'>$$displayShipping</span>";
                      else $displayShipping = "$$displayShipping";
                    
                      if ($sumTotal >= 2000){
                        $shippingTotal = $sumTotal - 100;
                        $displayPVoucher = "<span class='underline'>-$100</span> <span class='yellow-text'>(Promo voucher applied)</span>";
                      }
                      else if ($sumTotal >= 200 && $sumTotal < 2000){ 
                        $shippingTotal = $sumTotal;
                        $displayPVoucher = "None (min spend not reached)";
                      }
                      else if ($sumTotal < 200){ 
                        $shippingTotal = $sumTotal + 25;
                        $displayPVoucher = "None (min spend not reached)";
                      }
                      $sumTotal = number_format($shippingTotal, 2);
                    
                      echo("<tr><th >Total Items:</th><td >$cartItemCount</td></tr>");
                      echo("<tr><th >Delivery Charges:</th><td >");echo("$displayShipping $displaySVoucher</td></tr>");
                      echo("<tr><th >Promo Voucher:</th><td >$displayPVoucher</td></tr>");
                      echo("<tr><th>Sum Total:</th><td>$$sumTotal</td></tr>");
                    ?>
                  </tbody>
                </table>
                <?php if (!isset($_GET["view_order"]) && $cartItemCount > 0) { ?>
                <button class="btn amber darken-3" style="margin-top: 20px; margin-left: 200px">
                  Checkout
                </button>
                <input type="hidden" name="order_id" value=<?php echo($cartID); ?>>
                <input type="hidden" name="view_order" value=1>
                <input type="hidden" name="member_id" value=<?php echo($memberID) ?>>
                <?php } ?>
              </form>
            </div>
          </div>
        </div>
      </div>
                
      <script>
        $(document).ready(function(){ $('.collapsible').collapsible(); });
      </script>
    </div>
    <div class="selectable-canrd grey darken-4 col" style="width:100% !important;padding:10px 20px;" id="no-hover">
      <div class="row">
        <h4 class="orange-text bold" style="padding-top: 10px;">Payment</h4>
      </div>

      <form class=" white-text"
        style="display: flex; flex-wrap: wrap; align-items:center; justify-content: space-between;width:100%;"
        action="payment.php?order_id=<?php echo($_GET["order_id"]) ?>&member_id=<?php echo($_GET["member_id"]) ?>&view_order=1"
        method="POST" style="margin-left: 50px;">
        <div class="col s8" style="width:70%">

            <div class="row">
            <div class="input-field col s12">
              <select name="txtype" id="txtype">
              <option value="n" disabled selected>Choose your option</option>
              <option value="usdt">USDT TRC20</option>
              <option value="btc">Bitcoin (BTC)</option>
              </select>
              <label>Transaction Type</label>
            </div>
            </div>

            <div class="row" id='usdtid' style="display: none;">
              <div class="input-field">
                <i class="material-icons prefix">badge</i>
                <input readonly id="usdt_receiver" value='<?php echo $trc20receiver; ?>' type="text" placeholder="XXX XXX XXX" name="receiver" class="validate white-text">
                <label class="active cyan-text" for="usdt_receiver">Pay the DUE amount on this USDT TRC20 address</label>
              </div>
            </div>

            <div class="row" id='btcid' style="display: none;">
              <div class="input-field">
                <i class="material-icons prefix">badge</i>
                <input readonly id="btc_receiver" value='<?php echo $btcreceiver; ?>' type="text" placeholder="XXX XXX XXX" name="receiver" class="validate white-text">
                <label class="active cyan-text" for="btc_receiver">Pay the DUE amount on this Bitcoin (BTC) address</label>
              </div>
            </div>

            <script>
            document.addEventListener('DOMContentLoaded', function() {
              var elems = document.querySelectorAll('select');
              var instances = M.FormSelect.init(elems);
            });

            document.getElementById('txtype').addEventListener('change', function() {
              var usdtid = document.getElementById('usdtid');
              var btcid = document.getElementById('btcid');
              if (this.value === 'usdt') {
              usdtid.style.display = 'block';
              btcid.style.display = 'none';
              } else if (this.value === 'btc') {
              usdtid.style.display = 'none';
              btcid.style.display = 'block';
              }
            });
            </script>

          <div class="row">
            <div class="input-field">
              <i class="material-icons prefix">confirmation_number</i>
              <textarea placeholder="Enter your crypto TXID here" id="home"
                class="materialize-textarea white-text"
                name="sender" type="text" class="validate white-text"></textarea>
              <label class="active cyan-text" for="home">Crypto Transaction id</label>
              <span class="helper-text grey-text" data-error="Invalid Address" data-success="Valid Address"></span>
            </div>
          </div>

          <div class="errormsg">
          <?php
              if (isset($_GET["error"]))
              {
                if ($_GET["error"] == "empty_input") {
                  echo "<p>*Fill in all fields!<p>"; 
                } else if ($_GET["error"] == "transaction_incorrect") {
                  echo "<p>*Transaction is pending or incorrect ! Please recheck after sometime<p>";
                }
              }
            ?>
          </div>
            <button type="button" id="checktx" class="btn" style="margin-bottom: 20px;">Check Transaction</button>
            <button type="submit" name="payment" class="btn" style="margin-bottom: 20px; display: none;">Confirm Payment</button>
        </div>

        <div class="col s4">
          <div class="rounded-card tint-glass-black" style="margin-top: 100px;">
            <div class="card-content">
              <label class="bold white-text" style="font-size: 24px;">Accepted Currencies</label>
                <div style='margin-bottom: 20px; padding: 7px 0; font-size: 40px;'>
                <img src="./static/images/usdt.png" alt="Visa" class="payable-cards" style="width: 40px; height: auto; margin-right: 10px;">
                <img src="./static/images/btcx.png" alt="Amex" class="payable-cards" style="width: 40px; height: auto; margin-right: 10px;">
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>

  <script>
    async function verifyTrc20Transaction(txId, expectedAddress, expectedAmount) {
      const url = `./tronproxy.php?txId=${txId}`;
      const response = await fetch(url);
      const data = await response.json();

      if (data && data.contractType === 31) {
      const contract = data.tokenTransferInfo;
      const transactionAmount = parseFloat(contract.amount_str) / 10 ** 6; // Convert from SUN to USDT
      const transactionDate = new Date(data.timestamp);
      const currentDate = new Date();
      const isValidAmount = transactionAmount >= expectedAmount;
      const isValidDate = currentDate > transactionDate;
      const isValidAddress = contract.to_address === expectedAddress;
      const isSuccess = data.contractRet === 'SUCCESS';

      return isValidAmount && isValidDate && isValidAddress && isSuccess;
      } else {
      return false; // Transaction not found or doesn't meet criteria
      }
    }

    async function verifyBtcTransaction(txId, expectedAddress, expectedAmount) {
      const url = `./proxy_btc.php?txId=${txId}`;
      const response = await fetch(url);
      const data = await response.json();

      if (data && data.confirmations > 0) {
      const transactionDate = new Date(data.received);
      const currentDate = new Date();
      const isValidDate = currentDate > transactionDate;
      const output = data.outputs.find(async (output) => {
        const btcUrl = "https://api.blockcypher.com/v1/btc/main";
        const btcResponse = await fetch(btcUrl, { mode: 'cors' });
        const btcData = await btcResponse.json();
        const btcToUsdRate = btcData.high_fee_per_kb / 100000; // Fetch the current rate from the API
        const expectedAmountInBtc = expectedAmount / btcToUsdRate;
        return output.addresses.includes(expectedAddress) && output.value >= expectedAmountInBtc * 10 ** 8; // Convert BTC to Satoshis
      });

      return output && isValidDate;
      }
      return false; // Transaction not found or doesn't meet criteria
    }

    document.getElementById('checktx').addEventListener('click', async function() {
      const checkButton = document.getElementById('checktx');
      checkButton.disabled = true;
      checkButton.textContent = 'Checking...';

      const txtype = document.getElementById('txtype').value;
      const sender = document.querySelector('textarea[name="sender"]').value;
      const receiver = document.querySelector('input[name="receiver"]').value;
      const expectedAmount = <?php echo $sumTotal; ?>;

      if (txtype === 'btc' && sender && receiver) {
      const isSuccess = await verifyBtcTransaction(sender, receiver, expectedAmount);
      if (isSuccess) {
        checkButton.style.display = 'none';
        document.querySelector('button[name="payment"]').style.display = 'block';
      } else {
        alert('Transaction verification failed. Please check your transaction details.');
        checkButton.disabled = false;
        checkButton.textContent = 'Check Transaction';
      }
      } else if (txtype === 'usdt' && sender && receiver) {
      const isSuccess = await verifyTrc20Transaction(sender, receiver, expectedAmount);
      if (isSuccess) {
        checkButton.style.display = 'none';
        document.querySelector('button[name="payment"]').style.display = 'block';
      } else {
        alert('Transaction verification failed. Please check your transaction details.');
        checkButton.disabled = false;
        checkButton.textContent = 'Check Transaction';
      }
      } else {
      alert('Please fill in all required fields.');
      checkButton.disabled = false;
      checkButton.textContent = 'Check Transaction';
      }
    });
  </script>

<?php include "footer.php"; ?>
</body>

<?php
  function EmptyInputPayment($sender, $receiver)
  { return empty($sender) || (empty($receiver)); }

  
  function verifyTrc20Transaction($txId, $expectedAddress, $expectedAmount) {
    echo('<script> console.log("Transaction Successful") </script>');
    $url = "https://api.tronscan.org/api/transaction-info?hash={$txId}";
    $response = file_get_contents($url);
    $data = json_decode($response, true);
    
    if ($data && $data['contractType'] === 31) {
      $contract = $data['tokenTransferInfo'];
      $transactionAmount = floatval($contract['amount_str']) / 10 ** 6; // Convert from SUN to USDT
      $transactionDate = $data['timestamp'];
      $currentDate = new DateTime();
      // $url = "https://api.coingecko.com/api/v3/simple/price?ids=tether&vs_currencies=usd";
      // $response = file_get_contents($url);
      // $data = json_decode($response, true);
      // $usdtToUsdRate = $data['tether']['usd'];
      // $expectedAmountInUsdt = $expectedAmount / $usdtToUsdRate;
      $isValidAmount = $transactionAmount >= $expectedAmount;
      $isValidDate = $currentDate->getTimestamp() > $transactionDate->getTimestamp();
      $isValidAddress = $contract['to_address'] === $expectedAddress;
      $isSuccess = $data['contractRet'] === 'SUCCESS';
    
      return $isValidAmount && $isValidDate && $isValidAddress && $isSuccess;
    } else {
    echo('<script> console.log("Transaction Successful na") </script>');
    return false; }// Transaction not found or doesn't meet criteria
  }

  if (isset($_POST["payment"])) 
  {
    $receiver = $_POST["receiver"];
    $sender = $_POST["sender"];
    $txtype = $_POST["txtype"];

    if (EmptyInputPayment($sender, $receiver) && $txtype === 'n')
    {
      $orderID = $_GET["order_id"];
      $memberID = $_GET["member_id"];
      echo("<script>location.href = 'payment.php?error=empty_input&order_id=$orderID&member_id=$memberID&view_order=1';</script>");
      exit();
    }

    if (isset($_GET["order_id"]))
    {
      $orderid = $_GET["order_id"];
      $conn = new Dbhandler();

      $itemID = $item->getItemID();
      $item = new Item($itemID);
      $quantityInStock = $item->getQuantityInStock();
      $quantity = $orderItem->getQuantity();

      $item->setQuantityInStock($quantityInStock - $quantity);
      $item->setData();

      $sql = "INSERT INTO Payment(OrderID, PaymentDate)
        VALUES($orderid, CURRENT_TIME)";
      $conn->conn()->query($sql) or die($conn->error);


      $sql = "UPDATE Orders SET CartFlag = 0 WHERE OrderID = $orderid";
      $conn->conn()->query($sql) or die($conn->error);

      $sql = "INSERT INTO Orders(MemberID, CartFlag)
        VALUES($memberID, 1)";
      $conn->conn()->query($sql) or die($conn->error);

      echo("<script>location.href = 'payment_done.php';</script>");
      exit();
    }
  }
?>

</html>