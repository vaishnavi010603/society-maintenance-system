<?php
session_start();

$username = "chairman";
$password = "society123";   // change later if needed

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if ($_POST["username"] == $username && $_POST["password"] == $password) {
        $_SESSION["loggedin"] = true;
        header("Location: index.php");
        exit();
    } else {
        $message = "Invalid Credentials";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
body { font-family: Arial; background:#f2f2f2; text-align:center; padding-top:80px;}
input { padding:12px; width:70%; margin:10px; font-size:16px;}
button { padding:12px; width:70%; background:blue; color:white; border:none;}
.box { background:white; padding:20px; margin:auto; width:90%; max-width:350px; border-radius:8px;}
.error { color:red; }
</style>
</head>
<body>

<div class="box">
<h2>Chairman Login</h2>

<?php if($message) echo "<p class='error'>$message</p>"; ?>

<form method="post">
<input type="text" name="username" placeholder="Username" required><br>
<input type="password" name="password" placeholder="Password" required><br>
<button type="submit">Login</button>
</form>

</div>

</body>
</html>
