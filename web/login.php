<?php
session_start();

// Secure credentials
$username = "chairman";
$hashed_password = password_hash("society123", PASSWORD_DEFAULT);

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if ($_POST["username"] === $username && 
        password_verify($_POST["password"], $hashed_password)) {

        $_SESSION["loggedin"] = true;
        header("Location: index.php");
        exit();
    } else {
        $message = "Invalid Username or Password";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Society Login</title>

<style>
body {
    margin: 0;
    font-family: Arial, sans-serif;
    background: linear-gradient(135deg, #4e73df, #1cc88a);
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

.login-box {
    background: white;
    padding: 40px;
    border-radius: 12px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.2);
    width: 320px;
    text-align: center;
}

.login-box h2 {
    margin-bottom: 20px;
    color: #333;
}

input {
    width: 100%;
    padding: 10px;
    margin: 10px 0;
    border-radius: 6px;
    border: 1px solid #ccc;
}

button {
    width: 100%;
    padding: 10px;
    background: #4e73df;
    border: none;
    color: white;
    border-radius: 6px;
    cursor: pointer;
    font-size: 16px;
}

button:hover {
    background: #2e59d9;
}

.error {
    color: red;
    margin-top: 10px;
}

.footer {
    margin-top: 20px;
    font-size: 12px;
    color: #777;
}
</style>
</head>

<body>

<div class="login-box">
    <h2>🏢 Society Management</h2>

    <form method="POST">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>

    <?php if ($message != "") { ?>
        <div class="error"><?php echo $message; ?></div>
    <?php } ?>

    <div class="footer">
        © <?php echo date("Y"); ?> Society System
    </div>
</div>

</body>
</html>
