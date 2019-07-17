<?php
$title = 'Login Page';

require_once('./include/header.php');

if(isset($_POST['loginBtn'])) {
    // array to hold errors
    $form_errors = array();

    // validate
    $required_fields = array('email', 'password');
    $form_errors = array_merge($form_errors, check_empty_fields($required_fields));

    if(empty($form_errors)){

        // collect form data
        $user = $_POST['email'];
        $password = $_POST['password'];
        isset($_POST['remember'])? $remember = $_POST['remember'] : $remember = "";
        // check if user exist in the database
        $sqlQuery = "SELECT * FROM users WHERE email = :email";
        $statement = $db->prepare($sqlQuery);
        $statement->execute(array(':email' => $user));

        while($row = $statement->fetch()){
            $id = $row['id'];
            $hashed_password = $row['password'];
            $email = $row['email'];

            if(password_verify($password, $hashed_password)){
                $_SESSION['id'] = $id;
                $_SESSION['email'] = $email;
                $_SESSION['permission'] =  $row['permission'];
				$_SESSION['first_name'] = $row['first_name'];
				$_SESSION['last_name'] = $row['last_name'];		
                $fingerprint = md5($_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT']);
                $_SESSION['last_active'] = time();
                $_SESSION['fingerprint'] = $fingerprint;

                if($remember === "yes") {
                    rememberMe($id);
                }
                echo $welcome = "Welcome back ".$email.", You're being logged in.";
				if($_SESSION['permission'] === '2') {
					redirectTo('noPermission');
                }
                elseif($_SESSION['permission'] === '1') {
                    redirectTo('mapProjectList');
                }
				else {
					redirectTo('showPermission');
				}
            } else {
                $result = flashMessage("Invalid email or password");
            }
        }

    } else {
        if(count($form_errors) == 1){
            $result = flashMessage("There was one error in the form");
        } else {
            $result = flashMessage("There was ".count($form_errors)." error in the form");
        }
    }

}
?>

<main class="container">

<div class="container">
    <section class="col col-lg-7">
        <h3>Login Form</h3>
        <div>
            <?php if (isset($result)) echo $result; ?>
            <?php if (!empty($form_errors)) echo show_errors($form_errors); ?>
        </div>
        <div class="clearfix"></div>
        <form action="" method="post">
            <div class="form-group">
                <label for="emailField">email</label>
                <input type="text" class="form-control" name="email" id="emailField" aria-describedby="email" placeholder="email">
            </div>
            <div class="form-group">
                <label for="passwordField">Password</label>
                <input type="password" class="form-control" name="password" id="passwordField" placeholder="Password">
            </div>
            <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" name="remember" id="checkboxField" value="yes">
                <label class="form-check-label" for="checkboxField">Remember me</label>
            </div>
            <a href="./forgot_password.php">Forgot Password?</a>
            <button type="submit" name="loginBtn" class="btn btn-primary float-right">Sign in</button>
        </form>
    </section>
</div>


</main>

<?php
require_once('./include/footer.php');
?>