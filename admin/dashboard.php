<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
include('includes/dbconnection.php');
if (strlen($_SESSION['imsaid'] == 0)) {
  header('location:logout.php');
} else {
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Inventory Management System | Dashboard</title>
<?php include_once('includes/cs.php');?>
<style>
  body {
    font-family: Arial, sans-serif;
  }
  .container-fluid {
    padding: 20px;
  }
  .widget-box {
    padding: 20px;
    border-radius: 10px;
    margin-bottom: 20px;
  }
  .widget-box h3 {
    margin-bottom: 20px;
    color: #337ab7;
  }
  .quick-actions {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    margin-top: 20px;
  }
  .site-stats {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    margin-top: 20px;
    margin-left: 10px;
  }
  .site-stats li {
    flex: 1 1 23%;
    margin: 15px;
    padding: 20px;
    border-radius: 10px;
    background-color: #e6e6e6;
    text-align: center;
    transition: background-color 0.3s, color 0.3s;
    color: #333;
  }
  .site-stats li:hover {
    background-color: #d9d9d9;
    color: #333;
  }
  .notification {
    background-color: #ffcc00;
    padding: 20px;
    border-radius: 10px;
    margin: 20px 0;
  }
  .widget-box ul {
    list-style: none;
    padding: 0;
  }
  .widget-box ul li {
    margin: 10px 1px;
    padding: 10px;
    border-radius: 10px;
    display: flex;
    justify-content: space-between;
    color: #333;
  }
  .widget-box ul li span {
    flex: 1;
    text-align: center;
  }
  .popup {
    display: none;
    position: fixed;
    top: 20px;
    right: 20px;
    background-color: #fff;
    padding: 15px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    border-radius: 5px;
    z-index: 1000;
    border-left: 5px solid #ffcc00;
  }
  .popup.show {
    display: block;
  }
  .popup p {
    margin: 0;
    padding: 0;
  }
  .popup .close-btn {
    position: absolute;
    top: 5px;
    right: 5px;
    background-color: transparent;
    border: none;
    font-size: 16px;
    cursor: pointer;
  }
  .modern-table {
    width: 100%;
    border-collapse: collapse;
    margin: 20px 0;
    font-size: 1em;
    font-family: Arial, sans-serif;
    min-width: 400px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
  }
  .modern-table thead tr {
    background-color: #009879;
    color: #ffffff;
    text-align: left;
  }
  .modern-table th,
  .modern-table td {
    padding: 12px 15px;
  }
  .modern-table tbody tr {
    border-bottom: 1px solid #dddddd;
  }
  .modern-table tbody tr:nth-of-type(even) {
    background-color: #f3f3f3;
  }
  .modern-table tbody tr:last-of-type {
    border-bottom: 2px solid #009879;
  }
  .modern-table tbody tr:hover {
    background-color: #f1f1f1;
    cursor: pointer;
  }
  .chart-container {
    width: 100%;
    height: 400px;
    margin: 20px 0;
  }
</style>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
    </div>
  </div>

<div class="popup" id="lowStockPopup">
  <button class="close-btn" onclick="closePopup()">×</button>
  <p>Low stock alert for some products. Please check the Notifications section for details.</p>
</div>

  <div class="container-fluid">
    <div class="widget-box widget-plain">
      <div class="center">
        <ul class="quick-actions">
          <?php $query1 = mysqli_query($con, "SELECT * FROM tblbrand WHERE Status='1'");
          $brandcount = mysqli_num_rows($query1); ?>
          <li class="bg_lb"> <a href="manage-brand.php"><i class="fa fa-building-o fa-3x"></i><br /> 
          <span class="label label-important" style="margin-top:5%"><?php echo $brandcount;?></span> Brands </a> </li> 
          <?php $query2 = mysqli_query($con, "SELECT * FROM tblcategory WHERE Status='1'");
          $catcount = mysqli_num_rows($query2); ?>
          <li class="bg_ly"> <a href="manage-category.php"> <i class="icon-list fa-3x"></i>
          <span class="label label-success" style="margin-top:7%"><?php echo $catcount;?></span> Categories </a> </li>
          <?php $query3 = mysqli_query($con, "SELECT * FROM tblsubcategory WHERE Status='1'");
          $subcatcount = mysqli_num_rows($query3); ?>
          <li class="bg_lo"> <a href="manage-subcategory.php">  <i class="icon-th"></i> <span class="label label--success" style="margin-top:7%"><?php echo $subcatcount;?>    </span>&nbsp; Subcategories</a> </li>
          <?php $query4 = mysqli_query($con, "SELECT * FROM tblproducts");
          $productcount = mysqli_num_rows($query4); ?>
          <li class="bg_ls"> <a href="manage-product.php"> <i class="icon-list-alt"></i>
          <span class="label label-success" style="margin-top:7%"><?php echo $productcount;?></span>  Products</a> </li>
          <?php $query5 = mysqli_query($con, "SELECT * FROM tblcustomer");
          $totuser = mysqli_num_rows($query5); ?>
          <li class="bg_lo span3"> <a href="customer-details.php"> <i class="icon-user"></i>
          <span class="label label--success" style="margin-top:5%"><?php echo $totuser;?>    </span> Users</a> </li>
        </ul>
      </div>
    </div>

    <div class="widget-box">
      <h3>Sales Overview</h3>
      <ul class="site-stats">
        <?php
        // Today's sale
        $todysale = 0;
        $query6 = mysqli_query($con, "SELECT tblcart.ProductQty as ProductQty, tblproducts.Price FROM tblcart JOIN tblproducts ON tblproducts.ID = tblcart.ProductId WHERE DATE(CartDate) = CURDATE() AND IsCheckOut = '1'");
        while($row = mysqli_fetch_array($query6)) {
          $todays_sale = $row['ProductQty'] * $row['Price'];
          $todysale += $todays_sale;
        }
        ?>
        <li><font style="font-size:22px; font-weight:bold">LKR</font><strong><?php echo number_format($todysale,2);?></strong> <small>Today's Sales</small></li>
        <?php
        // Yesterday's sale
        $yesterdaysale = 0;
        $query7 = mysqli_query($con, "SELECT tblcart.ProductQty as ProductQty, tblproducts.Price FROM tblcart JOIN tblproducts ON tblproducts.ID = tblcart.ProductId WHERE DATE(CartDate) = CURDATE() - INTERVAL 1 DAY AND IsCheckOut = '1'");
        while($row = mysqli_fetch_array($query7)) {
          $yesterdays_sale = $row['ProductQty'] * $row['Price'];
          $yesterdaysale += $yesterdays_sale;
        }
        ?>
        <li><font style="font-size:22px; font-weight:bold">LKR</font> <strong><?php echo number_format($yesterdaysale,2);?></strong> <small>Yesterday's Sales</small></li>
        <?php
        // Last 7 days' sale
        $tseven = 0;
        $query8 = mysqli_query($con, "SELECT tblcart.ProductQty as ProductQty, tblproducts.Price FROM tblcart JOIN tblproducts ON tblproducts.ID = tblcart.ProductId WHERE DATE(tblcart.CartDate) >= (DATE(NOW()) - INTERVAL 7 DAY) AND tblcart.IsCheckOut = '1'");
        while($row = mysqli_fetch_array($query8)) {
          $sevendays_sale = $row['ProductQty'] * $row['Price'];
          $tseven += $sevendays_sale;
        }
        ?>
        <li><font style="font-size:22px; font-weight:bold">LKR</font> <strong><?php echo number_format($tseven,2);?></strong> <small>Last 7 Days Sales</small></li>
        <?php
        // Total sale
        $totalsale = 0;
        $query9 = mysqli_query($con, "SELECT tblcart.ProductQty as ProductQty, tblproducts.Price FROM tblcart JOIN tblproducts ON tblproducts.ID = tblcart.ProductId WHERE IsCheckOut = '1'");
        while($row = mysqli_fetch_array($query9)) {
          $total_sale = $row['ProductQty'] * $row['Price'];
          $totalsale += $total_sale;
        }
        ?>
        <li><font style="font-size:22px; font-weight:bold">LKR</font> <strong><?php echo number_format($totalsale,2);?></strong> <small>Total Sales</small></li>
      </ul>
    </div>

    <div class="widget-box">
      <h3>Stock Overview</h3>
      <ul class="site-stats">
        <li><strong><?php echo $productcount;?></strong> <small>Total Products</small></li>
        <?php
        $query10 = mysqli_query($con, "SELECT COUNT(*) as low_stock FROM tblproducts WHERE Stock <= 10");
        $lowstock = mysqli_fetch_assoc($query10)['low_stock'];
        ?>
        <li><strong><?php echo $lowstock;?></strong> <small>Low Stock Products</small></li>
        <?php
        $query11 = mysqli_query($con, "SELECT COUNT(*) as out_of_stock FROM tblproducts WHERE Stock = 0");
        $outofstock = mysqli_fetch_assoc($query11)['out_of_stock'];
        ?>
        <li><strong><?php echo $outofstock;?></strong> <small>Out of Stock Products</small></li>
      </ul>
    </div>

    <div class="widget-box">
      <h3>Stock Notifications</h3>
      <div class="notification">
        <?php
        $query12 = mysqli_query($con, "SELECT ProductName, Stock FROM tblproducts WHERE Stock <= 10");
        if (mysqli_num_rows($query12) > 0) {
          while ($row = mysqli_fetch_array($query12)) {
            echo '<p>Warning: Product "' . $row['ProductName'] . '" is low on stock (' . $row['Stock'] . ' items left).</p>';
          }
        } else {
          echo '<p>No low stock warnings.</p>';
        }
        ?>
      </div>
    </div>

    <div class="widget-box">
    <h3>Recent Orders</h3>
    <table class="modern-table">
      <thead>
        <tr>
          <th>Product Name</th>
          <th>Quantity</th>
          <th>Order Date</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $query13 = mysqli_query($con, "SELECT tblcart.ProductId, tblproducts.ProductName, tblcart.ProductQty, tblcart.CartDate FROM tblcart JOIN tblproducts ON tblcart.ProductId = tblproducts.ID WHERE tblcart.IsCheckOut = '1' ORDER BY tblcart.CartDate DESC LIMIT 5");
        if (mysqli_num_rows($query13) > 0) {
          while ($row = mysqli_fetch_array($query13)) {
            echo '<tr>';
            echo '<td>' . $row['ProductName'] . '</td>';
            echo '<td>' . $row['ProductQty'] . ' pcs</td>';
            echo '<td>' . date('d M Y', strtotime($row['CartDate'])) . '</td>';
            echo '</tr>';
          }
        } else {
          echo '<tr><td colspan="3">No recent orders.</td></tr>';
        }
        ?>
      </tbody>
    </table>
    </div>

    <div class="widget-box">
    <h3>Top Selling Products</h3>
    <table class="modern-table">
      <thead>
        <tr>
          <th>Product Name</th>
          <th>Total Sold</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $query14 = mysqli_query($con, "SELECT tblproducts.ProductName, SUM(tblcart.ProductQty) as total_sold FROM tblcart JOIN tblproducts ON tblcart.ProductId = tblproducts.ID WHERE tblcart.IsCheckOut = '1' GROUP BY tblcart.ProductId ORDER BY total_sold DESC LIMIT 5");

        if (!$query14) {
          die('Invalid query: ' . mysqli_error($con));
        }

        if (mysqli_num_rows($query14) > 0) {
          while ($row = mysqli_fetch_array($query14)) {
            echo '<tr>';
            echo '<td>' . $row['ProductName'] . '</td>';
            echo '<td>' . $row['total_sold'] . ' pcs sold</td>';
            echo '</tr>';
          }
        } else {
          echo '<tr><td colspan="2">No top selling products.</td></tr>';
        }
        ?>
      </tbody>
    </table>
    </div>

    <div class="widget-box">
      <h3>Sales and Stock Charts</h3>
      <div class="chart-container">
        <canvas id="salesChart"></canvas>
      </div>
      <div class="chart-container">
        <canvas id="stockChart"></canvas>
      </div>
    </div>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    var lowStock = <?php
      $lowStockQuery = mysqli_query($con, "SELECT COUNT(*) as low_stock FROM tblproducts WHERE Stock <= 10");
      $lowStockCount = mysqli_fetch_assoc($lowStockQuery)['low_stock'];
      echo $lowStockCount;
    ?>;
    if (lowStock > 0) {
      var popup = document.getElementById('lowStockPopup');
      popup.classList.add('show');
      setTimeout(function() {
        popup.classList.remove('show');
      }, 10000); // Hide the popup after 10 seconds
    }

    var salesData = {
      labels: ['Today', 'Yesterday', 'Last 7 Days', 'Total'],
      datasets: [{
        label: 'Sales ($)',
        data: [
          <?php echo $todysale; ?>,
          <?php echo $yesterdaysale; ?>,
          <?php echo $tseven; ?>,
          <?php echo $totalsale; ?>
        ],
        backgroundColor: [
          'rgba(255, 99, 132, 0.2)',
          'rgba(54, 162, 235, 0.2)',
          'rgba(75, 192, 192, 0.2)',
          'rgba(153, 102, 255, 0.2)'
        ],
        borderColor: [
          'rgba(255, 99, 132, 1)',
          'rgba(54, 162, 235, 1)',
          'rgba(75, 192, 192, 1)',
          'rgba(153, 102, 255, 1)'
        ],
        borderWidth: 1
      }]
    };

    var salesConfig = {
      type: 'bar',
      data: salesData,
      options: {
        scales: {
          y: {
            beginAtZero: true
          }
        }
      }
    };

    var salesChart = new Chart(
      document.getElementById('salesChart'),
      salesConfig
    );

    var stockData = {
      labels: ['Total Products', 'Low Stock Products', 'Out of Stock Products'],
      datasets: [{
        label: 'Stock Count',
        data: [
          <?php echo $productcount; ?>,
          <?php echo $lowstock; ?>,
          <?php echo $outofstock; ?>
        ],
        backgroundColor: [
          'rgba(255, 206, 86, 0.2)',
          'rgba(255, 159, 64, 0.2)',
          'rgba(255, 99, 132, 0.2)'
        ],
        borderColor: [
          'rgba(255, 206, 86, 1)',
          'rgba(255, 159, 64, 1)',
          'rgba(255, 99, 132, 1)'
        ],
        borderWidth: 1
      }]
    };

    var stockConfig = {
      type: 'pie',
      data: stockData,
    };

    var stockChart = new Chart(
      document.getElementById('stockChart'),
      stockConfig
    );

  });

  function closePopup() {
    var popup = document.getElementById('lowStockPopup');
    popup.classList.remove('show');
  }
</script>

<?php include_once('includes/footer.php');?>
<?php include_once('includes/js.php');?>
</body>
</html>
<?php } ?>
