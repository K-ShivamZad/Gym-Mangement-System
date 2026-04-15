<?php
session_start();
require '../../include/db_conn.php';

// Protect the route
if(!isset($_SESSION["user_data"])) {
    header("location: ../../index.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Gym | Payments</title>
    <link rel="stylesheet" href="../../css/style.css">
    <style>
        .main-content { margin-left: 220px; padding: 20px; }
        .header { display: flex; justify-content: space-between; align-items: center; background: white; padding: 15px 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); }
    </style>
</head>
<body>

    <?php include '../../include/sidebar.php'; ?>

    <div class="main-content">
        <div class="header">
            <h2>Payment History & Demographics</h2>
            <div>
                <a href="logout.php" class="logout-btn">Log Out</a>
            </div>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Sl.No</th>
                        <th>Member Name</th>
                        <th>Age</th>
                        <th>Phone Number</th>
                        <th>Plan Name</th>
                        <th>Amount Paid</th>
                        <th>Payment Date</th>
                        <th>Expiry Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $query = "SELECT u.username, u.mobile, u.dob, p.planName, p.amount, e.paid_date, e.expire 
                                  FROM users u
                                  LEFT JOIN enrolls_to e ON u.userid = e.uid 
                                  LEFT JOIN plan p ON e.pid = p.pid 
                                  ORDER BY e.paid_date DESC";
                        
                        $result = mysqli_query($con, $query);
                        $sno = 1;

                        if ($result) {
                            if (mysqli_num_rows($result) > 0) { 
                                while ($row = mysqli_fetch_assoc($result)) {
                                    // Calculate Age dynamically
                                    $dob = new DateTime($row['dob']);
                                    $today = new DateTime('today');
                                    $age = $dob->diff($today)->y;

                                    echo "<tr>";
                                    echo "<td>" . $sno . "</td>";
                                    echo "<td>" . $row['username'] . "</td>";
                                    echo "<td><strong>" . $age . "</strong> yrs</td>";
                                    echo "<td>" . $row['mobile'] . "</td>";
                                    echo "<td>" . ($row['planName'] ?? 'No Plan') . "</td>";
                                    echo "<td style='color: green; font-weight: bold;'>₹" . ($row['amount'] ?? '0') . "</td>";
                                    echo "<td>" . ($row['paid_date'] ?? 'N/A') . "</td>";
                                    echo "<td>" . ($row['expire'] ?? 'N/A') . "</td>";
                                    echo "</tr>";
                                    $sno++;
                                }
                            } else {
                                echo "<tr><td colspan='8' style='text-align:center;'>No payment records found.</td></tr>";
                            }
                        } else {
                            echo "<tr><td colspan='8' style='text-align:center; color:red;'>SQL Error: " . mysqli_error($con) . "</td></tr>";
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>