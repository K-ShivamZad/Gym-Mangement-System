<?php
session_start();
include '../../include/db_conn.php';

// Protect the route - redirect if not logged in
if(!isset($_SESSION["user_data"])) {
    header("location: ../../index.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Gym | Show</title>
    <link rel="stylesheet" href="../../css/style.css">
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f7f6; margin: 0; }
        .main-content { margin-left: 220px; padding: 20px; }
        .header { display: flex; justify-content: space-between; align-items: center; background: white; padding: 15px 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); }
    </style>
</head>
<body>

    <?php include '../../include/sidebar.php'; ?>

    <div class="main-content">
        <div class="header">
            <h2>Show Page</h2>
            <div>
                <a href="logout.php" class="logout-btn">Log Out</a>
            </div>
        </div>

        <div style="margin-top: 20px; background: white; padding: 20px; border-radius: 8px;">
            <h3>Welcome to the Show page!</h3>
            <p>You can add whatever new features or data tables you want right here.</p>
        </div>
    </div>

</body>
</html>