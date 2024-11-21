<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (strlen($_SESSION['imsaid'] == 0)) {
  header('location:logout.php');
} else {
  // Code for add to cart
  if (isset($_POST['cart'])) {
    $pid = $_POST['pid'];
    $pqty = $_POST['pqty'];
    $ischecout = 0;

    // Fetch the remaining quantity for the product
    $query = mysqli_query($con, "SELECT Stock - IFNULL(SUM(tblcart.ProductQty), 0) as remaining_qty FROM tblproducts LEFT JOIN tblcart ON tblproducts.ID = tblcart.ProductId WHERE tblproducts.ID='$pid' GROUP BY tblproducts.ID");
    $result = mysqli_fetch_assoc($query);
    $remainqty = $result['remaining_qty'];

    if ($pqty <= $remainqty && $remainqty > 0) {
      $query = mysqli_query($con, "INSERT INTO tblcart(ProductId,ProductQty,IsCheckOut) VALUE('$pid','$pqty','$ischecout')");
      echo "<script>alert('Product has been added to the cart');</script>";
      echo "<script>window.location.href = 'search.php'</script>";
    } else {
      echo "<script>alert('You can\'t add quantity more than the remaining quantity or the product is out of stock');</script>";
    }
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Inventory Management System | Add Products</title>
  <?php include_once('includes/cs.php'); ?>
  <style>
    .table-responsive {
      overflow-x: auto;
    }
    table.table {
      width: 100%;
      white-space: nowrap;
    }
    th, td {
      text-align: center;
      vertical-align: middle;
    }
    img.product-image {
      width: 50px;
      height: 50px;
    }
    .zero-stock {
      background-color: #f8d7da !important; /* Light red background for zero or negative stock */
    }
    .optional-field, .optional-search-field {
      display: none;
    }
  </style>
  <script src="js/jquery.min.js"></script>
  <script>
    $(document).ready(function () {
      // Toggle optional fields in the search form
      $('#toggleSearchFields').click(function () {
        var optionalFields = $('.optional-search-field');
        optionalFields.toggle();
        $(this).text(function (i, text) {
          return text === "Show Optional Fields" ? "Hide Optional Fields" : "Show Optional Fields";
        });
      });

      // Autocomplete functionality for the product name search
      $('#pname').keyup(function () {
        var query = $(this).val();
        if (query != '') {
          $.ajax({
            url: "fetch.php",
            method: "POST",
            data: { query: query },
            success: function (data) {
              $('#productList').fadeIn();
              $('#productList').html(data);
            }
          });
        } else {
          $('#productList').fadeOut();
          $('#productList').html("");
        }
      });

      $(document).on('click', 'li', function () {
        $('#pname').val($(this).text());
        $('#productList').fadeOut();
      });

      // Toggle optional columns in the search results table
      $('#toggleButton').click(function () {
        var optionalFields = $('.optional-field');
        optionalFields.toggle();
        $(this).text(function (i, text) {
          return text === "Show Optional Columns" ? "Hide Optional Columns" : "Show Optional Columns";
        });
      });
    });
  </script>
</head>
<body>

<?php include_once('includes/header.php'); ?>
<?php include_once('includes/sidebar.php'); ?>

<div id="content">
  <div id="content-header">
    <div id="breadcrumb">
      <a href="dashboard.php" title="Go to Home" class="tip-bottom">
        <i class="icon-home"></i> Home
      </a>
      <a href="search.php" class="current">Search Products </a>
    </div>
    <h1>Search Products</h1>
  </div>
  <div class="container-fluid">
    <hr>
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-content nopadding">
          
          <form method="post" class="form-horizontal">
            <div class="control-group">
              <label class="control-label">Search Product :</label>
              <div class="controls">
                <input type="text" class="span11" name="pname" id="pname" value="" autocomplete="off" />
                <div id="productList"></div>
              </div>
            </div>
            <div class="optional-search-field">
              <div class="control-group">
                <label class="control-label">Category:</label>
                <div class="controls">
                  <select name="category" class="span11">
                    <option value="">All</option>
                    <?php
                    $query = mysqli_query($con, "SELECT * FROM tblcategory");
                    while ($row = mysqli_fetch_array($query)) {
                      echo '<option value="' . $row['ID'] . '">' . $row['CategoryName'] . '</option>';
                    }
                    ?>
                  </select>
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">SubCategory:</label>
                <div class="controls">
                  <select name="subcategory" class="span11">
                    <option value="">All</option>
                    <?php
                    $query = mysqli_query($con, "SELECT * FROM tblsubcategory");
                    while ($row = mysqli_fetch_array($query)) {
                      echo '<option value="' . $row['ID'] . '">' . $row['SubCategoryname'] . '</option>';
                    }
                    ?>
                  </select>
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">Brand:</label>
                <div class="controls">
                  <input type="text" class="span11" name="brand" id="brand" value="" />
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">Price Range:</label>
                <div class="controls">
                  <input type="text" class="span5" name="price_min" placeholder="Min" />
                  <input type="text" class="span5" name="price_max" placeholder="Max" />
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">Filter by Remaining Quantity:</label>
                <div class="controls">
                  <select name="filter_quantity" class="span11">
                    <option value="">All</option>
                    <option value="low">Low (<= 10)</option>
                    <option value="medium">Medium (11 - 50)</option>
                    <option value="high">High (> 50)</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="text-center">
              <button class="btn btn-primary my-4" type="submit" name="search">Search Products</button> &nbsp; <button id="toggleSearchFields" type="button" class="btn btn-info">Show Optional Fields</button>
            </div>
          </form>
          <br>
        </div>
        <?php
        // Always fetch all products initially unless filters are applied
        $sdata = $_POST['pname'] ?? '';
        $category = $_POST['category'] ?? '';
        $subcategory = $_POST['subcategory'] ?? '';
        $brand = $_POST['brand'] ?? '';
        $price_min = $_POST['price_min'] ?? '';
        $price_max = $_POST['price_max'] ?? '';
        $filter_quantity = $_POST['filter_quantity'] ?? '';

        $quantity_condition = "";
        if ($filter_quantity == "low") {
          $quantity_condition = "HAVING remaining_qty <= 10";
        } elseif ($filter_quantity == "medium") {
          $quantity_condition = "HAVING remaining_qty BETWEEN 11 AND 50";
        } elseif ($filter_quantity == "high") {
          $quantity_condition = "HAVING remaining_qty > 50";
        }

        // Base query
        $query = "SELECT tblcategory.CategoryName, tblsubcategory.SubCategoryname as subcat, 
                  tblproducts.ProductName, tblproducts.BrandName, tblproducts.ID as pid, 
                  tblproducts.Status, tblproducts.CreationDate, tblproducts.ModelNumber, 
                  tblproducts.Stock, tblproducts.Stock - IFNULL(SUM(tblcart.ProductQty), 0) as remaining_qty 
                  FROM tblproducts 
                  LEFT JOIN tblcategory ON tblcategory.ID = tblproducts.CatID 
                  LEFT JOIN tblsubcategory ON tblsubcategory.ID = tblproducts.SubcatID 
                  LEFT JOIN tblcart ON tblproducts.ID = tblcart.ProductId 
                  WHERE 1=1";

        // Add conditions only if filters are provided
        if ($sdata != '') {
          $query .= " AND tblproducts.ProductName LIKE '%$sdata%'";
        }
        if ($category != '') {
          $query .= " AND tblproducts.CatID = '$category'";
        }
        if ($subcategory != '') {
          $query .= " AND tblproducts.SubcatID = '$subcategory'";
        }
        if ($brand != '') {
          $query .= " AND tblproducts.BrandName LIKE '%$brand%'";
        }
        if ($price_min != '' && $price_max != '') {
          $query .= " AND tblproducts.Price BETWEEN '$price_min' AND '$price_max'";
        }

        // Group by and filtering by remaining quantity
        $query .= " GROUP BY tblproducts.ProductName $quantity_condition";

        // Execute the query
        $ret = mysqli_query($con, $query);
        $num = mysqli_num_rows($ret);
        ?>
        <h4 align="center">Result against "<?php echo $sdata; ?>" keyword</h4>
        <div class="widget-box">
          <div class="widget-title">
            <span class="icon"><i class="icon-th"></i></span>
            <h5>Search Products</h5>
            <button id="toggleButton" type="button" class="btn btn-info" style="float:right;">Show Optional Columns</button>
          </div>
          <div class="widget-content nopadding table-responsive">
            <table class="table table-bordered data-table">
              <thead>
                <tr>
                  <th>S.NO</th>
                  <th>Product Name</th>
                  <th class="optional-field">Category Name</th>
                  <th class="optional-field">SubCategory Name</th>
                  <th class="optional-field">Brand Name</th>
                  <th>Item Code</th>
                  <th>Stock</th>
                  <th>Remaining Stock</th>
                  <th>Buying Qty</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                if ($num > 0) {
                  $cnt = 1;
                  while ($row = mysqli_fetch_array($ret)) {
                    $remaining_qty = $row['remaining_qty'];
                ?>
                <form name="cart" method="post">
                  <tr class="gradeX <?php echo $remaining_qty <= 0 ? 'zero-stock' : ''; ?>">
                    <input type="hidden" name="pid" value="<?php echo $row['pid']; ?>">
                    <td><?php echo $cnt; ?></td>
                    <td><?php echo $row['ProductName']; ?></td>
                    <td class="optional-field"><?php echo $row['CategoryName']; ?></td>
                    <td class="optional-field"><?php echo $row['subcat']; ?></td>
                    <td class="optional-field"><?php echo $row['BrandName']; ?></td>
                    <td><?php echo $row['ModelNumber']; ?></td>
                    <td><?php echo $row['Stock']; ?></td>
                    <td><?php echo ($_SESSION['rqty'] = $remaining_qty); ?></td>
                    <td><input type="number" name="pqty" value="1" required="true" style="width:40px;" <?php echo $remaining_qty <= 0 ? 'disabled' : ''; ?>></td>
                    <?php if ($row['Status'] == "1") { ?>
                    <td><?php echo "Active"; ?></td>
                    <?php } else { ?>
                    <td><?php echo "Inactive"; ?></td>
                    <?php } ?>
                    <td>
                      <button type="submit" name="cart" class="btn btn-primary my-4" <?php echo $remaining_qty <= 0 ? 'disabled' : ''; ?> data-toggle="tooltip" title="<?php echo $remaining_qty <= 0 ? 'Add more stock' : 'Add to Cart'; ?>">Add to Cart</button>
                    </td>
                  </tr>
                </form>
                <?php
                    $cnt = $cnt + 1;
                  }
                } else { ?>
                <tr>
                  <td colspan="11">No record found.</td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!--Footer-part-->
<?php include_once('includes/footer.php'); ?>
<!--end-Footer-part-->
<script src="js/jquery.ui.custom.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.uniform.js"></script>
<script src="js/select2.min.js"></script>
<script src="js/matrix.js"></script>
<script src="js/matrix.tables.js"></script>
<script>
  $(function () {
    $('[data-toggle="tooltip"]').tooltip()
  });
</script>
</body>
</html>
<?php } ?>
