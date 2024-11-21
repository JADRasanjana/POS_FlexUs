<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['imsaid'] == 0)) {
  header('location:logout.php');
} else {
  if (isset($_POST['submit'])) {
    $eid = $_GET['editid'];
    $pname = $_POST['pname'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $weight = $_POST['weight'];
    $modelno = $_POST['modelno'];

    // Optional fields
    $category = !empty($_POST['category']) ? $_POST['category'] : NULL;
    $subcategory = !empty($_POST['subcategory']) ? $_POST['subcategory'] : NULL;
    $bname = !empty($_POST['bname']) ? $_POST['bname'] : NULL;
    $barcode = !empty($_POST['barcode']) ? $_POST['barcode'] : NULL;
    $costprice = !empty($_POST['costprice']) ? $_POST['costprice'] : NULL;
    $margin = !empty($_POST['margin']) ? $_POST['margin'] : NULL;
    $discount = !empty($_POST['discount']) ? $_POST['discount'] : NULL;
    $discountedprice = $price - ($price * $discount / 100);
    $dimensions = !empty($_POST['dimensions']) ? $_POST['dimensions'] : NULL;
    $color = !empty($_POST['color']) ? $_POST['color'] : NULL;
    $size = !empty($_POST['size']) ? $_POST['size'] : NULL;
    $supplierid = !empty($_POST['supplierid']) ? $_POST['supplierid'] : NULL;
    $status = isset($_POST['status']) ? 1 : 0;

    // Update query
    $query = "UPDATE tblproducts SET 
                ProductName='$pname',
                Price='$price',
                Stock='$stock',
                Weight='$weight',
                ModelNumber='$modelno',
                CatID=" . ($category !== NULL ? "'$category'" : "NULL") . ",
                SubcatID=" . ($subcategory !== NULL ? "'$subcategory'" : "NULL") . ",
                BrandName=" . ($bname !== NULL ? "'$bname'" : "NULL") . ",
                Barcode=" . ($barcode !== NULL ? "'$barcode'" : "NULL") . ",
                CostPrice=" . ($costprice !== NULL ? "'$costprice'" : "NULL") . ",
                Margin=" . ($margin !== NULL ? "'$margin'" : "NULL") . ",
                Discount=" . ($discount !== NULL ? "'$discount'" : "NULL") . ",
                DiscountedPrice='$discountedprice',
                Dimensions=" . ($dimensions !== NULL ? "'$dimensions'" : "NULL") . ",
                Color=" . ($color !== NULL ? "'$color'" : "NULL") . ",
                Size=" . ($size !== NULL ? "'$size'" : "NULL") . ",
                SupplierID=" . ($supplierid !== NULL ? "'$supplierid'" : "NULL") . ",
                Status='$status'
              WHERE ID='$eid'";

    $result = mysqli_query($con, $query);

    if ($result) {
      echo '<script>alert("Product has been updated.")</script>';
    } else {
      echo '<script>alert("Something Went Wrong. Please try again")</script>';
      echo "Error: " . $query . "<br>" . mysqli_error($con);
    }
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Inventory Management System || Update Products</title>
  <?php include_once('includes/cs.php'); ?>
  <script>
    function getSubCat(val) {
      $.ajax({
        type: "POST",
        url: "get-subcat.php",
        data: 'catid=' + val,
        success: function(data) {
          $("#subcategory").html(data);
        }
      });
    }

    function showMandatoryFields() {
      alert("Mandatory fields:\n- Product Name\n- Price\n- Quantity\n- Weight\n- Item Code");
    }

    function toggleOptionalFields() {
      var optionalFields = document.getElementById('optionalFields');
      if (optionalFields.style.display === 'none' || optionalFields.style.display === '') {
        optionalFields.style.display = 'block';
      } else {
        optionalFields.style.display = 'none';
      }
    }
  </script>
  <style>
    .optional-fields {
      display: none;
      margin-top: 20px;
    }
    .btn-toggle {
      margin-top: 20px;
    }
  </style>
</head>
<body>

<!--Header-part-->
<?php include_once('includes/header.php'); ?>
<?php include_once('includes/sidebar.php'); ?>

<div id="content">
  <div id="content-header">
    <div id="breadcrumb">
      <a href="dashboard.php" title="Go to Home" class="tip-bottom">
        <i class="icon-home"></i> Home
      </a>
      <strong>Update Product</strong>
    </div>
    <h1>Update Product</h1>
  </div>
  <div class="container-fluid">
    <hr>
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title">
            <span class="icon"><i class="icon-align-justify"></i></span>
            <h5>Update Product</h5>
          </div>
          <div class="widget-content nopadding">
            <form method="post" class="form-horizontal">
              <?php
              $eid = $_GET['editid'];
              $ret = mysqli_query($con, "SELECT tblproducts.*, tblcategory.CategoryName as catname, tblsubcategory.SubCategoryname as subcat FROM tblproducts 
                                         LEFT JOIN tblcategory ON tblcategory.ID = tblproducts.CatID 
                                         LEFT JOIN tblsubcategory ON tblsubcategory.ID = tblproducts.SubcatID 
                                         WHERE tblproducts.ID='$eid'");

              while ($row = mysqli_fetch_array($ret)) {
              ?>
                <div class="control-group">
                  <label class="control-label">Product Name :</label>
                  <div class="controls">
                    <input type="text" class="span11" name="pname" id="pname" value="<?php echo $row['ProductName']; ?>" required='true' />
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label">Price (per unit) :</label>
                  <div class="controls">
                    <input type="text" class="span11" name="price" id="price" value="<?php echo $row['Price']; ?>" required='true' />
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label">Quantity :</label>
                  <div class="controls">
                    <input type="text" class="span11" name="stock" id="stock" value="<?php echo $row['Stock']; ?>" required='true' />
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label">Weight :</label>
                  <div class="controls">
                    <input type="text" class="span11" name="weight" id="weight" value="<?php echo $row['Weight']; ?>" required='true' />
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label">Item Code :</label>
                  <div class="controls">
                    <input type="text" class="span11" name="modelno" id="modelno" value="<?php echo $row['ModelNumber']; ?>" required='true' />
                  </div>
                </div>

                <div id="optionalFields" class="optional-fields">
                  <div class="control-group">
                    <label class="control-label">Category :</label>
                    <div class="controls">
                      <select class="span11" name="category" id="category" onChange="getSubCat(this.value)">
                        <option value="<?php echo $row['CatID']; ?>"><?php echo $row['catname']; ?></option>
                        <?php
                        $query = mysqli_query($con, "SELECT * FROM tblcategory WHERE Status='1'");
                        while ($rw = mysqli_fetch_array($query)) {
                        ?>
                          <option value="<?php echo $rw['ID']; ?>"><?php echo $rw['CategoryName']; ?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                  <div class="control-group">
                    <label class="control-label">Sub Category Name :</label>
                    <div class="controls">
                      <select class="span11" name="subcategory" id="subcategory">
                        <option value="<?php echo $row['SubcatID']; ?>"><?php echo $row['subcat']; ?></option>
                      </select>
                    </div>
                  </div>
                  <div class="control-group">
                    <label class="control-label">Brand Name :</label>
                    <div class="controls">
                      <select class="span11" name="bname" id="bname">
                        <option value="<?php echo $row['BrandName']; ?>"><?php echo $row['BrandName']; ?></option>
                        <?php
                        $query1 = mysqli_query($con, "SELECT * FROM tblbrand WHERE Status='1'");
                        while ($row1 = mysqli_fetch_array($query1)) {
                        ?>
                          <option value="<?php echo $row1['BrandName']; ?>"><?php echo $row1['BrandName']; ?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                  <div class="control-group">
                    <label class="control-label">Barcode :</label>
                    <div class="controls">
                      <input type="text" class="span11" name="barcode" id="barcode" value="<?php echo $row['Barcode']; ?>" />
                    </div>
                  </div>
                  <div class="control-group">
                    <label class="control-label">Cost Price :</label>
                    <div class="controls">
                      <input type="text" class="span11" name="costprice" id="costprice" value="<?php echo $row['CostPrice']; ?>" />
                    </div>
                  </div>
                  <div class="control-group">
                    <label class="control-label">Margin :</label>
                    <div class="controls">
                      <input type="text" class="span11" name="margin" id="margin" value="<?php echo $row['Margin']; ?>" />
                    </div>
                  </div>
                  <div class="control-group">
                    <label class="control-label">Discount (%) :</label>
                    <div class="controls">
                      <input type="text" class="span11" name="discount" id="discount" value="<?php echo $row['Discount']; ?>" />
                    </div>
                  </div>
                  <div class="control-group">
                    <label class="control-label">Dimensions :</label>
                    <div class="controls">
                      <input type="text" class="span11" name="dimensions" id="dimensions" value="<?php echo $row['Dimensions']; ?>" />
                    </div>
                  </div>
                  <div class="control-group">
                    <label class="control-label">Color :</label>
                    <div class="controls">
                      <input type="text" class="span11" name="color" id="color" value="<?php echo $row['Color']; ?>" />
                    </div>
                  </div>
                  <div class="control-group">
                    <label class="control-label">Size :</label>
                    <div class="controls">
                      <input type="text" class="span11" name="size" id="size" value="<?php echo $row['Size']; ?>" />
                    </div>
                  </div>
                  <div class="control-group">
                    <label class="control-label">Supplier ID :</label>
                    <div class="controls">
                      <input type="text" class="span11" name="supplierid" id="supplierid" value="<?php echo $row['SupplierID']; ?>" />
                    </div>
                  </div>
                  <div class="control-group">
                    <label class="control-label">Status :</label>
                    <div class="controls">
                      <input type="checkbox" name="status" id="status" value="1" <?php if ($row['Status'] == "1") echo "checked='true'"; ?> />
                    </div>
                  </div>
                </div>
                <div class="form-actions">
                  <button type="submit" class="btn btn-success" name="submit">Update</button>
                  <button type="button" class="btn btn-info" onclick="showMandatoryFields()">Info</button>
                  <button type="button" class="btn btn-warning" onclick="toggleOptionalFields()">Show Optional Fields</button>
                </div>
              <?php } ?>
            </form>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>
<?php include_once('includes/footer.php'); ?>
<?php include_once('includes/js.php'); ?>
</body>
</html>
<?php } ?>
