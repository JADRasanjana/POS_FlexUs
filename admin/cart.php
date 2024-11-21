<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['imsaid'] == 0)) {
  header('location:logout.php');
} else {

  // Code for deleting product from cart
  if (isset($_GET['delid'])) {
    $rid = intval($_GET['delid']);
    $query = mysqli_query($con, "DELETE FROM tblcart WHERE ID='$rid'");
    echo "<script>alert('Data deleted');</script>";
    echo "<script>window.location.href = 'cart.php'</script>";
  }

  if (isset($_POST['submit'])) {
    $custname = $_POST['customername'];
    $custmobilenum = $_POST['mobilenumber'];
    $custaddress = $_POST['customeraddress'];
    $billiningnum = mt_rand(100000000, 999999999);
    $modepayment = $_POST['modepayment'];

    $query = "UPDATE tblcart SET BillingId='$billiningnum', IsCheckOut=1 WHERE IsCheckOut=0;";
    $query .= "INSERT INTO tblcustomer(BillingNumber, CustomerName, MobileNumber, CustomerAddress, ModeofPayment) VALUES('$billiningnum', '$custname', '$custmobilenum', '$custaddress', '$modepayment');";
    $result = mysqli_multi_query($con, $query);

    if ($result) {
      $_SESSION['invoiceid'] = $billiningnum;
      echo '<script>alert("Invoice created successfully. Billing number is "+"'.$billiningnum.'")</script>';
      echo "<script>window.location.href='invoice.php'</script>";
    }
  }

  // Code for adding product to cart
  if (isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    // Check if product already exists in cart
    $query = mysqli_query($con, "SELECT * FROM tblcart WHERE ProductId='$product_id' AND IsCheckOut=0");
    $num = mysqli_fetch_array($query);

    if ($num > 0) {
      // If product exists, update quantity
      $existing_qty = $num['ProductQty'];
      $new_qty = $existing_qty + $quantity;
      $update_query = "UPDATE tblcart SET ProductQty='$new_qty' WHERE ProductId='$product_id' AND IsCheckOut=0";
      mysqli_query($con, $update_query);
      echo "<script>alert('Product quantity updated in the cart');</script>";
    } else {
      // If product does not exist, insert new record
      $insert_query = "INSERT INTO tblcart(ProductId, ProductQty, IsCheckOut) VALUES('$product_id', '$quantity', 0)";
      mysqli_query($con, $insert_query);
      echo "<script>alert('Product added to the cart');</script>";
    }
    echo "<script>window.location.href = 'cart.php'</script>";
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Inventory Management System || Cart</title>
  <?php include_once('includes/cs.php'); ?>
  <style>
    .payment-methods {
      display: flex;
      gap: 20px;
      margin-top: 10px;
    }
    .payment-method {
      display: flex;
      align-items: center;
      gap: 10px;
      cursor: pointer;
    }
    .payment-method input[type="radio"] {
      display: none;
    }
    .payment-method i {
      font-size: 24px;
    }
    .payment-method label {
      margin: 0;
      font-size: 16px;
    }
    /* Colors for each payment icon */
    .payment-method input[type="radio"]:checked + i {
      color: green;
    }
    .payment-method i.icon-money {
      color: #4CAF50; /* Green for cash */
    }
    .payment-method i.icon-credit-card {
      color: #2196F3; /* Blue for card */
    }
    .payment-method i.icon-paypal {
      color: #FF9800; /* Orange for PayPal */
    }
    .payment-method i.icon-bank {
      color: #9C27B0; /* Purple for Bank Transfer */
    }
    .toggle-methods {
      margin-top: 20px;
    }
    .additional-methods {
      display: none;
      margin-top: 10px;
    }
  </style>
  <script>
    function toggleAdditionalMethods() {
      var additionalMethods = document.getElementById('additionalMethods');
      additionalMethods.style.display = additionalMethods.style.display === 'block' ? 'none' : 'block';
    }
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
        <a href="cart.php" class="current">Products Cart</a>
      </div>
      <h1>Products Cart</h1>
    </div>
    <div class="container-fluid">
      <hr>
      <div class="row-fluid">
        <div class="span12">
          <form method="post" class="form-horizontal" name="submit">
            <div class="control-group">
              <label class="control-label">Customer Name :</label>
              <div class="controls">
                <input type="text" class="span11" id="customername" name="customername" value="" required />
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Customer Mobile Number :</label>
              <div class="controls">
                <input type="text" class="span11" id="mobilenumber" name="mobilenumber" value="" required maxlength="10" pattern="[0-9]+" />
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Customer Address :</label>
              <div class="controls">
                <textarea class="span11" id="customeraddress" name="customeraddress" required></textarea>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Mode of Payment :</label>
              <div class="controls payment-methods">
                <label class="radio inline">
                  <input type="radio" id="cash" name="modepayment" value="Cash" checked>
                  Cash
                </label>
                <label class="radio inline">
                  <input type="radio" id="card" name="modepayment" value="Card">
                  Card
                </label>
              </div>
            </div>
            <div class="control-group toggle-methods">
              <button type="button" class="btn btn-warning" onclick="toggleAdditionalMethods()">Other Payment Methods</button>
            </div>
            <div class="control-group additional-methods" id="additionalMethods" style="display: none;">
              <div class="controls payment-methods">
                <label class="radio inline">
                  <input type="radio" id="cheque" name="modepayment" value="Cheque">
                  Cheque
                </label>
                <label class="radio inline">
                  <input type="radio" id="bank" name="modepayment" value="Bank">
                  Bank Transfer
                </label>
              </div>
            </div>
            <div class="text-center">
              <button class="btn btn-primary my-4" type="submit" name="submit">Submit</button>
            </div>
          </form>

          <div class="widget-box">
            <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
              <h5>Products Cart</h5>
            </div>
            <div class="widget-content nopadding">
              <table class="table table-bordered" style="font-size: 15px">
                <thead>
                  <tr>
                    <th style="font-size: 12px">S.NO</th>
                    <th style="font-size: 12px">Product Name</th>
                    <th style="font-size: 12px">Category Name</th>
                    <th style="font-size: 12px">SubCategory Name</th>
                    <th style="font-size: 12px">Brand Name</th>
                    <th style="font-size: 12px">Item Code</th>
                    <th style="font-size: 12px">Quantity</th>
                    <th style="font-size: 12px">Price(per unit)</th>
                    <th style="font-size: 12px">Total</th>
                    <th style="font-size: 12px">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $ret = mysqli_query($con, "SELECT tblcategory.CategoryName, tblsubcategory.SubCategoryname as subcat, tblproducts.ProductName, tblproducts.BrandName, tblproducts.ID as pid, tblproducts.ModelNumber, tblproducts.Price, SUM(tblcart.ProductQty) as totalQty, tblcart.ID as cid FROM tblcart JOIN tblproducts ON tblcart.ProductId=tblproducts.ID LEFT JOIN tblcategory ON tblcategory.ID=tblproducts.CatID LEFT JOIN tblsubcategory ON tblsubcategory.ID=tblproducts.SubcatID WHERE tblcart.IsCheckOut='0' GROUP BY tblcart.ProductId");
                  $cnt = 1;
                  $gtotal = 0;
                  while ($row = mysqli_fetch_array($ret)) {
                    $total = $row['totalQty'] * $row['Price'];
                    $gtotal += $total;
                  ?>
                    <tr class="gradeX">
                      <td><?php echo $cnt; ?></td>
                      <td><?php echo $row['ProductName']; ?></td>
                      <td><?php echo $row['CategoryName']; ?></td>
                      <td><?php echo $row['subcat']; ?></td>
                      <td><?php echo $row['BrandName']; ?></td>
                      <td><?php echo $row['ModelNumber']; ?></td>
                      <td><?php echo $row['totalQty']; ?></td>
                      <td><?php echo $row['Price']; ?></td>
                      <td><?php echo $total; ?></td>
                      <td><a href="cart.php?delid=<?php echo $row['cid']; ?>" onclick="return confirm('Do you really want to Delete ?');"><i class="icon-trash"></i></a></td>
                    </tr>
                  <?php
                    $cnt++;
                  }
                  ?>
                  <tr>
                    <th colspan="7" style="text-align: center; color: red; font-weight: bold; font-size: 15px">Grand Total</th>
                    <th colspan="4" style="text-align: center; color: red; font-weight: bold; font-size: 15px"><?php echo $gtotal; ?></th>
                  </tr>
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

  <script src="js/jquery.min.js"></script>
  <script src="js/jquery.ui.custom.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/jquery.uniform.js"></script>
  <script src="js/select2.min.js"></script>
  <script src="js/jquery.dataTables.min.js"></script>
  <script src="js/matrix.js"></script>
  <script src="js/matrix.tables.js"></script>
  <script>
    function toggleAdditionalMethods() {
      const methods = document.getElementById('additionalMethods');
      methods.style.display = methods.style.display === 'none' || methods.style.display === '' ? 'block' : 'none';
    }
  </script>
</body>

</html>
<?php } ?>
