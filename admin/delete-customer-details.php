<?php
session_start();
include('includes/dbconnection.php');

if (isset($_GET['delid'])) {
    $delid = intval($_GET['delid']);
    
    $query = "DELETE FROM tblcustomer WHERE ID='$delid'";
    $result = mysqli_query($con, $query);
    
    if ($result) {
        echo "<script>alert('Customer deleted successfully.');</script>";
        echo "<script>window.location.href='customer-details.php'</script>";
    } else {
        echo "<script>alert('Error: Could not delete customer. Please try again.');</script>";
        echo "<script>window.location.href='customer-details.php'</script>";
    }
}
?>
