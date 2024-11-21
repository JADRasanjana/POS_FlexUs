<?php
include('includes/dbconnection.php');
if(isset($_POST["query"])) {
  $output = '';
  $query = "SELECT * FROM tblproducts WHERE ProductName LIKE '%".$_POST["query"]."%'";
  $result = mysqli_query($con, $query);
  $output = '<ul class="list-unstyled">';
  if(mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_array($result)) {
      $output .= '<li>'.$row["ProductName"].'</li>';
    }
  } else {
    $output .= '<li>Product Not Found</li>';
  }
  $output .= '</ul>';
  echo $output;
}
?>
