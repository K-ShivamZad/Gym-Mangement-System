<?php
session_start();
// If already logged in, redirect to dashboard
if(isset($_SESSION["user_data"])) {
    header("location: ./dashboard/admin/");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Gym | Login</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #2b303a; color: white; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .login-container { background: #1e2229; padding: 40px; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.5); text-align: center; width: 300px; }
        input[type="text"], input[type="password"] { width: 90%; padding: 10px; margin: 10px 0; border: none; border-radius: 4px; }
        button { width: 100%; padding: 10px; margin-top: 15px; background: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 16px; }
        button:hover { background: #0056b3; }
    </style>
</head>
<body>
    <div class="login-container">
        <h1>Fitness Club</h1>
        <p>Admin Login</p>
        <form action="secure_login.php" method="POST">
            <input type="text" name="user_id_auth" placeholder="User ID" required>
            <input type="password" name="pass_key" placeholder="Password" required>
            <button type="submit" name="btnLogin">Log In</button>
        </form>
    </div>
</body>
</html>