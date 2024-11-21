<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

if (strlen($_SESSION['imsaid'] == 0)) {
    header('location:logout.php');
} else {
    if (isset($_POST['submit'])) {
        $pname = $_POST['pname'];
        $price = $_POST['price'];
        $stock = $_POST['qty'];
        $weight = $_POST['weight'];
        $modelno = $_POST['item_code'];

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

        // Image upload
        $image = $_FILES["image"]["name"];
        if ($image) {
            $extension = substr($image, strlen($image) - 4, strlen($image));
            $allowed_extensions = array(".jpg", ".jpeg", ".png", ".gif");
            if (!in_array($extension, $allowed_extensions)) {
                echo "<script>alert('Invalid format. Only jpg / jpeg/ png /gif format allowed');</script>";
            } else {
                $image = md5($image) . time() . $extension;
                $upload_path = "C:\\xampp\\htdocs\\inventoryms\\admin\\product_img\\" . $image;
                move_uploaded_file($_FILES["image"]["tmp_name"], $upload_path);
                $imageurl = "admin/product_img/" . $image;
            }
        } else {
            $imageurl = NULL;
        }

        $query = "INSERT INTO tblproducts (ProductName, Price, Stock, Weight, ModelNumber, CatID, SubcatID, BrandName, Barcode, CostPrice, Margin, Discount, DiscountedPrice, Dimensions, Color, Size, SupplierID, ImageURL, Status) VALUES ('$pname', '$price', '$stock', '$weight', '$modelno', " . ($category !== NULL ? "'$category'" : "NULL") . ", " . ($subcategory !== NULL ? "'$subcategory'" : "NULL") . ", " . ($bname !== NULL ? "'$bname'" : "NULL") . ", " . ($barcode !== NULL ? "'$barcode'" : "NULL") . ", " . ($costprice !== NULL ? "'$costprice'" : "NULL") . ", " . ($margin !== NULL ? "'$margin'" : "NULL") . ", " . ($discount !== NULL ? "'$discount'" : "NULL") . ", '$discountedprice', " . ($dimensions !== NULL ? "'$dimensions'" : "NULL") . ", " . ($color !== NULL ? "'$color'" : "NULL") . ", " . ($size !== NULL ? "'$size'" : "NULL") . ", " . ($supplierid !== NULL ? "'$supplierid'" : "NULL") . ", " . ($imageurl !== NULL ? "'$imageurl'" : "NULL") . ", '$status')";

        $result = mysqli_query($con, $query);

        if ($result) {
            echo '<script>alert("Product has been created.")</script>';
            header("Location: add-product.php");
            exit();
        } else {
            echo '<script>alert("Something Went Wrong. Please try again")</script>';
            echo "Error: " . $query . "<br>" . mysqli_error($con);
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Inventory Management System || Add Products</title>
<?php include_once('includes/cs.php');?>
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
<?php include_once('includes/header.php');?>
<?php include_once('includes/sidebar.php');?>

<div id="content">
<div id="content-header">
    <div id="breadcrumb"> 
    <a href="dashboard.php" title="Go to Home" class="tip-bottom">
        <i class="icon-home"></i> Home
    </a> 
    <a href="add-product.php" class="current">Add Product</a>
    </div>
    <h1>Add Product</h1>
</div>
<div class="container-fluid">
    <hr>
    <div class="row-fluid">
    <div class="span12">
        <div class="widget-box">
        <div class="widget-title"> 
            <span class="icon"> <i class="icon-align-justify"></i> </span>
            <h5>Add Product</h5>
        </div>
        <div class="widget-content nopadding">
            <form method="post" class="form-horizontal" enctype="multipart/form-data">
            <div class="control-group">
                <label class="control-label">Product Name :</label>
                <div class="controls">
                <input type="text" class="span11" name="pname" id="pname" required='true' placeholder="Enter Product Name" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Price (per unit) :</label>
                <div class="controls">
                <input type="text" class="span11" name="price" id="price" required="true" placeholder="Enter Price" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Quantity :</label>
                <div class="controls">
                <input type="text" class="span11" name="qty" id="qty" required="true" placeholder="Enter Quantity" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Weight :</label>
                <div class="controls">
                <input type="text" class="span11" name="weight" id="weight" required="true" placeholder="Enter Weight" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Item Code :</label>
                <div class="controls">
                <input type="text" class="span11" name="item_code" id="item_code" required="true" placeholder="Enter Item Code" />
                </div>
            </div>
            <div id="optionalFields" class="optional-fields">
                <div class="control-group">
                    <label class="control-label">Category :</label>
                    <div class="controls">
                    <select class="span11" name="category" id="category" onChange="getSubCat(this.value)">
                        <option value="">Select Category</option>
                        <?php 
                        $query = mysqli_query($con, "select * from tblcategory where Status='1'");
                        while ($row = mysqli_fetch_array($query)) { 
                        ?>      
                        <option value="<?php echo $row['ID'];?>"><?php echo $row['CategoryName'];?></option>
                        <?php } ?>
                    </select>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Sub Category :</label>
                    <div class="controls">
                    <select class="span11" name="subcategory" id="subcategory">
                        <option value="">Select Sub Category</option>
                    </select>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Brand Name :</label>
                    <div class="controls">
                    <select class="span11" name="bname" id="bname">
                        <option value="">Select Brand</option>
                        <?php 
                        $query1 = mysqli_query($con, "select * from tblbrand where Status='1'");
                        while ($row1 = mysqli_fetch_array($query1)) { 
                        ?>
                        <option value="<?php echo $row1['BrandName'];?>"><?php echo $row1['BrandName'];?></option>
                        <?php } ?>
                    </select>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Barcode :</label>
                    <div class="controls">
                    <input type="text" class="span11" name="barcode" id="barcode" placeholder="Enter Barcode" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Cost Price :</label>
                    <div class="controls">
                    <input type="text" class="span11" name="costprice" id="costprice" placeholder="Enter Cost Price" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Margin :</label>
                    <div class="controls">
                    <input type="text" class="span11" name="margin" id="margin" placeholder="Enter Margin" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Discount (%) :</label>
                    <div class="controls">
                    <input type="text" class="span11" name="discount" id="discount" placeholder="Enter Discount" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Dimensions :</label>
                    <div class="controls">
                    <input type="text" class="span11" name="dimensions" id="dimensions" placeholder="Enter Dimensions" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Color :</label>
                    <div class="controls">
                    <input type="text" class="span11" name="color" id="color" placeholder="Enter Color" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Size :</label>
                    <div class="controls">
                    <input type="text" class="span11" name="size" id="size" placeholder="Enter Size" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Supplier ID :</label>
                    <div class="controls">
                    <input type="text" class="span11" name="supplierid" id="supplierid" placeholder="Enter Supplier ID" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Image :</label>
                    <div class="controls">
                    <input type="file" class="span11" name="image" id="image" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Status :</label>
                    <div class="controls">
                    <input type="checkbox" name="status" id="status" value="1" />
                    </div>
                </div>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-success" name="submit">Add</button>
                <button type="button" class="btn btn-info" onclick="showMandatoryFields()">Info</button>
                <button type="button" class="btn btn-warning" onclick="toggleOptionalFields()">Show Optional Fields</button>
            </div>
            </form>
        </div>
        </div>
    </div>
    </div>
</div>

<?php include_once('includes/footer.php');?>
<?php include_once('includes/js.php');?>
</body>
</html>
<?php } ?>
