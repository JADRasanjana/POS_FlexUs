<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (strlen($_SESSION['imsaid'] == 0)) {
  header('location:logout.php');
} else {
  $sdata = '';
  if (isset($_GET['invoiceid'])) {
    $sdata = $_GET['invoiceid'];
  }

  if (isset($_POST['search'])) {
    $sdata = $_POST['searchdata'];
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Inventory Management System || Search Invoice</title>
    <?php include_once('includes/cs.php'); ?>
    <style>
        .invoice-container {
            max-width: 900px;
            margin: 30px auto;
            background: #fff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
            border: 1px solid #007bff;
        }

        .invoice-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #007bff;
            padding-bottom: 15px;
        }

        .invoice-header img {
            max-width: 150px;
        }

        .invoice-header .company-info {
            text-align: right;
        }

        .invoice-header .company-info h2 {
            margin: 0;
            font-size: 28px;
            color: #007bff;
            font-weight: 600;
        }

        .invoice-details, .invoice-table, .invoice-summary {
            margin-bottom: 30px;
        }

        .invoice-details table, .invoice-table table, .invoice-summary table {
            width: 100%;
            border-collapse: collapse;
        }

        .invoice-details th, .invoice-details td, .invoice-table th, .invoice-table td, .invoice-summary th, .invoice-summary td {
            padding: 15px;
            border: 1px solid #ddd;
            text-align: left;
            font-size: 16px;
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
            width: 50%;
        }

        .invoice-summary th, .invoice-summary td {
            text-align: right;
            font-size: 18px;
            font-weight: 500;
        }

        .invoice-summary .total {
            font-weight: bold;
            color: #007bff;
        }

        .note {
            margin-top: 20px;
            font-style: italic;
            font-size: 14px;
            color: #555;
        }

        .signatures {
            display: flex;
            justify-content: space-between;
            margin-top: 50px;
        }

        .signature-box {
            width: 30%;
            text-align: center;
            border-top: 1px solid #333;
            padding-top: 10px;
        }

        @page {
            size: auto;
            margin: 0mm;
        }

        @media print {
            body {
                margin: 0;
                padding: 0;
                background-color: #fff;
            }

            .invoice-container {
                box-shadow: none;
                margin: 0;
                border-radius: 0;
                width: 100%;
                max-width: 100%;
                padding: 20px;
                page-break-before: always;
                page-break-after: always;
            }

            .invoice-header, .invoice-footer {
                margin-bottom: 20px;
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
                font-size: 14px;
            }

            .invoice-summary table {
                width: 100%;
            }

            .print-button {
                display: none;
            }

            @page {
                size: auto;
                margin: 0mm;
            }

            @media print {
                body::before {
                    content: "";
                    display: block;
                    height: 0;
                }

                body::after {
                    content: "";
                    display: block;
                    height: 0;
                }
            }
        }
    </style>

    <script type="text/javascript">
        function printInvoice(strid, invoiceNumber) {
            var values = document.getElementById(strid).innerHTML;
            var originalTitle = document.title;
            document.title = invoiceNumber + '_invoice.pdf';
            
            var printing = window.open('', '', 'left=0,top=0,width=800,height=900,toolbar=0,scrollbars=0,status=0');
            printing.document.write('<html><head><title>' + document.title + '</title>');  
            printing.document.write('<style>@media print { /* Print styles here */ }</style></head><body>');
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
            <a href="invoice-search.php" class="current">Search Invoice</a>
        </div>
        <h1>Search Invoice</h1>
    </div>
    <div class="container-fluid">
        <hr>
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-content nopadding">
                    <form method="post" class="form-horizontal">
                        <div class="control-group">
                            <label class="control-label">Search by Invoice #, Mobile #, Customer Name</label>
                            <div class="controls">
                                <input type="text" class="span11" name="searchdata" id="searchdata" value="<?php echo $sdata; ?>" required='true' placeholder="Enter search criteria" />
                            </div>
                        </div>
                        <div class="text-center">
                            <button class="btn btn-primary my-4" type="submit" name="search">Search</button>
                        </div>
                    </form>
                    <br>
                </div>
                <?php
                if ($sdata != '') {
                ?>
                <h4 align="center">Result against "<?php echo $sdata; ?>" keyword </h4>
                <div id="print2">
                <?php
                $ret = mysqli_query($con, "SELECT DISTINCT tblcustomer.CustomerName, tblcustomer.MobileNumber, tblcustomer.CustomerAddress, tblcustomer.ModeofPayment, tblcustomer.BillingDate, tblcustomer.BillingNumber FROM tblcart JOIN tblcustomer ON tblcustomer.BillingNumber=tblcart.BillingId WHERE (tblcustomer.BillingNumber='$sdata' || tblcustomer.MobileNumber='$sdata' || tblcustomer.CustomerName LIKE '%$sdata%' || tblcustomer.BillingDate='$sdata')");

                if(mysqli_num_rows($ret) > 0) {
                    while ($row = mysqli_fetch_array($ret)) {
                ?>
                <div class="invoice-container">
                    <div class="invoice-header">
                        <div>
                            <img src="../admin/img/logo/Flex-US.png" alt="Company Logo">
                            <h3>Flexus Pharma (Pvt) Ltd</h3>
                            <p>No.531,</p>
                            <p>Ihalabiyanwila, Siyambalape.</p>
                            <p>Sri Lanka.</p>
                            <p>Phone: +94 123 456 789</p>
                        </div>
                        <div class="company-info">
                            <h2>INVOICE</h2>
                            <p>Date: <?php echo date("d M Y", strtotime($row['BillingDate'])); ?></p>
                            <p>Invoice #: <?php echo $row['BillingNumber']; ?></p>
                        </div>
                    </div>

                    <div class="invoice-details">
                        <table>
                            <tr>
                                <th>Customer Name:</th>
                                <td><?php echo $row['CustomerName']; ?></td>
                                <th>Customer Mobile Number:</th>
                                <td><?php echo $row['MobileNumber']; ?></td>
                            </tr>
                            <tr>
                                <th>Customer Address:</th>
                                <td colspan="3"><?php echo $row['CustomerAddress']; ?></td>
                            </tr>
                            <tr>
                                <th>Mode of Payment:</th>
                                <td colspan="3"><?php echo $row['ModeofPayment']; ?></td>
                            </tr>
                        </table>
                    </div>
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
                                $invoiceid = $row['BillingNumber'];
                                $ret = mysqli_query($con, "SELECT tblproducts.ID as itemid, tblproducts.ProductName, tblproducts.ModelNumber, tblproducts.Price, SUM(tblcart.ProductQty) as totalQty FROM tblcart JOIN tblproducts ON tblcart.ProductId=tblproducts.ID JOIN tblcustomer ON tblcustomer.BillingNumber=tblcart.BillingId WHERE tblcart.BillingId='$invoiceid' GROUP BY tblcart.ProductId");
                                $cnt = 1;
                                $gtotal = 0;
                                if (mysqli_num_rows($ret) > 0) {
                                    while ($row = mysqli_fetch_array($ret)) {
                                        $total = $row['Price'] * $row['totalQty'];
                                        $gtotal += $total;
                                ?>
                                <tr>
                                    <td><?php echo $row['itemid']; ?></td>
                                    <td><?php echo $row['ProductName']; ?></td>
                                    <td><?php echo number_format($row['Price'], 2); ?></td>
                                    <td><?php echo $row['totalQty']; ?></td>
                                    <td><?php echo number_format($total, 2); ?></td>
                                </tr>
                                <?php
                                    $cnt++;
                                    }
                                ?>
                                <tr>
                                    <th colspan="4" style="text-align: right;" class="total">Gross amount (LKR)</th>
                                    <td class="total"><?php echo number_format($gtotal, 2); ?></td>
                                </tr>
                                <?php
                                } else {
                                    echo "<tr><td colspan='5' style='text-align: center;'>No products found</td></tr>";
                                }
                                ?>
                            </tbody>
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
                    <div class="invoice-footer">
                        <p>Thank you for your business!</p>
                    </div>
                </div>
                <?php
                    }
                } else {
                    echo "<p>No record found against this search.</p>";
                }
                ?>
                </div>
                <p style="text-align: center; padding-top: 30px">
                    <button class="btn btn-primary print-button" onclick="printInvoice('print2', '<?php echo $invoiceid; ?>')">Print</button>
                </p>
                <?php } ?>
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
