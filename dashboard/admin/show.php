<?php
session_start();
include '../../include/db_conn.php';

// Protect the route
if(!isset($_SESSION["user_data"])) {
    header("location: ../../index.php");
    exit();
}

// Data Analytics: Count members per city
$city_query = "SELECT city, COUNT(*) as member_count FROM address WHERE city != '' GROUP BY city";
$city_result = mysqli_query($con, $city_query);

$cities = [];
$counts = [];

if ($city_result) {
    while ($row = mysqli_fetch_assoc($city_result)) {
        $cities[] = $row['city'];
        $counts[] = $row['member_count'];
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Gym | Spatial Demographics</title>
    <link rel="stylesheet" href="../../css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

    <?php include '../../include/sidebar.php'; ?>

    <div class="main-content">
        <div class="header">
            <h2>Spatial Demographics</h2>
            <div>
                <a href="logout.php" class="logout-btn">Log Out</a>
            </div>
        </div>

        <div style="margin-top: 20px; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.05);">
            <h3 style="color: #333; text-align: center; margin-bottom: 20px;">Member Distribution by City</h3>
            
            <div style="max-width: 700px; margin: 0 auto;">
                <canvas id="cityChart"></canvas>
            </div>
        </div>
    </div>

    <script>
        const cityLabels = <?php echo json_encode($cities); ?>;
        const cityData = <?php echo json_encode($counts); ?>;

        const ctx = document.getElementById('cityChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: cityLabels,
                datasets: [{
                    label: 'Total Members',
                    data: cityData,
                    backgroundColor: '#007bff',
                    borderRadius: 5
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: { beginAtZero: true, ticks: { stepSize: 1 } }
                }
            }
        });
    </script>
</body>
</html>