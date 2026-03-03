<?php
session_start();
$username="chairman";
$password="society123";

if($_SERVER["REQUEST_METHOD"]=="POST"){
    if($_POST["username"]==$username && $_POST["password"]==$password){
        $_SESSION["loggedin"]=true;
        header("Location:index.php");
        exit();
    }
    $error="Invalid Credentials";
}
?>
<!DOCTYPE html>
<html>
<head>
<style>
body{display:flex;justify-content:center;align-items:center;height:100vh;background:linear-gradient(135deg,#141e30,#243b55);color:white;}
.box{background:rgba(255,255,255,0.1);padding:30px;border-radius:12px;}
input{display:block;width:100%;margin:10px 0;padding:8px;}
button{padding:8px 12px;}
</style>
</head>
<body>
<div class="box">
<h2>Society Login</h2>
<form method="POST">
<input type="text" name="username" placeholder="Username">
<input type="password" name="password" placeholder="Password">
<button type="submit">Login</button>
</form>
<?php if(isset($error)) echo $error; ?>
</div>
</body>
</html>
