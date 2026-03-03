<?php
session_start();
if (!isset($_SESSION["loggedin"])) {
    header("Location: login.php");
    exit();
}
?>



<?php
$file = "data/expenses.csv";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $desc = $_POST["desc"];
    $amount = $_POST["amount"];
    $date = date("d-m-Y");

    $line = $date . "," . $desc . "," . $amount . "\n";
    file_put_contents($file, $line, FILE_APPEND);

    echo "<p style='color:green;text-align:center;'>Expense Added Successfully</p>";
}
?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
body { font-family: Arial; text-align:center; background:#f2f2f2;}
input, button { padding:12px; width:80%; margin:10px; font-size:16px;}
button { background:red; color:white; border:none; border-radius:5px;}
</style>
</head>
<body>

<h2>Add Expense</h2>

<form method="post">
<input type="text" name="desc" placeholder="Description" required><br>
<input type="number" name="amount" placeholder="Amount" required><br>
<button type="submit">Add Expense</button>
</form>

<br><a href="index.php">Back</a>

</body>
</html>
