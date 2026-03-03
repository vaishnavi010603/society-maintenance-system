<?php
session_start();
if (!isset($_SESSION["loggedin"])) {
    header("Location: login.php");
    exit();
}

require_once('lib/tcpdf/tcpdf.php');

$month = date("F-Y");

$payment_file = "data/payments/payments_" . $month . ".csv";
$expense_file = "data/expenses.csv";
$members_file = "data/members.csv";

/* -------- Safe File Handling -------- */

$members = file_exists($members_file) ? file($members_file) : [];
$total_members = count($members) > 0 ? count($members) - 1 : 0;
$expected = $total_members * 1000;

$payments = file_exists($payment_file) ? file($payment_file) : [];
$collected_count = 0;
$unpaid = [];

foreach ($payments as $index => $line) {

    if ($index == 0) continue;

    $data = str_getcsv(trim($line));

    if (isset($data[2]) && $data[2] == "Yes") {
        $collected_count++;
    } else if (isset($data[0])) {
        $unpaid[] = $data[0];
    }
}

$collected = $collected_count * 1000;

/* -------- Expense Calculation -------- */

$expenses = file_exists($expense_file) ? file($expense_file) : [];
$total_expense = 0;

foreach ($expenses as $index => $line) {

    if ($index == 0) continue;

    $data = str_getcsv(trim($line));

    if (isset($data[2])) {
        $total_expense += (int)$data[2];
    }
}

$balance = $collected - $total_expense;

/* -------- Create PDF -------- */

$pdf = new TCPDF();
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor("Society Management");
$pdf->SetTitle("Monthly Report - " . $month);
$pdf->AddPage();

$html = "<h2>Society Monthly Report - $month</h2>";

$html .= "<table border='1' cellpadding='5'>
<tr><td><b>Total Members</b></td><td>$total_members</td></tr>
<tr><td><b>Expected Collection</b></td><td>₹$expected</td></tr>
<tr><td><b>Collected</b></td><td>₹$collected</td></tr>
<tr><td><b>Total Expense</b></td><td>₹$total_expense</td></tr>
<tr><td><b>Balance</b></td><td>₹$balance</td></tr>
</table><br>";

/* -------- Expense Details Table -------- */

$html .= "<h3>Expense Details</h3>";
$html .= "<table border='1' cellpadding='5'>
<tr>
<th>Date</th>
<th>Description</th>
<th>Amount</th>
</tr>";

foreach ($expenses as $index => $line) {

    if ($index == 0) continue;

    $data = str_getcsv(trim($line));

    if (count($data) >= 3) {
        $html .= "<tr>
                    <td>{$data[0]}</td>
                    <td>{$data[1]}</td>
                    <td>₹{$data[2]}</td>
                  </tr>";
    }
}

$html .= "</table><br>";

/* -------- Unpaid Flats -------- */

$html .= "<h3>Unpaid Flats</h3>";
if (!empty($unpaid)) {
    $html .= implode(", ", $unpaid);
} else {
    $html .= "All payments received.";
}

$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output("Society_Report_" . $month . ".pdf", "D");
exit();
