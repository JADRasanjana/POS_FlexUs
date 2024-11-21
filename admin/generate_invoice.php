<?php
session_start();
include('includes/dbconnection.php');
require('includes/fpdf/fpdf.php');

class PDF extends FPDF
{
    // Page header
    function Header()
    {
        // Arial bold 15
        $this->SetFont('Arial', 'B', 12);
        // Title
        $this->Cell(0, 10, 'Flexus Pharma (Pvt) Ltd', 0, 1, 'C');
        $this->SetFont('Arial', '', 10);
        $this->Cell(0, 10, 'No.531, Thalabiyaawila, Siyambalape, Sri Lanka.', 0, 1, 'C');
        $this->Cell(0, 10, 'Phone: +94 123 456 789', 0, 1, 'C');
        $this->Ln(10);
    }

    // Page footer
    function Footer()
    {
        // Position at 1.5 cm from bottom
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Page ' . $this->PageNo(), 0, 0, 'C');
    }

    // Table
    function FancyTable($header, $data)
    {
        // Colors, line width and bold font
        $this->SetFillColor(255, 0, 0);
        $this->SetTextColor(255);
        $this->SetDrawColor(128, 0, 0);
        $this->SetLineWidth(.3);
        $this->SetFont('', 'B');
        // Header
        $w = array(70, 30, 30, 30);
        for ($i = 0; $i < count($header); $i++) {
            $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C', true);
        }
        $this->Ln();
        // Color and font restoration
        $this->SetFillColor(224, 235, 255);
        $this->SetTextColor(0);
        $this->SetFont('');
        // Data
        $fill = false;
        foreach ($data as $row) {
            $this->Cell($w[0], 6, $row[0], 'LR', 0, 'L', $fill);
            $this->Cell($w[1], 6, $row[1], 'LR', 0, 'R', $fill);
            $this->Cell($w[2], 6, $row[2], 'LR', 0, 'C', $fill);
            $this->Cell($w[3], 6, $row[3], 'LR', 0, 'R', $fill);
            $this->Ln();
            $fill = !$fill;
        }
        // Closing line
        $this->Cell(array_sum($w), 0, '', 'T');
    }
}

if (isset($_GET['invoiceid'])) {
    $invoiceid = $_GET['invoiceid'];

    $pdf = new PDF();
    $pdf->AddPage();

    $billingid = $invoiceid;
    $ret = mysqli_query($con, "select distinct tblcustomer.CustomerName,tblcustomer.MobileNumber,tblcustomer.ModeofPayment,tblcustomer.BillingDate from tblcart join tblcustomer on tblcustomer.BillingNumber=tblcart.BillingId where tblcustomer.BillingNumber='$billingid'");
    $customer = mysqli_fetch_array($ret);

    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 10, 'INVOICE', 0, 1, 'C');
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(0, 10, 'Date: ' . date("d M Y"), 0, 1, 'C');
    $pdf->Cell(0, 10, 'Invoice #: ' . $invoiceid, 0, 1, 'C');
    // $pdf->Cell(0, 10, 'Tax Number: 18/455/12345', 0, 1, 'C');
    $pdf->Ln(10);

    $pdf->Cell(0, 10, 'Customer Name: ' . $customer['CustomerName'], 0, 1);
    $pdf->Cell(0, 10, 'Customer Number: ' . $customer['MobileNumber'], 0, 1);
    $pdf->Cell(0, 10, 'Mode of Payment: ' . $customer['ModeofPayment'], 0, 1);
    $pdf->Ln(10);

    $header = array('Item Description', 'Unit Price', 'Quantity', 'Total');
    $data = [];

    $ret = mysqli_query($con, "select tblproducts.ProductName, tblproducts.Price, tblcart.ProductQty from tblcart join tblproducts on tblcart.ProductId=tblproducts.ID where tblcart.BillingId='$billingid'");
    $gtotal = 0;
    while ($row = mysqli_fetch_array($ret)) {
        $total = $row['Price'] * $row['ProductQty'];
        $data[] = array($row['ProductName'], number_format($row['Price'], 2) . ' €', $row['ProductQty'], number_format($total, 2) . ' €');
        $gtotal += $total;
    }

    $pdf->FancyTable($header, $data);
    $pdf->Ln(10);

    $pdf->Cell(0, 10, 'Net amount: ' . number_format($gtotal / 1.19, 2) . ' €', 0, 1, 'R');
    $pdf->Cell(0, 10, 'Incl. 19% VAT: ' . number_format($gtotal - ($gtotal / 1.19), 2) . ' €', 0, 1, 'R');
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 10, 'Gross amount: ' . number_format($gtotal, 2) . ' €', 0, 1, 'R');
    $pdf->SetFont('Arial', '', 10);

    $pdf->Output('D', 'Invoice_' . $invoiceid . '.pdf');
}
?>
