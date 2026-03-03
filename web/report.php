<?php
session_start();
if (!isset($_SESSION["loggedin"])) {
    header("Location: login.php");
    exit();
}
?>



<?php
$month = date("F-Y");

$members_file = "data/members.csv";
$payment_file = "data/payments/payments_" . $month . ".csv";
$expense_file = "data/expenses.csv";

/* ---- MEMBERS & EXPECTED ---- */
$total_members = count(file($members_file)) - 1;
$expected = $total_members * 1000;

/* ---- PAYMENTS ---- */
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

/* ---- EXPENSES ---- */
$expenses = file($expense_file);
$total_expense = 0;
$expense_list = [];

foreach ($expenses as $line) {
    $data = explode(",", trim($line));
    if (isset($data[2])) {
        $total_expense += $data[2];
        $expense_list[] = $data;
    }
}

$balance = $collected - $total_expense;
?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
body { font-family: Arial; background:#f2f2f2; padding:10px;}
.box { background:white; margin:10px 0; padding:15px; border-radius:8px;}
h2 { text-align:center; }
table { width:100%; border-collapse: collapse; background:white; }
th, td { padding:8px; border:1px solid #ccc; text-align:center; }
.unpaid { color:red; font-weight:bold; }
</style>
</head>
<body>

<h2>Monthly Report - <?php echo $month; ?></h2>

<div class="box">Expected Collection: ₹<?php echo $expected; ?></div>
<div class="box">Collected: ₹<?php echo $collected; ?></div>
<div class="box">Total Expenses: ₹<?php echo $total_expense; ?></div>
<div class="box"><b>Balance: ₹<?php echo $balance; ?></b></div>

<h3>Unpaid Flats</h3>
<div class="box unpaid">
<?php
if (count($unpaid) > 0) {
    echo implode(", ", $unpaid);
} else {
    echo "All Flats Paid ✅";
}
?>
</div>

<h3>Expense Details</h3>
<table>
<tr>
    <th>Date</th>
    <th>Description</th>
    <th>Amount</th>
</tr>
<?php
foreach ($expense_list as $exp) {
    echo "<tr>
            <td>{$exp[0]}</td>
            <td>{$exp[1]}</td>
            <td>₹{$exp[2]}</td>
          </tr>";
}
?>
</table>

<br><a href="index.php">Back</a>

</body>
</html>
