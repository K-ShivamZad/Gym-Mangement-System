<?php
session_start();

// Protect the route! If the user is not logged in, redirect them back to the login page.
if(!isset($_SESSION["user_data"])) {
    header("location: ../../index.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Gym | Dashboard</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f7f6; margin: 0; }
        .sidebar { width: 220px; background: #2b303a; color: white; height: 100vh; position: fixed; padding-top: 20px; }
        .sidebar h2 { text-align: center; margin-bottom: 30px; letter-spacing: 1px; }
        .sidebar a { display: block; color: #cfd8dc; padding: 15px 20px; text-decoration: none; border-left: 4px solid transparent; }
        .sidebar a:hover, .sidebar a.active { background: #1e2229; border-left: 4px solid #007bff; color: white; }
        .main-content { margin-left: 220px; padding: 20px; }
        .header { display: flex; justify-content: space-between; align-items: center; background: white; padding: 15px 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); }
        .cards { display: flex; gap: 20px; margin-top: 20px; }
        .card { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); flex: 1; text-align: center; }
        .card h3 { margin: 0; color: #777; font-size: 16px; text-transform: uppercase; }
        .card p { font-size: 28px; font-weight: bold; margin: 10px 0 0; color: #2b303a; }
        .logout-btn { color: #dc3545; text-decoration: none; font-weight: bold; margin-left: 15px; }
    </style>
</head>
<body>

    <?php include '../../include/sidebar.php'; ?>

    <div class="main-content">
        <div class="header">
            <h2>Admin Dashboard</h2>
            <div>
                Welcome, <strong><?php echo $_SESSION['full_name']; ?></strong> 
                <a href="logout.php" class="logout-btn">Log Out</a>
            </div>
        </div>

        <div class="cards">
            <div class="card">
                <h3>Total Members</h3>
                <p>0</p>
            </div>
            <div class="card">
                <h3>Available Plans</h3>
                <p>0</p>
            </div>
            <div class="card">
                <h3>Total Income</h3>
                <p>₹ 0</p>
            </div>
        </div>
    </div>

</body>
</html>