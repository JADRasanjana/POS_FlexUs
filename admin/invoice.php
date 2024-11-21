<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['imsaid']==0)) {
  header('location:logout.php');
} else {
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Inventory Management System || Invoice</title>
  <?php include_once('includes/cs.php'); ?>
  <style>
  body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    color: #333;
    margin: 0;
    padding: 0;
  }

  .invoice-container {
    max-width: 800px; /* Reduced width for tighter layout */
    margin: 20px auto; /* Smaller margin */
    padding: 20px; /* Reduced padding */
    border-radius: 8px; /* Subtle rounding */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Lighter shadow for less emphasis */
    border: 1px solid #007bff;
  }

  .invoice-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px solid #007bff; /* Thinner line for subtlety */
    padding-bottom: 10px; /* Reduced padding */
    margin-bottom: 20px; /* Reduced margin */
  }

  .invoice-header img {
    max-width: 120px; /* Smaller logo size */
  }

  .invoice-header .company-info {
    text-align: right;
    font-size: 16px; /* Adjusted for space */
  }

  .invoice-header .company-info h2 {
    font-size: 24px; /* Smaller headline */
    color: #007bff;
    font-weight: 600;
  }

  .invoice-details, .invoice-table, .invoice-summary {
    margin-bottom: 20px; /* Reduced margin */
  }

  .invoice-details table, .invoice-table table, .invoice-summary table {
    width: 100%;
    border-collapse: collapse;
  }

  .invoice-details th, .invoice-details td, .invoice-table th, .invoice-table td, .invoice-summary th, .invoice-summary td {
    padding: 10px; /* Reduced padding */
    border: 1px solid #ddd;
    font-size: 14px; /* Smaller font size */
    background-color: #f9f9f9;
  }

  .invoice-table th {
    background-color: #007bff;
    color: #ffffff;
    font-weight: 600;
  }

  .invoice-summary {
    display: flex;
    justify-content: flex-end;
  }

  .invoice-summary table {
    width: 60%; /* Adjusted width for better layout */
  }

  .invoice-summary th, .invoice-summary td {
    text-align: right;
    font-size: 16px; /* Reduced font size */
    font-weight: 500;
  }

  .invoice-summary .total {
    font-weight: bold;
    color: #007bff;
  }

  .note {
    margin-top: 10px; /* Reduced margin */
    font-style: italic;
    font-size: 12px; /* Smaller font size */
    color: #555;
  }

  .signatures {
    display: flex;
    justify-content: space-between;
    margin-top: 30px; /* Reduced margin */
    
  }

  .signature-box {
    width: 30%;
    text-align: center;
    border-top: 1px solid #333;
    padding-top: 5px; /* Reduced padding */
  }

  .invoice-footer {
    text-align: center;
    margin-bottom: 30px;
  }

  @media print {
    .invoice-container {
      max-width: 100%; /* Full width for print */
      box-shadow: none;
      margin: 10px auto; /* Reduced margin for print */
      border-radius: 0;
      padding: 15px; /* Reduced padding for print */
    }

    .invoice-header, .invoice-footer {
      margin-bottom: 10px; /* Reduced margin for print */
    }

    .invoice-header {
      display: block;
      text-align: center;
    }

    .invoice-header .company-info {
      text-align: center;
      margin-top: 0;
    }

    .invoice-table th, .invoice-table td {
      font-size: 12px; /* Smaller font size for print */
    }

    .invoice-summary table {
      width: 100%; /* Full width for summaries in print */
    }

    .print-button {
      display: none; /* Hide print button when printing */
    }
  }
</style>

