<?php
session_start();
if (!isset($_SESSION["loggedin"])) {
    header("Location: login.php");
    exit();
}

$month = date("F-Y");

$members_file = "data/members.csv";
$payment_file = "data/payments/payments_" . $month . ".csv";
$expense_file = "data/expenses.csv";

/* -------- SAFE FILE HANDLING -------- */

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

$expenses = file_exists($expense_file) ? file($expense_file) : [];
$total_expense = 0;
$expense_list = [];

foreach ($expenses as $index => $line) {

    if ($index == 0) continue;

    $data = str_getcsv(trim($line));

    if (count($data) >= 3) {
        $total_expense += (int)$data[2];
        $expense_list[] = $data;
    }
}

$balance = $collected - $total_expense;
?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Monthly Report</title>

<style>
body {
    font-family: Arial, sans-serif;
    background: #f4f6f9;
    margin: 0;
    padding: 20px;
}

h2 {
    text-align: center;
    margin-bottom: 20px;
}

.summary {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 15px;
    margin-bottom: 25px;
}

.card {
    background: white;
    padding: 15px;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.08);
    text-align: center;
}

.card strong {
    font-size: 18px;
}

.unpaid-box {
    background: #fff3f3;
    padding: 15px;
    border-radius: 10px;
    margin-bottom: 25px;
}

.unpaid {
    color: #d32f2f;
    font-weight: bold;
}

table {
    width: 100%;
    border-collapse: collapse;
    background: white;
    box-shadow: 0 4px 10px rgba(0,0,0,0.08);
}

th, td {
    padding: 10px;
    border: 1px solid #ddd;
    text-align: center;
}

th {
    background: #1976d2;
    color: white;
}

.back {
    display: block;
    margin-top: 20px;
    text-align: center;
}
</style>
</head>

<body>

<h2>📊 Monthly Report - <?php echo $month; ?></h2>

<div class="summary">
    <div class="card">
        <div>Total Members</div>
        <strong><?php echo $total_members; ?></strong>
    </div>

    <div class="card">
        <div>Expected Collection</div>
        <strong>₹<?php echo $expected; ?></strong>
    </div>

    <div class="card">
        <div>Collected</div>
        <strong>₹<?php echo $collected; ?></strong>
    </div>

    <div class="card">
        <div>Total Expenses</div>
        <strong>₹<?php echo $total_expense; ?></strong>
    </div>

    <div class="card">
        <div>Balance</div>
        <strong>₹<?php echo $balance; ?></strong>
    </div>
</div>

<h3>❌ Unpaid Flats</h3>
<div class="unpaid-box unpaid">
<?php
if (!empty($unpaid)) {
    echo implode(", ", $unpaid);
} else {
    echo "All Flats Paid ✅";
}
?>
</div>

<h3>🧾 Expense Details</h3>

<table>
<tr>
    <th>Date</th>
    <th>Description</th>
    <th>Amount</th>
</tr>

<?php
if (!empty($expense_list)) {
    foreach ($expense_list as $exp) {
        echo "<tr>
                <td>{$exp[0]}</td>
                <td>{$exp[1]}</td>
                <td>₹{$exp[2]}</td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='3'>No Expenses Recorded</td></tr>";
}
?>

</table>

<a href="index.php" class="back">⬅ Back to Dashboard</a>

</body>
</html>
