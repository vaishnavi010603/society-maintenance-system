<?php
require_once("config/auth.php");

$month=date("F-Y");
$members=file("data/members.csv");
$total_members=count($members)-1;
$expected=$total_members*1000;

$payment_file="data/payments/payments_$month.csv";
$payments=file_exists($payment_file)?file($payment_file):[];
$collected=0;
foreach($payments as $i=>$p){
    if($i==0) continue;
    $d=str_getcsv(trim($p));
    if($d[2]=="Yes") $collected+=1000;
}

$expenses=file("data/expenses.csv");
$total_exp=0;
foreach($expenses as $i=>$e){
    if($i==0) continue;
    $d=str_getcsv(trim($e));
    $total_exp+=(int)$d[2];
}

$balance=$collected-$total_exp;
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="assets/style.css">
</head>
<body>

<?php include("components/sidebar.php"); ?>

<div class="main">
<h2>Report - <?php echo $month; ?></h2>

<div class="card">
<h3>Total Members: <?php echo $total_members; ?></h3>
<h3>Collected: ₹<?php echo $collected; ?></h3>
<h3>Expenses: ₹<?php echo $total_exp; ?></h3>
<h3>Balance: ₹<?php echo $balance; ?></h3>
</div>

</div>
</body>
</html>
