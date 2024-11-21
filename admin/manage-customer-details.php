<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['imsaid']==0)) {
  header('location:logout.php');
} else {
  if(isset($_POST['submit'])) {
    $id = $_POST['id'];
    $custname = $_POST['customername'];
    $custmobilenum = $_POST['mobilenumber'];
    $custaddress = $_POST['customeraddress'];
    $modepayment = $_POST['modepayment'];

    $query = mysqli_query($con, "UPDATE tblcustomer SET CustomerName='$custname', MobileNumber='$custmobilenum', CustomerAddress='$custaddress', ModeofPayment='$modepayment' WHERE ID='$id'");
    
    if ($query) {
      echo '<script>alert("Customer details updated successfully.")</script>';
      echo "<script>window.location.href='customer-details.php'</script>";
    } else {
      echo '<script>alert("Something Went Wrong. Please try again.")</script>';
    }
  }

  if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $billingnumber = $_POST['billingnumber'];
    $custname = $_POST['customername'];
    $custmobilenum = $_POST['mobilenumber'];
    $custaddress = $_POST['customeraddress']; // Retrieve customer address here
    $modepayment = $_POST['modepayment'];
    $billingdate = $_POST['billingdate'];
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Inventory Management System || Manage Customer Details</title>
  <?php include_once('includes/cs.php'); ?>
</head>
<body>
  <?php include_once('includes/header.php'); ?>
  <?php include_once('includes/sidebar.php'); ?>

  <div id="content">
    <div id="content-header">
      <div id="breadcrumb">
        <a href="dashboard.php" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a>
        <a href="customer-details.php" class="current">Manage Customer Details</a>
      </div>
      <h1>Manage Customer Details</h1>
    </div>
    <div class="container-fluid">
      <hr>
      <div class="row-fluid">
        <div class="span12">
          <form method="post" class="form-horizontal">
            <input type="hidden" name="id" value="<?php echo $id;?>">
            <div class="control-group">
              <label class="control-label">Customer Name :</label>
              <div class="controls">
                <input type="text" class="span11" name="customername" value="<?php echo $custname;?>" required="true" />
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Customer Mobile Number :</label>
              <div class="controls">
                <input type="text" class="span11" name="mobilenumber" value="<?php echo $custmobilenum;?>" required="true" pattern="[0-9]+" maxlength="10" />
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Customer Address :</label>
              <div class="controls">
                <textarea class="span11" name="customeraddress" required="true"><?php echo $custaddress;?></textarea> <!-- Make sure this field is populated -->
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Mode of Payment :</label>
              <div class="controls">
                <select class="span11" name="modepayment" required="true">
                  <option value="cash" <?php if($modepayment=='cash'){echo 'selected';}?>>Cash</option>
                  <option value="card" <?php if($modepayment=='card'){echo 'selected';}?>>Card</option>
                  <option value="cheque" <?php if($modepayment=='cheque'){echo 'selected';}?>>Cheque</option>
                  <option value="bank" <?php if($modepayment=='bank'){echo 'selected';}?>>Bank Transfer</option>
                </select>
              </div>
            </div>
            <div class="form-actions">
              <button type="submit" class="btn btn-success" name="submit">Update</button>
              <a href="customer-details.php" class="btn btn-danger">Cancel</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <?php include_once('includes/footer.php'); ?>
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
