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
<title>Inventory Management System || Customer Details</title>
<?php include_once('includes/cs.php');?>
</head>
<body>

<?php include_once('includes/header.php');?>
<?php include_once('includes/sidebar.php');?>

<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> 
      <a href="dashboard.php" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> 
      <a href="customer-details.php" class="current">Customer Details</a> 
    </div>
    <h1>Customer Details</h1>
  </div>
  <div class="container-fluid">
    <hr>
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> 
            <span class="icon"><i class="icon-th"></i></span>
            <h5>Customer Details</h5>
          </div>
          <div class="widget-content nopadding">
            <table class="table table-bordered data-table">
              <thead>
                <tr>
                  <th>S.NO</th>
                  <th>Invoice ID</th>
                  <th>Customer Name</th>
                  <th>Mobile Number</th>
                  <th>Customer Address</th>
                  <th>Payment Mode</th>
                  <th>Order Date</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php
                  $ret=mysqli_query($con,"SELECT * FROM tblcustomer");
                  $cnt=1;
                  while ($row=mysqli_fetch_array($ret)) {
                ?>
                <tr class="gradeX">
                  <td><?php echo $cnt;?></td>
                  <td><?php echo $row['BillingNumber'];?></td>
                  <td><?php echo $row['CustomerName'];?></td>
                  <td><?php echo $row['MobileNumber'];?></td>
                  <td><?php echo $row['CustomerAddress'];?></td>
                  <td><?php echo $row['ModeofPayment'];?></td>
                  <td><?php echo $row['BillingDate'];?></td>
                  <td>
                    <form action="manage-customer-details.php" method="post" style="display:inline;">
                      <input type="hidden" name="id" value="<?php echo $row['ID'];?>">
                      <input type="hidden" name="billingnumber" value="<?php echo $row['BillingNumber'];?>">
                      <input type="hidden" name="customername" value="<?php echo $row['CustomerName'];?>">
                      <input type="hidden" name="mobilenumber" value="<?php echo $row['MobileNumber'];?>">
                      <input type="hidden" name="customeraddress" value="<?php echo $row['CustomerAddress'];?>">
                      <input type="hidden" name="modepayment" value="<?php echo $row['ModeofPayment'];?>">
                      <input type="hidden" name="billingdate" value="<?php echo $row['BillingDate'];?>">
                      <button type="submit" class="btn btn-primary btn-action">Update</button>
                    </form>
                    <a href="delete-customer-details.php?delid=<?php echo $row['ID'];?>" class="btn btn-danger btn-action" onclick="return confirm('Are you sure you want to delete this customer?');">Delete</a>
                    <a href="invoice-search.php?invoiceid=<?php echo $row['BillingNumber'];?>" class="btn btn-info btn-action">View Invoice</a>
                  </td>
                </tr>
                <?php 
                  $cnt=$cnt+1;
                }?> 
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
