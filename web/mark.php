<?php
session_start();
if (!isset($_SESSION["loggedin"])) {
    header("Location: login.php");
    exit();
}

$month = date("F-Y");
$payment_dir = "data/payments";
$payment_file = $payment_dir . "/payments_" . $month . ".csv";
$members_file = "data/members.csv";

/* ---- Ensure payments folder exists ---- */
if (!is_dir($payment_dir)) {
    mkdir($payment_dir, 0777, true);
}

/* ---- Auto Create Monthly File If Not Exists ---- */
if (!file_exists($payment_file)) {

    $members = file_exists($members_file) ? file($members_file) : [];
    $content = "FlatNo,Month,Paid\n";

    foreach ($members as $index => $member) {
        if ($index == 0) continue;
        $data = explode(",", trim($member));
        if (!empty($data[0])) {
            $content .= $data[0] . "," . $month . ",No\n";
        }
    }

    file_put_contents($payment_file, $content);
}

/* ---- TOGGLE PAYMENT STATUS ---- */
if (isset($_GET["flat"])) {

    $flat = $_GET["flat"];
    $rows = file($payment_file);

    foreach ($rows as $index => $row) {

        if ($index == 0) continue;

        $data = str_getcsv(trim($row));

        if ($data[0] == $flat) {

            // Toggle Yes/No
            $data[2] = ($data[2] == "Yes") ? "No" : "Yes";

            $rows[$index] = implode(",", $data) . "\n";
            break;
        }
    }

    file_put_contents($payment_file, implode("", $rows));

    header("Location: mark.php");
    exit();
}

$rows = file($payment_file);
?>

<!DOCTYPE html>
<html>
<head>
<title>Mark Payments</title>
</head>
<body>

<h2 style="text-align:center;">Mark Monthly Payment - <?php echo $month; ?></h2>

<table border="1" cellpadding="8" style="margin:auto;">
<tr>
    <th>Flat No</th>
    <th>Status</th>
    <th>Action</th>
</tr>

<?php
foreach ($rows as $index => $row) {

    if ($index == 0) continue;

    $data = str_getcsv(trim($row));

    echo "<tr>";
    echo "<td>{$data[0]}</td>";
    echo "<td>{$data[2]}</td>";

    if ($data[2] == "Yes") {
        echo "<td>
                <a href='mark.php?flat={$data[0]}'>
                Undo
                </a>
              </td>";
    } else {
        echo "<td>
                <a href='mark.php?flat={$data[0]}'>
                Mark Paid
                </a>
              </td>";
    }

    echo "</tr>";
}
?>

</table>

<br>
<p style="text-align:center;"><a href="index.php">Back to Dashboard</a></p>

</body>
</html>
