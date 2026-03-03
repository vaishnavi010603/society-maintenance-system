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

$total_members = count(file($members_file)) - 1;
$expected = $total_members * 1000;

$payments = file($payment_file);
$collected_count = 0;
$unpaid = [];

foreach ($payments as $index => $line) {
    if ($index == 0) continue;
    $data = explode(",", trim($line));
    if ($data[2] == "Yes") {
        $collected_count++;
    } else {
        $unpaid[] = $data[0];
    }
}

$collected = $collected_count * 1000;

$expenses = file($expense_file);
$total_expense = 0;

foreach ($expenses as $line) {
    $data = explode(",", trim($line));
    if (isset($data[2])) {
        $total_expense += $data[2];
    }
}

$balance = $collected - $total_expense;

/* ---- Create PDF ---- */
$pdf = new TCPDF();
$pdf->AddPage();
$pdf->SetFont('helvetica', '', 12);

$html = "
<h2>Society Monthly Report - $month</h2>
<p><b>Expected Collection:</b> Rs. $expected</p>
<p><b>Collected:</b> Rs. $collected</p>
<p><b>Total Expenses:</b> Rs. $total_expense</p>
<p><b>Balance:</b> Rs. $balance</p>
";

$pdf->writeHTML($html);
$pdf->Output("Society_Report_$month.pdf", 'D');
?>
