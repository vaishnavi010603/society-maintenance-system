<?php
session_start();
if (!isset($_SESSION["loggedin"])) {
    header("Location: login.php");
    exit();
}
?>

<?php
$month = date("F-Y");
$payment_file = "data/payments/payments_" . $month . ".csv";
$members_file = "data/members.csv";

/* ---- Auto Create Monthly File If Not Exists ---- */
if (!file_exists($payment_file)) {

    $members = file($members_file);
    $content = "FlatNo,Month,Paid\n";

    foreach ($members as $index => $member) {
        if ($index == 0) continue;
        $data = explode(",", trim($member));
        $content .= $data[0] . "," . $month . ",No\n";
    }

    file_put_contents($payment_file, $content);
}

/* ---- Mark Payment ---- */
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["flat"])) {

    $flat = $_POST["flat"];
    $lines = file($payment_file);

    foreach ($lines as &$line) {
        if (strpos($line, $flat . "," . $month . ",No") === 0) {
            $line = $flat . "," . $month . ",Yes\n";
        }
    }

    file_put_contents($payment_file, implode("", $lines));
    $message = "Payment Marked for Flat $flat";
}

/* ---- Load Data ---- */
$members = file($members_file);
$payments = file($payment_file);

$status = [];

foreach ($payments as $index => $line) {
    if ($index == 0) continue;
    $data = explode(",", trim($line));
    $status[$data[0]] = $data[2];
}
?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
body { font-family: Arial; background:#f2f2f2; padding:10px;}
table { width:100%; border-collapse: collapse; background:white;}
th, td { padding:10px; border:1px solid #ccc; text-align:center;}
button { padding:6px 10px; background:green; color:white; border:none; border-radius:5px;}
.paid { color:green; font-weight:bold;}
.unpaid { color:red; font-weight:bold;}
</style>
</head>
<body>

<h2>Mark Payments - <?php echo $month; ?></h2>

<?php if($message) echo "<p style='color:green;'>$message</p>"; ?>

<table>
<tr>
    <th>Flat</th>
    <th>Name</th>
    <th>Status</th>
    <th>Action</th>
</tr>

<?php
foreach ($members as $index => $member) {
    if ($index == 0) continue;

    $data = explode(",", trim($member));
    $flat = $data[0];
    $name = $data[1];
    $current_status = $status[$flat] ?? "No";

    echo "<tr>";
    echo "<td>$flat</td>";
    echo "<td>$name</td>";

    if ($current_status == "Yes") {
        echo "<td class='paid'>Paid</td>";
        echo "<td>✔</td>";
    } else {
        echo "<td class='unpaid'>Unpaid</td>";
        echo "<td>
                <form method='post'>
                    <input type='hidden' name='flat' value='$flat'>
                    <button type='submit'>Mark Paid</button>
                </form>
              </td>";
    }

    echo "</tr>";
}
?>

</table>

<br><a href="index.php">Back</a>

</body>
</html>
