/* -------- Create PDF -------- */

$pdf = new TCPDF();
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor("Society Management");
$pdf->SetTitle("Monthly Report - " . $month);
$pdf->AddPage();

/* Use proper font */
$pdf->SetFont('helvetica', '', 11);

$html = "<h2>Society Monthly Report - $month</h2>";

$html .= "<table border='1' cellpadding='5'>
<tr><td><b>Total Members</b></td><td>$total_members</td></tr>
<tr><td><b>Expected Collection</b></td><td>Rs. " . number_format($expected) . "</td></tr>
<tr><td><b>Collected</b></td><td>Rs. " . number_format($collected) . "</td></tr>
<tr><td><b>Total Expense</b></td><td>Rs. " . number_format($total_expense) . "</td></tr>
<tr><td><b>Balance</b></td><td>Rs. " . number_format($balance) . "</td></tr>
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
                    <td>Rs. " . number_format($data[2]) . "</td>
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
