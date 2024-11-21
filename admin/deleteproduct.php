<?php
session_start();
include('includes/dbconnection.php');

if (strlen($_SESSION['imsaid'] == 0)) {
    header('location:logout.php');
} else {
    if (isset($_GET['delid'])) {
        $productId = intval($_GET['delid']);  // Securely get the product ID from the URL

        // Ensure the ID is a valid integer and prevent SQL injection
        if ($productId > 0) {
            $query = mysqli_query($con, "DELETE FROM tblproducts WHERE ID='$productId'");

            if ($query) {
                echo "<script>alert('Product deleted successfully.');</script>";
            } else {
                echo "<script>alert('An error occurred while deleting the product. Please try again.');</script>";
            }
        } else {
            echo "<script>alert('Invalid product ID.');</script>";
        }

        // Redirect back to manage-product page
        echo "<script>window.location.href='manage-product.php';</script>";
    }
}
?>
s