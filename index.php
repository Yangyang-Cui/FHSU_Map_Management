<?php
$title = 'FHSU Map System';
require_once('./include/header.php');
?>
<main role="main" class="container">
    <h3 style="color:green">FHSU Map Management</h3>
    <p style="color:green">In database, the higher(administration) permission is 0, you can give other people permission to modify map;the lower(normal) permission is 1,you can modify map; and no permission is 2, you need email administrator to have permission.</p>
    <p></p>
    <?php if(!isset($_SESSION['email'])): ?>
    <p>If you don't have a account, you need to <a href="./signup.php" target="_blank">sign up</a>.</p>
    <p>If you have a account, please<a href="./login.php" target="_blank"> log in</a> to manage the Map.</p>
    <?php else: ?>
    <p><strong>Current account: </strong><a><?php if(isset($_SESSION['email'])) echo $_SESSION['email']; ?></a></p>
    
    <a class="dropdown-item" href="profile.php">My Profile</a>
    <a class="dropdown-item" href="logout.php">Logout</a>
    <?php endif ?>
</main>
<?php
require_once('./include/footer.php');
?>