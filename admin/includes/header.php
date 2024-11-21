<!--Header-part-->
<div id="header" style="background-color: #333; padding: 10px 20px;">
  <h2 style="margin: 0; color: #fff;">
    <a href="dashboard.php" style="text-decoration: none; color: #ff4d4d;">
      <strong>FLEX US</strong>
    </a>
  </h2>
</div>
<!--close-Header-part-->

<!--top-Header-menu-->
<div id="user-nav" class="navbar navbar-inverse" style="background-color: #444;">
  <ul class="nav" style="font-size: 16px;"> <!-- Set the font size for all items -->
    <?php
      $ret = mysqli_query($con, "SELECT AdminName FROM tbladmin");
      $row = mysqli_fetch_array($ret);
      $name = $row['AdminName'];
    ?>
    <li class="dropdown" id="profile-messages">
      <a title="" href="#" data-toggle="dropdown" class="dropdown-toggle">
        <i class="icon icon-user" style="color: #fff;"></i>
        <span class="text" style="color: #fff;">Welcome <?php echo $name; ?></span>
        <b class="caret" style="color: #fff;"></b>
      </a>
      <ul class="dropdown-menu">
        <li><a href="profile.php"><i class="icon-user"></i> My Profile</a></li>
        <li class="divider"></li>
        <li><a href="change-password.php"><i class="icon-check"></i> Settings</a></li>
        <li class="divider"></li>
        <li><a href="logout.php"><i class="icon-key"></i> Log Out</a></li>
      </ul>
    </li>
    <?php 
      $ret = mysqli_query($con, "SELECT * FROM tblcart WHERE IsCheckOut='0'");
      $cartcountcount = mysqli_num_rows($ret);

      // Low stock notifications
      $lowStockQuery = mysqli_query($con, "SELECT ProductName, Stock FROM tblproducts WHERE Stock <= 10");
      $lowStockCount = mysqli_num_rows($lowStockQuery);

      // Recent orders for notifications
      $recentOrdersQuery = mysqli_query($con, "SELECT tblproducts.ProductName, tblcart.ProductQty FROM tblcart JOIN tblproducts ON tblcart.ProductId = tblproducts.ID WHERE tblcart.IsCheckOut = '1' ORDER BY tblcart.CartDate DESC LIMIT 3");
    ?>
    <li id="menu-cart">
      <a href="cart.php">
        <i class="icon icon-shopping-cart" style="color: #fff;"></i>
        <span class="text" style="color: #fff;">Cart</span>
        <span class="badge badge-important"><?php echo htmlentities($cartcountcount); ?></span>
      </a>
    </li>
    <li class="dropdown" id="menu-notifications">
      <a href="#" data-toggle="dropdown" class="dropdown-toggle">
        <i class="icon icon-bell" style="color: #fff;"></i>
        <span class="text" style="color: #fff;">Notifications</span>
        <span class="badge badge-important"><?php echo $lowStockCount + mysqli_num_rows($recentOrdersQuery); ?></span>
      </a>
      <ul class="dropdown-menu">
        <li class="dropdown-header">Low Stock Alerts</li>
        <?php 
        if ($lowStockCount > 0) {
          while ($row = mysqli_fetch_array($lowStockQuery)) {
            echo '<li><a href="#"><i class="icon-warning-sign"></i> ' . $row['ProductName'] . ' is low on stock (' . $row['Stock'] . ' left)</a></li>';
          }
        } else {
          echo '<li><a href="#"><i class="icon-check"></i> No low stock alerts</a></li>';
        }
        ?>
        <li class="divider"></li>
        <li class="dropdown-header">Recent Orders</li>
        <?php 
        if (mysqli_num_rows($recentOrdersQuery) > 0) {
          while ($row = mysqli_fetch_array($recentOrdersQuery)) {
            echo '<li><a href="#"><i class="icon-bullhorn"></i> ' . $row['ProductName'] . ' ordered (' . $row['ProductQty'] . ' pcs)</a></li>';
          }
        } else {
          echo '<li><a href="#"><i class="icon-check"></i> No recent orders</a></li>';
        }
        ?>
      </ul>
    </li>
    <li><a title="" href="change-password.php"><i class="icon icon-cog" style="color: #fff;"></i> <span class="text" style="color: #fff;">Settings</span></a></li>
    <li><a title="" href="logout.php"><i class="icon icon-share-alt" style="color: #fff;"></i> <span class="text" style="color: #fff;">Logout</span></a></li>
  </ul>
</div>
<!--close-top-Header-menu-->

<style>
  .navbar-inverse .nav > li > a:hover, .navbar-inverse .nav > li > a:focus {
    background-color: #555;
  }

  .navbar-inverse .nav .dropdown-menu {
    background-color: #333;
  }

  .navbar-inverse .nav .dropdown-menu > li > a {
    color: #fff;
  }

  .navbar-inverse .nav .dropdown-menu > li > a:hover {
    background-color: #444;
  }

  .badge-important {
    background-color: #ff4d4d;
    color: #fff;
  }

  .navbar-inverse .dropdown-menu > li > a i {
    margin-right: 8px;
  }

  .dropdown-header {
    font-size: 14px;
    font-weight: bold;
    color: #ffcc00;
    padding: 10px 15px;
    border-bottom: 1px solid #444;
  }
</style>
