<!DOCTYPE html>
<html lang="en">
<body>
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Illegal Hub - Product Catalogue</title>
    <?php 
      require_once "header.php";
      require_once "includes/product_catalogue.inc.php";
    ?>
  <link rel="icon" type="image/png" style="border-radius: 50%;" href="./static/logo.jpg">

  </head>

  <main >
    <div class="row" style="padding-top: 15px;">
      <div class="col s2 center">

        <div id="rgb_hover" style="position: fixed;z-index:1000;background-color:#000">
          <form id="form-filter" action="" method="GET">
            <input type="hidden" name="query" value="<?php if(isset($_GET["query"])) 
              echo($_GET["query"]); ?>">

            <div class="section" style="margin-bottom: 10px;">
              <div class="col unglow">
                <ul id="filter_dropdown" class="dropdown-content black">
                  <li><a class="cyan-text page-title" onclick="select_category(this)">Clear</a></li>
                  <li><a class="cyan-text page-title" onclick="select_category(this)">Cradit Cards</a></li>
                  <li><a class="cyan-text page-title" onclick="select_category(this)">Gift Cards</a></li>
                  <li><a class="cyan-text page-title" onclick="select_category(this)">Flash BTC | USDT </a></li>
                </ul>
                <a class="btn dropdown-trigger cyan" data-target="filter_dropdown" style="margin-top: 5px;">
                  <?php
                    $category = -1;
                    if (isset($_GET["category"])) $category = $_GET["category"];

                    if ($category != -1) echo(CATEGORY_NAMES[$category]);
                    else echo("Select Category");
                    echo("<input type='hidden' name='category' value=$category>");
                  ?>
                  <i class="material-icons right">arrow_drop_down</i>
                </a>
              </div>
            </div>

            <div class="section" style="margin-bottom: 10px">
              <div class="col unglow">
                <ul id="sort_dropdown" class="dropdown-content black">
                  <li><a class="page-title" onclick="select_sort(this)">Clear</a></li>
                  <li><a class="page-title" onclick="select_sort(this)">Price low to high</a></li>
                  <li><a class="page-title" onclick="select_sort(this)">Price high to low</a></li>
                </ul>
                <a class="btn dropdown-trigger" data-target="sort_dropdown" style="margin-top: 5px;">
                  <?php
                    $sort = -1;
                    if (isset($_GET["sort"])) $sort = $_GET["sort"];
                    if ($sort != -1) echo(SORT_NAMES[$sort]);
                    else echo("Select Sort Type");
                    echo("<input type='hidden' name='sort' value=$sort>");
                  ?>
                  <i class="material-icons right">arrow_drop_down</i>
                </a>
              </div>
            </div>

            <div class="section">
              <div class="col unglow">
                
                <a >
                  <?php
                    $brand = -1;
                    if (isset($_GET["brand"])) $brand = $_GET["brand"];

                    if ($brand != -1) echo(BRAND_NAMES[$brand]);
                    
                  ?>
                
                </a>
              </div>
            </div>
          </form>
        </div>
      </div>

      <style>
          @media only screen and (max-width: 600px) {
            .flex-row-mobile {
              display: flex !important;
              flex-direction: column !important;
            }
            .flex-row-mobiled {
              margin: 0px !important;
            }
          }
            .flex-row-mobiled {
              width: unset !important;
            }
        </style>

      <div class="col s9" style="margin-bottom: 80px">
        <!-- item list start -->
        <?php
          searchItems($category, $brand, $sort);
        ?>
      </div>
    </div>
  </main>
</body>

<script>
  $(document).ready(() =>
  {
    form = document.getElementById("form-filter");
    category = document.getElementsByName("category")[0];
    brand = document.getElementsByName("brand")[0];
    sort = document.getElementsByName("sort")[0];
  });

  // dropdown
  var form, category, brand, sort, view;

  var categoryBy = {
    "Clear": -1,
    "Cradit Cards": 0,
    "Gift Cards": 1,
    "Flash BTC | USDT ": 2
  };

  var brandBy = {
    "Clear": -1,
    "Asus": 0,
    "MSI": 1,
    "Razer": 2,
    "Logitech": 3,
    "Viewsonic": 4,
    "Acer": 5,
    "HyperX": 6,
    "Steelseries": 7,
    "Corsair": 8
  }

  var sortBy = {
    "Clear": -1,
    "Price low to high": 0,
    "Price high to low": 1
  };

  function select_category(selectedItem)
  {
    // get current onclick event index
    var categoryID = categoryBy[selectedItem.textContent];
    // assign current mapped index and output to url with GET method to handle form
    category.value = categoryID;
    form.submit();
  }

  function select_brand(selectedBrand)
  {
    // get current onclick event index
    var brandID = brandBy[selectedBrand.textContent];
    // assign current mapped index and output to url with GET method to handle form
    brand.value = brandID;
    form.submit();
  }

  function select_sort(selectedSort)
  {
    // get current onclick event index
    var sortID = sortBy[selectedSort.textContent];
    // assign current mapped index and output to url with GET method to handle form
    sort.value = sortID;
    form.submit();
  }
</script>
<?php include_once "footer.php"; ?>
</html>