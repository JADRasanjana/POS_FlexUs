<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['imsaid'] == 0)) {
  header('location:logout.php');
} else {
  if (isset($_POST['search'])) {
    $search_query = $_POST['search_query'];
    $query = mysqli_query($con, "SELECT * FROM tblproducts WHERE ProductName LIKE '%$search_query%' OR ID = '$search_query'");
    $product = mysqli_fetch_assoc($query);
  }

  if (isset($_POST['update_stock'])) {
    $product_id = $_POST['product_id'];
    $new_stock = $_POST['new_stock'];
    $current_stock = $_POST['current_stock'];

    // Update stock
    $updated_stock = $current_stock + $new_stock;
    $update_query = mysqli_query($con, "UPDATE tblproducts SET Stock = '$updated_stock' WHERE ID = '$product_id'");

    if ($update_query) {
      echo '<script>alert("Stock updated successfully.");</script>';
    } else {
      echo '<script>alert("Failed to update stock. Please try again.");</script>';
    }
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Inventory Management System || Manage Stock</title>
  <?php include_once('includes/cs.php'); ?>
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
        <a href="manage-stock.php" class="current">Manage Stock</a>
      </div>
      <h1>Manage Stock</h1>
    </div>
    <div class="container-fluid">
      <hr>
      <div class="row-fluid">
        <div class="span12">
          <div class="widget-box">
            <div class="widget-title">
              <span class="icon"><i class="icon-th"></i></span>
              <h5>Search Product</h5>
            </div>
            <div class="widget-content nopadding">
              <form method="post" class="form-horizontal">
                <div class="control-group">
                  <label class="control-label">Product ID/Name :</label>
                  <div class="controls">
                    <input type="text" class="span11" name="search_query" id="search_query" placeholder="Enter Product ID or Name" required>
                  </div>
                </div>
                <div class="form-actions">
                  <button type="submit" class="btn btn-success" name="search">Search</button>
                </div>
              </form>
            </div>
          </div>

          <?php if (isset($product) && $product): ?>
          <div class="widget-box">
            <div class="widget-title">
              <span class="icon"><i class="icon-th"></i></span>
              <h5>Update Stock</h5>
            </div>
            <div class="widget-content nopadding">
              <form method="post" class="form-horizontal">
                <input type="hidden" name="product_id" value="<?php echo $product['ID']; ?>">
                <input type="hidden" name="current_stock" value="<?php echo $product['Stock']; ?>">
                <div class="control-group">
                  <label class="control-label">Product Name :</label>
                  <div class="controls">
                    <input type="text" class="span11" name="product_name" id="product_name" value="<?php echo $product['ProductName']; ?>" readonly>
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label">Current Stock :</label>
                  <div class="controls">
                    <input type="text" class="span11" name="current_stock_display" id="current_stock_display" value="<?php echo $product['Stock']; ?>" readonly>
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label">New Stock/New Delivery :</label>
                  <div class="controls">
                    <input type="number" class="span11" name="new_stock" id="new_stock" placeholder="Enter New Stock Quantity" required>
                  </div>
                </div>
                <div class="form-actions">
                  <button type="submit" class="btn btn-success" name="update_stock">Update Stock</button>
                </div>
              </form>
            </div>
          </div>
          <?php elseif (isset($search_query)): ?>
          <div class="alert alert-error">
            No product found with that ID or Name.
          </div>
          <?php endif; ?>

        </div>
      </div>
    </div>
  </div>

  <?php include_once('includes/footer.php'); ?>
  <?php include_once('includes/js.php'); ?>
</body>
</html>
<?php } ?>
