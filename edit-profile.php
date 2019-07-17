<?php
$title = "Edit Profile";
require_once('./include/header.php');
$detail_sql = "SELECT * FROM users WHERE email= '".$_SESSION['email']."'";
//$detail_sql = "SELECT * FROM users WHERE email= 'cuiyang21@gmail.com'";


$detail = $db->query($detail_sql);
foreach($detail as $row) {
}
require_once('./include/parseProfile.php');
?>
<main class="container">
<section class="col col-lg-7">
    <h2>Edit Profile</h2>
    <div>
        <?php if(isset($result)) echo $result; ?>
        <?php if(!empty($forms_errors)) echo $show_errors($forms_errors); ?>
    </div>
    <div class="clearfix"></div>
    <?php if(!isset($_SESSION['email'])): ?>
    <p class="lead">You are not authorized to view this page <a href="login.php">Login</a>
     Not yet a member? <a href="signup.php">Sign up</a></p>
    <?php else: ?>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="emailField">Email</label>
                <input type="text" name="email" class="form-control" id="emailField" value="<?php if(isset($email)) echo $email; ?>">
            </div>
            <div class="form-group">
                <label for="fist_nameField">First name</label>
                <input type="text" name="first_name" value="<?php if(isset($first_name)) echo $first_name; ?>" class="form-control" id="fist_nameField">
            </div>
            <div class="form-group">
                <label for="last_nameField">Last name</label>
                <input type="text" name="last_name" value="<?php if(isset($last_name)) echo $last_name; ?>" class="form-control" id="last_nameField">
            </div>
            <div class="form-group">
                <label for="fileField">Avatar</label>
                <input type="file" name="avatar" id="fileField">
            </div>
            <input type="hidden" name="hidden_id" value="<?php if(isset($id)) echo $id; ?>">
            <button type="submit" name="updateProfileBtn" class="btn btn-primary float-right">Update Profile</button>
        </form>
    <?php endif ?>
  
</section>
</main>
<?php
require_once('./include/footer.php');
?>