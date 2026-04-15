<?php
session_start();
// Include the database connection so we can run queries
include '../../include/db_conn.php';

// Protect the route!
if(!isset($_SESSION["user_data"])) {
    header("location: ../../index.php");
    exit();
}

// --- 1. Calculate Total Members ---
$query_members = "SELECT COUNT(*) AS total_members FROM users";
$result_members = mysqli_query($con, $query_members);
$total_members = mysqli_fetch_assoc($result_members)['total_members'] ?? 0;

// --- 2. Calculate Available Plans ---
$query_plans = "SELECT COUNT(*) AS total_plans FROM plan";
$result_plans = mysqli_query($con, $query_plans);
$total_plans = mysqli_fetch_assoc($result_plans)['total_plans'] ?? 0;

// --- 3. Calculate Total Income ---
// This joins the enrollments with the plans to calculate the total money collected
$query_income = "SELECT SUM(p.amount) AS total_income FROM enrolls_to e INNER JOIN plan p ON e.pid = p.pid";
$result_income = mysqli_query($con, $query_income);
$total_income = mysqli_fetch_assoc($result_income)['total_income'] ?? 0;
?>
<!DOCTYPE html>
<html>
<head>
    <title>Gym | Dashboard</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f7f6; margin: 0; }
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
                <p><?php echo $total_members; ?></p>
            </div>
            <div class="card">
                <h3>Available Plans</h3>
                <p><?php echo $total_plans; ?></p>
            </div>
            <div class="card">
                <h3>Total Income</h3>
                <p>₹ <?php echo number_format($total_income, 2); ?></p>
            </div>
        </div>
    </div>

</body>
</html>