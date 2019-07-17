<?php
$title = "Profile";
require_once('./include/header.php');
require_once('./include/parseProfile.php');
$detail_sql = "SELECT * FROM users WHERE email= '".$_SESSION['email']."'";
//$detail_sql = "SELECT * FROM users WHERE email= 'cuiyang21@gmail.com'";


$detail = $db->query($detail_sql);
foreach($detail as $row) {
}
?>
<main class="container">

        <h1>Profile</h1>
        <?php if(!isset($_SESSION['email'])): ?>
        <p class="lead">You are not authorized to view this page <a href="login.php">Login</a>
        Not yet a member? <a href="signup.php">Sign up</a></p>
        <?php else: ?>
            <section class="col col-lg-7">
                <div class="row col-lg-3 self-img">
                    <img src="<?php if(isset($profile_picture)) echo $profile_picture; ?>" alt="user picture">
                </div>
                <table class="table table-bordered">
                    <tr>
                        <th style="width: 20%;">Fist name:</th>
                        <td><?php echo $row['first_name']; ?></td>
                    </tr>
                    <tr>
                        <th style="width: 20%;">Last name:</th>
                        <td><?php echo $row['last_name']; ?></td>
                    </tr>
                    <tr>
                        <th>Email:</th>
                        <td><?php if(isset($email)) echo $email; ?></td>
                    </tr>
                    <tr>
                        <th>Date Joined:</th>
                        <td><?php if(isset($date_joined)) echo $date_joined; ?></td>
                    </tr>
                    <tr>
                        <th></th>
                        <td class="float-right"><a href="edit-profile.php?user_identity=<?php if(isset($encode_id)) echo $encode_id; ?>">
                        <span class=""></span>Edit Profile</a></td>
                    </tr>
                </table>
            </section>
        <?php endif ?>

</main>
<?php
require_once('./include/footer.php');
?>