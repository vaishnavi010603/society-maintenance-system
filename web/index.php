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
    background: linear-gradient(135deg, #f4f6f9, #e3f2fd);
    margin: 0;
    padding: 0;
}

/* Top Header */
.header {
    background: #1976d2;
    color: white;
    padding: 15px;
    text-align: center;
    font-size: 18px;
    font-weight: bold;
}

/* Main Container */
.container {
    max-width: 500px;
    margin: 40px auto;
    padding: 20px;
}

h2 {
    text-align: center;
    margin-bottom: 30px;
    color: #333;
}

.card {
    background: white;
    padding: 25px;
    border-radius: 14px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.1);
}

/* Buttons */
a.button {
    display: block;
    text-decoration: none;
    text-align: center;
    padding: 14px;
    margin: 12px 0;
    border-radius: 8px;
    font-size: 16px;
    font-weight: bold;
    transition: all 0.2s ease;
}

a.button:hover {
    transform: translateY(-3px);
    opacity: 0.9;
}

.primary { background: #1976d2; color: white; }
.success { background: #2e7d32; color: white; }
.warning { background: #ed6c02; color: white; }
.info    { background: #0288d1; color: white; }
.dark    { background: #424242; color: white; }
.danger  { background: #d32f2f; color: white; }

/* Footer */
.footer {
    text-align: center;
    margin-top: 30px;
    font-size: 14px;
    color: #666;
}
</style>
</head>

<body>

<div class="header">
    🏢 Society Management Dashboard
</div>

<div class="container">

    <h2>Welcome, Chairman</h2>

    <div class="card">
        <a href="mark.php" class="button primary">💰 Mark Payment</a>
        <a href="expense.php" class="button success">🧾 Add Expense</a>
        <a href="report.php" class="button warning">📊 View Report</a>
        <a href="pdf_report.php" class="button info">📄 Download PDF Report</a>
        <a href="backup.php" class="button dark">💾 Download Backup</a>
        <a href="logout.php" class="button danger">🚪 Logout</a>
    </div>

    <div class="footer">
        © <?php echo date("Y"); ?> Internal Society Management System
    </div>

</div>

</body>
</html>
