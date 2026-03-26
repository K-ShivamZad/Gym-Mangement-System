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
</head>
<body>

    <div class="sidebar">
        <h2>FITNESS CLUB</h2>
        <a href="index.php">Dashboard</a>
        <a href="new_entry.php">New Registration</a>
        <a href="members.php">View Members</a>
        <a href="payments.php" class="active">Payments</a>
    </div>

    <div class="main-content">
        <div class="header">
            <h2>Payment History</h2>
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
                        <th>Phone Number</th>
                        <th>Plan Name</th>
                        <th>Amount Paid</th>
                        <th>Payment Date</th>
                        <th>Expiry Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        // Fetch payment details by joining users, enrolls_to, and plan tables
                        $query = "SELECT u.username, u.mobile, p.planName, p.amount, e.paid_date, e.expire 
                                  FROM enrolls_to e 
                                  INNER JOIN users u ON e.uid = u.userid 
                                  INNER JOIN plan p ON e.pid = p.pid 
                                  ORDER BY e.paid_date DESC";
                        
                        $result = mysqli_query($con, $query);
                        $sno = 1;

                        if(mysqli_num_rows($result) > 0){
                            while($row = mysqli_fetch_assoc($result)){
                                echo "<tr>";
                                echo "<td>" . $sno . "</td>";
                                echo "<td>" . $row['username'] . "</td>";
                                echo "<td>" . $row['mobile'] . "</td>";
                                echo "<td>" . $row['planName'] . "</td>";
                                echo "<td style='color: green; font-weight: bold;'>₹" . $row['amount'] . "</td>";
                                echo "<td>" . $row['paid_date'] . "</td>";
                                echo "<td>" . $row['expire'] . "</td>";
                                echo "</tr>";
                                $sno++;
                            }
                        } else {
                            echo "<tr><td colspan='7' style='text-align:center;'>No payment records found.</td></tr>";
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>