<script type="text/javascript">
    function print1(strid, invoiceNumber) {
        var values = document.getElementById(strid).innerHTML;
        var originalTitle = document.title;
        document.title = invoiceNumber + '_invoice.pdf';
        
        var printing = window.open('', '', 'left=0,top=0,width=800,height=900,toolbar=0,scrollbars=0,status=0');
        printing.document.write('<html><head><title>' + document.title + '</title>');  
        printing.document.write('<style>@media print {');
   // Body and general styles
    printing.document.write('body { font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif; margin: 0; padding: 0; color: #333; }');
    printing.document.write('.invoice-container { box-shadow: none; margin: 10px auto; border-radius: 8px; width: auto; max-width: 90%; padding: 20px; border: 1px solid #0056b3; }');
    // Header styles
    printing.document.write('.invoice-header{ display: flex; justify-content: space-between; align-items: center; border-bottom: 3px solid #0056b3; padding-bottom: 10px; margin-bottom: 10px; }');
    printing.document.write('.invoice-header img { max-width: 100px; }');
    printing.document.write('.invoice-header .company-info { text-align: right; }');
    printing.document.write('.invoice-header .company-info h2 { margin: 0; font-size: 24px; color: #0056b3; font-weight: 700; }');
    // Details, table, and summary styles
    printing.document.write('.invoice-details, .invoice-table, .invoice-summary { margin-bottom: 15px; }');
    printing.document.write('table { width: 100%; border-collapse: collapse; }');
    printing.document.write('th, td { padding: 8px; border: 1px solid #ccc; text-align: left; font-size: 14px; background-color: #fafafa; }');
    printing.document.write('.invoice-table th { background-color: #0056b3; color: #ffffff; font-weight: 600; }');
    printing.document.write('.invoice-summary { display: flex; justify-content: flex-end; }');
    printing.document.write('.invoice-summary table { width: 50%; }');
    printing.document.write('.invoice-summary th, .invoice-summary td { text-align: right; font-size: 16px; font-weight: 600; }');
    printing.document.write('.invoice-summary .total { font-weight: bold; font-size: 18px; color: #0056b3; }');
    // Footer and notes styles
    printing.document.write('.note { margin-top: 10px; font-style: italic; font-size: 14px; color: #666; }');
    printing.document.write('.signatures { display: flex; justify-content: space-between; margin-top: 30px; }');
    printing.document.write('.signature-box { width: 30%; text-align: center; border-top: 1px solid #333; padding-top: 5px; }');
    printing.document.write('.invoice-footer { text-align: center; margin-bottom: 20px; }');
    printing.document.write('.print-button { display: none; }');
        printing.document.write('}');
        printing.document.write('</style></head><body>');
        printing.document.write(values);
        printing.document.write('</body></html>');
        printing.document.close();
        printing.focus();
        printing.print();

        document.title = originalTitle;
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
      <a href="manage-category.php" class="current">Invoice</a>
    </div>
    <h1>Invoice</h1>
  </div>
  <div class="container-fluid">
    <hr>
    <div class="row-fluid">
      <div class="span12" id="print2">
        <div class="invoice-container">
          <div class="invoice-header">
            <div>
              <img src="../admin/img/logo/Flex-US.png" alt="Company Logo"> <!-- Add your logo path here -->
              <h3>Flexus Pharma (Pvt) Ltd</h3>
              <p>No.531,</p>
              <p>Ihalabiyanwila, Siyambalape.</p>
              <p>Sri Lanka.</p>
              <p>Phone: +94 11 297 7719</p>
              <p>E-mail: Contact@flexusfarma.com</p>
            </div>
            <div class="company-info">
              <h2>INVOICE</h2>
              <p>Date: <?php echo date("d M Y"); ?></p>
              <p>Invoice #: <?php echo $_SESSION['invoiceid']; ?></p>
            </div>
          </div>

          <?php
          $billingid = $_SESSION['invoiceid'];
          $ret = mysqli_query($con, "SELECT DISTINCT tblcustomer.CustomerName, tblcustomer.MobileNumber, tblcustomer.ModeofPayment, tblcustomer.CustomerAddress, tblcustomer.BillingDate FROM tblcart JOIN tblcustomer ON tblcustomer.BillingNumber=tblcart.BillingId WHERE tblcustomer.BillingNumber='$billingid'");

          while ($row = mysqli_fetch_array($ret)) {
          ?>

            <div class="invoice-details">
              <table>
                <tr>
                  <th>Customer Name:</th>
                  <td> <?php echo $row['CustomerName']; ?> </td>
                  <th>Customer Number:</th>
                  <td> <?php echo $row['MobileNumber']; ?> </td>
                </tr>
                <tr>
                  <th>Customer Address:</th>
                  <td colspan="3"> <?php echo $row['CustomerAddress']; ?> </td>
                </tr>
                <tr>
                  <th>Mode of Payment:</th>
                  <td colspan="3"> <?php echo $row['ModeofPayment']; ?> </td>
                </tr>
              </table>
            </div>
          <?php } ?>

          <div class="invoice-table">
            <table>
              <thead>
                <tr>
                  <th>Item Code</th>
                  <th>Item Description</th>
                  <th>Unit Price (LKR)</th>
                  <th>Quantity</th>
                  <th>Total (LKR)</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $ret = mysqli_query($con, "SELECT tblproducts.ID as itemid, tblproducts.ProductName, tblproducts.ModelNumber, tblproducts.Price, SUM(tblcart.ProductQty) as totalQty FROM tblcart JOIN tblproducts ON tblcart.ProductId=tblproducts.ID JOIN tblcustomer ON tblcustomer.BillingNumber=tblcart.BillingId WHERE tblcart.BillingId='$billingid' GROUP BY tblcart.ProductId");
                $cnt = 1;
                $gtotal = 0;

                while ($row = mysqli_fetch_array($ret)) {
                    $total = $row['totalQty'] * $row['Price'];
                ?>

                  <tr>
                    <td><?php echo $row['itemid']; ?></td>
                    <td><?php echo $row['ProductName']; ?></td>
                    <td><?php echo number_format($row['Price'], 2); ?> </td>
                    <td><?php echo ($pq = $row['totalQty']); ?></td>
                    <td><?php echo number_format($total, 2); ?></td>
                  </tr>
                <?php
                  $cnt = $cnt + 1;
                  $gtotal += $total;
                } ?>
              </tbody>
            </table>
          </div>

          <div class="invoice-summary">
            <table>
              <tr>
                <th class="total">Gross amount (LKR)</th>
                <td class="total"><?php echo number_format($gtotal, 2); ?> </td>
              </tr>
            </table>
          </div>

          <div class="signatures">
              <div class="signature-box">
                  <p>Prepared By</p>
              </div>
              <div class="signature-box">
                  <p>Authorized Signature</p>
              </div>
              <div class="signature-box">
                  <p>Good Receive Acknowledgement</p>
              </div>
          </div>

          <div class="note">
            <p>Optional note. </p>
          </div>

          <div class="invoice-footer">
            <p>Thank you for your business!</p>
            <p><input type="button" name="printbutton" value="Print" class="print-button" onclick="return print1('print2', '<?php echo $_SESSION['invoiceid']; ?>')" /></p>
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
</body>
</html>
<?php } ?>
