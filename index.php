<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Illegal Hub</title>
  <?php 
    require "header.php"; 
    require_once "includes/class_autoloader.php";

    // database initialization
    $dbinit = new InitDB();
    $dbinit->initDbExec();
  ?>
</head>
<body>
  
<body>
  
<div class="DarkBan">
  <img src="./static/images/dark1.jpg" alt="Dark Banner">
</div>
  
  
<div class="container">
    <div class="row">
      <!-- Category Header -->
      <div class="row">
        <h4 class="underline white-text bold center">Categories</h4>
      </div>
      
      <!-- Cards Section -->
      <div class="row category-row">
        
        <!-- Card: Credit Cards -->
        <div class="col">
          <a href="product_catalogue.php?category=0" class="hoverable">
            <div class="selectable-card tint-glass-black">
              <img src="static/images/clone.jpg" alt="Credit Cards" class="card-image">
              <h5 class="white-text center bold">Credit Cards</h5>
            </div>
          </a>
        </div>
        
        <!-- Card: Gift Cards -->
        <div class="col">
          <a href="product_catalogue.php?category=1" class="hoverable">
            <div class="selectable-card tint-glass-black">
              <img src="static/images/GiftCards.png" alt="Gift Cards" class="card-image">
              <h5 class="white-text center bold">Gift Cards</h5>
            </div>
          </a>
        </div>

        <!-- Card: Flash BTC / USDT -->
        <div class="col">
          <a href="product_catalogue.php?category=2" class="hoverable">
            <div class="selectable-card tint-glass-black">
              <img src="static/images/btc1.jpeg" alt="Flash BTC / USDT" class="card-image">
              <h5 class="white-text center bold">Flash BTC / USDT</h5>
            </div>
          </a>
        </div>
      </div>
    </div>
  </div>
  
  <div class="section" style="margin-top: 100px;">
    <div class="wide-container">
      <h3 class="white-text center">We are group of international carders and money cleaning experts.</h3>
      <h5 class="white-text center">
        At <b class="orange-text">ILLEGAL HUB</b>, We working almost 24/7 to provide you with the best service to satisfy your needs!
        Since 2016 we are online and growing everyday.
      </h5>
    </div>
  </div>

  <div class="grid" style="margin-top: 20px; margin-bottom: 100px; width:100%;flex-wrap:wrap">
    <div class="grid" style="flex-direction:column">
      <h1 class="count red-text text-darken-4 bold center">8</h1>
      <h5 class="white-text center">Years Of History</h5>
    </div>
    <div class="grid" style="flex-direction:column">
      <h1 class="count red-text text-darken-4 bold center">5000</h1>
      <h5 class="white-text center">Product Sold Out </h5>
    </div>
    <div class="grid" style="flex-direction:column">
      <h1 class="count red-text text-darken-4 bold center">7</h1>
      <h5 class="white-text center">Country Covered</h5>
    </div>
    <div class="grid" style="flex-direction:column">
      <h1 class="count red-text text-darken-4 bold center">100</h1>
      <h5 class="white-text center">% Satisfaction guaranteed</h5>
    </div>
  </div>

  <!-- <h3 class="white-text center">OG Tech PC - White PC Build</h3>
  <div onclick="this.nextElementSibling.style.display='block'; this.style.display='none'" style="margin-bottom: 100px">
    <img src="static/images/ice_pc.png" style="cursor:pointer; display:block; margin: 0 auto; " />
  </div>
  <div style="display:none">
    <video style="display:block; margin: 0 auto;" class="responsive-video" width="1280" height="720" autoplay="autoplay" controls muted>
      <source src="static/FROST Gaming PC.mp4" type="video/mp4">
    </video>
  </div> -->

  <h3 class="white-text center">OUR DIFFERENCE</h3>
  <h6 class="white-text center">Compared to other MarketPlace services</h6>

  

    <div class="grid" style="gap:30px;flex-wrap:wrap;">
      <div class="rounded-card-parent">
        <div class="card rounded-card tint-glass-black" style="height: 300px; width: 250px;">
          <img src="static/images/values_images/T.svg" height="200px">
          <div class="row center">
            <h5 class="orange-text bold center" style="display: inline;">M</h5>
            <h5 class="white-text bold center" style="display: inline;">oney Back Guarantee</h5>
          </div>
        </div>
      </div>
    <!-- </div>
<div class="grid"> -->
      <div class="rounded-card-parent">
        <div class="card rounded-card tint-glass-black" style="height: 300px; width: 250px;">
          <img src="static/images/values_images/E.svg" height="200px">
          <div class="row center">
            <h5 class="orange-text bold center" style="display: inline;">T</h5>
            <h5 class="white-text bold center" style="display: inline;">echnical Support</h5>
          </div>
        </div>
      </div>
    </div>

  <!-- <script src="https://apps.elfsight.com/p/platform.js" defer></script> -->
  <div class="elfsight-app-dcc4934e-3eb0-4e18-98af-67fd2f034df1"></div>

  <?php require "footer.php"; ?>
</body>


<script>
  $(document).ready(function(){
    // carousel autoswipe
    $('.slider').slider({full_width: true});

    // counter
    $('.count').each(function () 
    {
      $(this).prop('Counter',0).animate({
        Counter: $(this).text()
      }, {
        duration: 4000,
        easing: 'swing',
        step: function (now) { $(this).text(Math.ceil(now)); }
      });
    });
  });
</script>
</html>