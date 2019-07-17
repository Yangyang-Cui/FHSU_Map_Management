<?php 
$title = "Current Permission";
require_once('./include/header.php'); 
?>
<main class="container">
    <p style="color:green;">You are administrator, you need change their permission 2 to permission 1. Then these account can modify our map.</p>

<?php if(!isset($_SESSION['email'])): ?>
<p class="lead">You are not authorized to view this page <a href="login.php">Login</a>
     Not yet a member? <a href="signup.php">Sign up</a></p>
<?php else: ?>
<?php
$detail_sql = "SELECT * FROM users WHERE permission= '2' ORDER BY id ASC;";

$detail = $db->query($detail_sql);
foreach($detail as $row) {
    echo "<h1>".$row['email']."<span class='modify-article'><a href='editPermission.php?id=".$row['id']."'>Modify this account</a></span></h1>";
    echo '<h6><b>First name: </b> '.$row['first_name'].'</h6>';
    echo '<h6><b>Last name: </b>'.$row['last_name'].'</h6>';
    echo '<h6><b>Permission: </b>'.$row['permission'].'</h6>';
    echo '<br>';

}

?>
<?php endif ?>

</main>
<?php require_once('./include/footer.php'); ?>