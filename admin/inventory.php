<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['imsaid'] == 0)) {
  header('location:logout.php');
} else {
  ?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Inventory Management System|| View Products Inventory</title>
<?php include_once('includes/cs.php');?>
<script>
function toggleOptionalFields() {
    var optionalFields = document.getElementsByClassName('optional-field');
    var button = document.getElementById('toggleButton');
    for (var i = 0; i < optionalFields.length; i++) {
        if (optionalFields[i].style.display === 'none') {
            optionalFields[i].style.display = 'table-cell';
            button.textContent = 'Hide Optional Fields';
        } else {
            optionalFields[i].style.display = 'none';
            button.textContent = 'Show Optional Fields';
        }
    }
}
document.addEventListener('DOMContentLoaded', function() {
    toggleOptionalFields();
});
</script>
<style>
.optional-field {
    display: none;
}
</style>
</head>
<body>

<?php include_once('includes/header.php');?>
<?php include_once('includes/sidebar.php');?>

<div id="content">
  <div id="content-header">
    <div id="breadcrumb">
      <a href="dashboard.php" title="Go to Home" class="tip-bottom">
        <i class="icon-home"></i> Home
      </a>
      <strong> View Products Inventory</strong>
    </div>
    <h1>View Products Inventory</h1>
  </div>
  <div class="container-fluid">
    <hr>
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title">
            <span class="icon"><i class="icon-th"></i></span>
            <h5>Products Inventory</h5>
          </div>
          <div class="widget-content nopadding" style="overflow-x:auto;">
            <button id="toggleButton" onclick="toggleOptionalFields()" class="btn btn-info" style="margin: 10px;">Show Optional Fields</button>
            <table class="table table-bordered data-table" id="dataTable" style="width:100%; white-space:nowrap;">
              <thead>
                <tr>
                  <th>S.NO</th>
                  <th>Product Name</th>
                  <th>Price</th>
                  <th>Quantity</th>
                  <th>Weight</th>
                  <th>Item Code</th>
                  <th class="optional-field">Category Name</th>
                  <th class="optional-field">SubCategory Name</th>
                  <th class="optional-field">Brand Name</th>
                  <th class="optional-field">Barcode</th>
                  <th class="optional-field">Cost Price</th>
                  <th class="optional-field">Margin</th>
                  <th class="optional-field">Discount</th>
                  <th class="optional-field">Discounted Price</th>
                  <th class="optional-field">Stock</th>
                  <th class="optional-field">Remaining Stock</th>
                  <th class="optional-field">Dimensions</th>
                  <th class="optional-field">Color</th>
                  <th class="optional-field">Size</th>
                  <th class="optional-field">Supplier ID</th>
                  <th class="optional-field">Image</th>
                  <th class="optional-field">Status</th>
                </tr>
              </thead>
              <tbody>
                <?php
                  $ret = mysqli_query($con, "SELECT tblcategory.CategoryName, tblsubcategory.SubCategoryname as subcat, tblproducts.ProductName, tblproducts.BrandName, tblproducts.ID as pid, tblproducts.Status, tblproducts.ModelNumber, tblproducts.Stock, tblproducts.Barcode, tblproducts.Price, tblproducts.CostPrice, tblproducts.Margin, tblproducts.Discount, tblproducts.DiscountedPrice, tblproducts.Weight, tblproducts.Dimensions, tblproducts.Color, tblproducts.Size, tblproducts.SupplierID, tblproducts.ImageURL, IFNULL(SUM(tblcart.ProductQty), 0) as selledqty FROM tblproducts LEFT JOIN tblcategory ON tblcategory.ID = tblproducts.CatID LEFT JOIN tblsubcategory ON tblsubcategory.ID = tblproducts.SubcatID LEFT JOIN tblcart ON tblproducts.ID = tblcart.ProductId GROUP BY tblproducts.ID");
                  $num = mysqli_num_rows($ret);
                  if ($num > 0) {
                    $cnt = 1;
                    while ($row = mysqli_fetch_array($ret)) {
                      $qty = $row['selledqty'];
                      $imagePath = './admin/product_img/' . $row['ImageURL'];
                      if (!file_exists($imagePath) || empty($row['ImageURL'])) {
                        $imagePath = './admin/product_img/NA.jpg'; // Default image if the product image doesn't exist
                      }
                ?>
                <tr class="gradeX">
                  <td><?php echo $cnt;?></td>
                  <td><?php echo $row['ProductName'] ?: 'N/A';?></td>
                  <td><?php echo $row['Price'] ?: 'N/A';?></td>
                  <td><?php echo $row['Stock'] ?: 'N/A';?></td>
                  <td><?php echo $row['Weight'] ?: 'N/A';?></td>
                  <td><?php echo $row['ModelNumber'] ?: 'N/A';?></td>
                  <td class="optional-field"><?php echo $row['CategoryName'] ?: 'N/A';?></td>
                  <td class="optional-field"><?php echo $row['subcat'] ?: 'N/A';?></td>
                  <td class="optional-field"><?php echo $row['BrandName'] ?: 'N/A';?></td>
                  <td class="optional-field"><?php echo $row['Barcode'] ?: 'N/A';?></td>
                  <td class="optional-field"><?php echo $row['CostPrice'] ?: 'N/A';?></td>
                  <td class="optional-field"><?php echo $row['Margin'] ?: 'N/A';?></td>
                  <td class="optional-field"><?php echo $row['Discount'] ?: 'N/A';?></td>
                  <td class="optional-field"><?php echo $row['DiscountedPrice'] ?: 'N/A';?></td>
                  <td class="optional-field"><?php echo $row['Stock'] ?: 'N/A';?></td>
                  <td class="optional-field"><?php echo ($row['Stock'] - $qty) ?: 'N/A';?></td>
                  <td class="optional-field"><?php echo $row['Dimensions'] ?: 'N/A';?></td>
                  <td class="optional-field"><?php echo $row['Color'] ?: 'N/A';?></td>
                  <td class="optional-field"><?php echo $row['Size'] ?: 'N/A';?></td>
                  <td class="optional-field"><?php echo $row['SupplierID'] ?: 'N/A';?></td>
                  <td class="optional-field"><img src="<?php echo $imagePath;?>" alt="Product Image" width="50" height="50"></td>
                  <td class="optional-field"><?php echo ($row['Status'] == 1) ? "Active" : "Inactive"; ?></td>
                </tr>
                <?php 
                    $cnt = $cnt + 1;
                  } 
                } else { ?>
                <tr>
                  <td colspan="21">No record found.</td>
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
<?php include_once('includes/footer.php');?>
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
$(document).ready(function() {
    $('#dataTable').DataTable();
});
</script>
</body>
</html>
<?php } ?>
