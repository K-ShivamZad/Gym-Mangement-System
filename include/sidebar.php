<?php
// Get the name of the current file (e.g., 'show.php', 'index.php')
$current_page = basename($_SERVER['PHP_SELF']);
?>

<div class="sidebar">
    <h2>FITNESS CLUB</h2>
    
    <a href="index.php" class="<?php if($current_page == 'index.php'){ echo 'active'; } ?>">Dashboard</a>
    
    <a href="new_entry.php" class="<?php if($current_page == 'new_entry.php'){ echo 'active'; } ?>">New Registration</a>
    
    <a href="members.php" class="<?php if($current_page == 'members.php'){ echo 'active'; } ?>">View Members</a>
    
    <a href="payments.php" class="<?php if($current_page == 'payments.php'){ echo 'active'; } ?>">Payments</a>
    
    <a href="show.php" class="<?php if($current_page == 'show.php'){ echo 'active'; } ?>">Show</a>
</div>