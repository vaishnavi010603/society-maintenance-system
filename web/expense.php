<?php
session_start();
if (!isset($_SESSION["loggedin"])) {
    header("Location: login.php");
    exit();
}

$file = "data/expenses.csv";

// Create file if not exists
if (!file_exists($file)) {
    file_put_contents($file, "Date,Description,Amount\n");
}

// ADD EXPENSE
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $desc = trim($_POST["desc"]);
    $amount = trim($_POST["amount"]);
    $date = date("d-m-Y");

    if ($desc != "" && $amount != "" && is_numeric($amount)) {
        $line = $date . "," . $desc . "," . $amount . "\n";
        file_put_contents($file, $line, FILE_APPEND);
        $success = "Expense Added Successfully";
    }
}

// DELETE EXPENSE
if (isset($_GET["delete"])) {
    $id = (int)$_GET["delete"];
    $rows = file($file);

    if ($id > 0 && $id < count($rows)) {
        unset($rows[$id]);
        file_put_contents($file, implode("", $rows));
    }

    header("Location: expense.php");
    exit();
}

$rows = file_exists($file) ? file($file) : [];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Expense</title>
</head>
<body>

<h2 style="text-align:center;">Add Expense</h2>

<?php if (isset($success)) { ?>
    <p style="color:green;text-align:center;"><?php echo $success; ?></p>
<?php } ?>

<form method="POST" style="text-align:center;">
    Description:
    <input type="text" name="desc" required>
    <br><br>

    Amount:
    <input type="number" name="amount" min="1" required>
    <br><br>

    <button type="submit">Add Expense</button>
</form>

<hr>

<h3 style="text-align:center;">Expense List</h3>

<table border="1" cellpadding="8" style="margin:auto;">
<tr>
    <th>Date</th>
    <th>Description</th>
    <th>Amount</th>
    <th>Action</th>
</tr>

<?php
$total = 0;

foreach ($rows as $index => $row) {

    if ($index == 0) continue; // skip header

    $data = str_getcsv(trim($row));

    if (count($data) >= 3) {

        echo "<tr>";
        echo "<td>{$data[0]}</td>";
        echo "<td>{$data[1]}</td>";
        echo "<td>₹{$data[2]}</td>";
        echo "<td>
                <a href='expense.php?delete=$index'
                onclick=\"return confirm('Delete this expense?')\">
                Delete
                </a>
              </td>";
        echo "</tr>";

        $total += (int)$data[2];
    }
}
?>

</table>

<h3 style="text-align:center;">Total Expense: ₹<?php echo $total; ?></h3>

<br>
<p style="text-align:center;"><a href="index.php">Back to Dashboard</a></p>

</body>
</html>
