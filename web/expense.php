<?php
require_once("config/auth.php");

$file="data/expenses.csv";
if(!file_exists($file)) file_put_contents($file,"Date,Description,Amount\n");

if($_SERVER["REQUEST_METHOD"]=="POST"){
    $desc=trim($_POST["desc"]);
    $amount=trim($_POST["amount"]);
    if($desc!="" && is_numeric($amount)){
        file_put_contents($file,date("d-m-Y").",$desc,$amount\n",FILE_APPEND);
    }
}

if(isset($_GET["delete"])){
    $id=(int)$_GET["delete"];
    $rows=file($file);
    unset($rows[$id]);
    file_put_contents($file,implode("",$rows));
    header("Location: expense.php");
    exit();
}

$rows=file($file);
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="assets/style.css">
</head>
<body>

<?php include("components/sidebar.php"); ?>

<div class="main">
<h2>Expenses</h2>

<div class="card">
<form method="POST">
<input type="text" name="desc" placeholder="Description" required>
<input type="number" name="amount" placeholder="Amount" required>
<button type="submit">Add</button>
</form>
</div>

<div class="card">
<table>
<tr><th>Date</th><th>Description</th><th>Amount</th><th>Action</th></tr>
<?php
$total=0;
foreach($rows as $i=>$r){
    if($i==0) continue;
    $d=str_getcsv(trim($r));
    $total+=(int)$d[2];
    echo "<tr>
    <td>$d[0]</td>
    <td>$d[1]</td>
    <td>₹$d[2]</td>
    <td><a class='btn' href='expense.php?delete=$i'>Delete</a></td>
    </tr>";
}
?>
</table>
<h3>Total: ₹<?php echo $total; ?></h3>
</div>
</div>
</body>
</html>
