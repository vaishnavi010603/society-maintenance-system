<?php
require_once("config/auth.php");

$month = date("F-Y");
$payment_dir = "data/payments";
$payment_file = $payment_dir . "/payments_" . $month . ".csv";
$members_file = "data/members.csv";

if (!is_dir($payment_dir)) mkdir($payment_dir,0777,true);

if (!file_exists($payment_file)) {
    $members = file_exists($members_file)?file($members_file):[];
    $content="FlatNo,Month,Paid\n";
    foreach($members as $i=>$m){
        if($i==0) continue;
        $d=explode(",",trim($m));
        $content.=$d[0].",$month,No\n";
    }
    file_put_contents($payment_file,$content);
}

if(isset($_GET["flat"])){
    $flat=$_GET["flat"];
    $rows=file($payment_file);
    foreach($rows as $i=>$row){
        if($i==0) continue;
        $d=str_getcsv(trim($row));
        if($d[0]==$flat){
            $d[2]=($d[2]=="Yes")?"No":"Yes";
            $rows[$i]=implode(",",$d)."\n";
        }
    }
    file_put_contents($payment_file,implode("",$rows));
    header("Location: mark.php");
    exit();
}

$rows=file($payment_file);
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="assets/style.css">
</head>
<body>

<?php include("components/sidebar.php"); ?>

<div class="main">
<h2>Payments - <?php echo $month; ?></h2>

<div class="card">
<table>
<tr><th>Flat</th><th>Status</th><th>Action</th></tr>
<?php
foreach($rows as $i=>$row){
    if($i==0) continue;
    $d=str_getcsv(trim($row));
    echo "<tr>
    <td>$d[0]</td>
    <td>$d[2]</td>
    <td><a class='btn' href='mark.php?flat=$d[0]'>Toggle</a></td>
    </tr>";
}
?>
</table>
</div>
</div>
</body>
</html>
