<?php
session_start();
if (!isset($_SESSION["loggedin"])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Society Management</title>

<style>
body {
    font-family: Arial, sans-serif;
    background: #f4f6f9;
    margin: 0;
    padding: 0;
}

.container {
    max-width: 500px;
    margin: 40px auto;
    padding: 20px;
}

h2 {
    text-align: center;
    margin-bottom: 30px;
}

.card {
    background: white;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.08);
}

a.button {
    display: block;
    text-decoration: none;
    text-align: center;
    padding: 14px;
    margin: 12px 0;
    border-radius: 8px;
    font-size: 16px;
    font-weight: bold;
    transition: 0.2s;
}

a.button:hover {
    transform: translateY(-2px);
}

.primary { background: #1976d2; color: white; }
.success { background: #2e7d32; color: white; }
.warning { background: #ed6c02; color: white; }
.info    { background: #0288d1; color: white; }
.dark    { background: #424242; color: white; }
.danger  { background: #d32f2f; color: white; }

.footer {
    text-align: center;
    margin-top: 20px;
    font-size: 14px;
    color: #777;
}
</style>
</head>

<body>

<div class="container">
    <h2>🏢 Society Management System</h2>

    <div class="card">
        <a href="mark.php" class="button primary">💰 Mark Payment</a>
        <a href="expense.php" class="button success">🧾 Add Expense</a>
        <a href="report.php" class="button warning">📊 View Report</a>
        <a href="pdf_report.php" class="button info">📄 Download PDF Report</a>
        <a href="backup.php" class="button dark">💾 Download Backup</a>
        <a href="logout.php" class="button danger">🚪 Logout</a>
    </div>

    <div class="footer">
        Internal Society Management System
    </div>
</div>

</body>
</html>
