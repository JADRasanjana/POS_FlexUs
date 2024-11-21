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
<title>Inventory Management System|| Manage Products</title>
<?php include_once('includes/cs.php');?>

<style>
        .dataTables_wrapper {
            width: 100%;
            overflow: auto;
        }
        .product-image {
            width: 50px;
            height: 50px;
        }
        .btn-action {
            margin: 0 5px;
        }
        .table th, .table td {
            vertical-align: middle !important;
            text-align: center;
        }
        .optional-field {
            display: none;
        }
</style>
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
</head>
<body>

<?php include_once('includes/header.php');?>
<?php include_once('includes/sidebar.php');?>


<div id="content">
  <div id="content-header">
    <div id="breadcrumb">
      <a href="dashboard.php" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a>
      <a href="manage-product.php" class="current">Manage Products</a>
    </div>
    <h1>Manage Products</h1>
  </div>
  <div class="container-fluid">
    <hr>
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title">
            <span class="icon"><i class="icon-th"></i></span>
            <h5>Manage Products</h5>
          </div>
          <div class="widget-content nopadding table-responsive">
            <button id="toggleButton" onclick="toggleOptionalFields()" class="btn btn-info" style="margin: 10px;">Show Optional Fields</button>
            <table class="table table-bordered data-table">
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
                  <th class="optional-field">Weight</th>
                  <th class="optional-field">Dimensions</th>
                  <th class="optional-field">Color</th>
                  <th class="optional-field">Size</th>
                  <th class="optional-field">Supplier ID</th>
                  <th class="optional-field">Image</th>
                  <th class="optional-field">Status</th>
                  <th class="optional-field">Creation Date</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $ret = mysqli_query($con, "SELECT tblproducts.*, tblcategory.CategoryName, tblsubcategory.SubCategoryname as subcat 
                                           FROM tblproducts 
                                           LEFT JOIN tblcategory ON tblcategory.ID = tblproducts.CatID 
                                           LEFT JOIN tblsubcategory ON tblsubcategory.ID = tblproducts.SubcatID");

                $cnt = 1;
                while ($row = mysqli_fetch_array($ret)) {
                  $imagePath = '../admin/product_img/' . $row['ImageURL'];
                  if (!file_exists($imagePath)) {
                    $imagePath = '../admin/product_img/NA.jpg'; // Default image if the product image doesn't exist
                  }
                ?>
                <tr class="gradeX">
                  <td><?php echo $cnt;?></td>
                  <td><?php echo $row['ProductName'];?></td>
                  <td><?php echo $row['Price'];?></td>
                  <td><?php echo $row['Stock'];?></td>
                  <td><?php echo $row['Weight'];?></td>
                  <td><?php echo $row['ModelNumber'];?></td>
                  <td class="optional-field"><?php echo $row['CategoryName'];?></td>
                  <td class="optional-field"><?php echo $row['subcat'];?></td>
                  <td class="optional-field"><?php echo $row['BrandName'];?></td>
                  <td class="optional-field"><?php echo $row['Barcode'];?></td>
                  <td class="optional-field"><?php echo $row['CostPrice'];?></td>
                  <td class="optional-field"><?php echo $row['Margin'];?></td>
                  <td class="optional-field"><?php echo $row['Discount'];?></td>
                  <td class="optional-field"><?php echo $row['DiscountedPrice'];?></td>
                  <td class="optional-field"><?php echo $row['Stock'];?></td>
                  <td class="optional-field"><?php echo $row['Weight'];?></td>
                  <td class="optional-field"><?php echo $row['Dimensions'];?></td>
                  <td class="optional-field"><?php echo $row['Color'];?></td>
                  <td class="optional-field"><?php echo $row['Size'];?></td>
                  <td class="optional-field"><?php echo $row['SupplierID'];?></td>
                  <td class="optional-field"><img src="<?php echo $imagePath;?>" alt="Product Image" class="product-image"></td>
                  <?php if ($row['Status'] == "1") { ?>
                    <td class="optional-field"><?php echo "Active"; ?></td>
                  <?php } else { ?>
                    <td class="optional-field"><?php echo "Inactive"; ?></td>
                  <?php } ?>
                  <td class="optional-field"><?php echo $row['CreationDate'];?></td>
                  <td class="center">
                    <a href="editproducts.php?editid=<?php echo $row['ID'];?>" class="btn btn-primary btn-action"><i class="icon-edit"></i> Edit</a>
                    <a href="deleteproduct.php?delid=<?php echo $row['ID'];?>" class="btn btn-danger btn-action" onclick="return confirm('Are you sure you want to delete this item?');"><i class="icon-trash"></i> Delete</a>
                  </td>
                </tr>
                <?php 
                  $cnt = $cnt + 1;
                } 
                ?> 
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
</body>
</html>
<?php } ?>
