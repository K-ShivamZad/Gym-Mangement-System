<?php
session_start();
include '../../include/db_conn.php';

// Protect the route
if(!isset($_SESSION["user_data"])) {
    header("location: ../../index.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Gym | View Members</title>
    <link rel="stylesheet" href="../../css/style.css">
</head>
<body>

    <?php include '../../include/sidebar.php'; ?>

    <div class="main-content">
        <div class="header">
            <h2>Registered Members</h2>
            <div>
                <a href="logout.php" class="logout-btn">Log Out</a>
            </div>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Sl.No</th>
                        <th>Member ID</th>
                        <th>Name</th>
                        <th>Gender</th>
                        <th>Contact</th>
                        <th>E-Mail</th>
                        <th>Joining Date</th>
                        <th>Expiry Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        // Fetch members and their plan expiration dates using a JOIN
                        $query = "SELECT u.userid, u.username, u.gender, u.mobile, u.email, u.joining_date, e.expire 
                                  FROM users u 
                                  LEFT JOIN enrolls_to e ON u.userid = e.uid 
                                  ORDER BY u.joining_date DESC";
                        
                        $result = mysqli_query($con, $query);
                        $sno = 1;

                        if(mysqli_num_rows($result) > 0){
                            while($row = mysqli_fetch_assoc($result)){
                                echo "<tr>";
                                echo "<td>" . $sno . "</td>";
                                echo "<td>" . $row['userid'] . "</td>";
                                echo "<td>" . $row['username'] . "</td>";
                                echo "<td>" . $row['gender'] . "</td>";
                                echo "<td>" . $row['mobile'] . "</td>";
                                echo "<td>" . $row['email'] . "</td>";
                                echo "<td>" . $row['joining_date'] . "</td>";
                                
                                // Check if expired
                                $expire_date = $row['expire'];
                                $today = date('Y-m-d');
                                if($expire_date < $today) {
                                    echo "<td style='color: red; font-weight: bold;'>" . $expire_date . " (Expired)</td>";
                                } else {
                                    echo "<td style='color: green;'>" . $expire_date . "</td>";
                                }
                                
                                echo "</tr>";
                                $sno++;
                            }
                        } else {
                            echo "<tr><td colspan='8' style='text-align:center;'>No members found. Add some!</td></tr>";
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>