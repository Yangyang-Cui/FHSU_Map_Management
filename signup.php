<?php 
// add our database connection script
$title = 'Register Page';
require_once('./include/header.php');
// process the form
if(isset($_POST['signupBtn'])) {
    // initialize an array to store any error message from the form
    $form_errors = array();

    // form validation
    $required_fields = array('email', 'first_name', 'password');

    // call the function to check empty field and merge the return data into form_error array
    $form_errors = array_merge($form_errors, check_empty_fields($required_fields));

    // fields that requires checking for minimum length
    

    // call the function to check minimum required length and merge the return data into form_error array
    $form_errors = array_merge($form_errors, check_pattern('/.{8,16}/',$_POST['password'],'Password'));
    
    // email validation / merge the return data into form_error array
    $form_errors = array_merge($form_errors, check_email($_POST));

    if(checkDuplicateEntries("users", "email", $email, $db)){
        $result = flashMessage("Email is already taken, please try another one");
	}
    // check if error arry is empty, if yes process form data and insert record
    else if(empty($form_errors)) {
        // hashing the password
        $hashed_password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        try {
            // create SQL insert statement
            $sqlInsert = "INSERT INTO users(first_name, last_name, email, password, join_date, permission)
                    VALUES (:first_name, :last_name, :email, :password, :join_date, :permission)";

            // use PDO prepared to sanitize data
            $statement = $db->prepare($sqlInsert);

            // add the data into the database
            $statement->execute(array(
                ':first_name' => $_POST['first_name'],
				':last_name' => $_POST['last_name'],
                ':email' => $_POST['email'],
                ':password' => $hashed_password,
                ':join_date' => date("Y-m-d h:i:sa"),
                ':permission' => 2
            ));

            // check if one new row was created
            if ($statement->rowCount() == 1) {
                $result = flashMessage("Registration Successful", true);
            }
        } catch (PDOException $ex) {
            $result = flashMessage("An error occurred: ". $ex->getMessage());
        }

    } else {
        if(count($form_errors) == 1) {
            $result = flashMessage("There was 1 error in the form<br>");
        } else {
            $result = flashMessage("There were ".count($form_errors)." errors in the form <br>");
        }
    }
    
}

?>
<main class="container">
<div class="container">
    <section class="col col-lg-7">
        <h3>Registration Form</h3>
        <div>
            <?php if (isset($result)) echo $result; ?>
            <?php if (!empty($form_errors)) echo show_errors($form_errors); ?>
        </div>
        <div class="clearfix"></div>
        <form action="" method="post">
            <div class="form-group">
                <label for="emailField">Email Address</label>
                <input type="text" class="form-control" name="email" id="emailField" aria-describedby="email" placeholder="Email">
            </div>
            <div class="form-group">
                <label for="first_nameField">first_name</label>
                <input type="text" class="form-control" name="first_name" id="first_nameField" aria-describedby="first_name" placeholder="first_name">
            </div>
			<div class="form-group">
                <label for="last_nameField">last_name</label>
                <input type="text" class="form-control" name="last_name" id="last_nameField" aria-describedby="last_name" placeholder="last_name">
            </div>
            <div class="form-group">
                <label for="passwordField">Password</label>
                <input type="password" class="form-control" name="password" id="passwordField" placeholder="Password">
            </div>
            <button type="submit" name="signupBtn" class="btn btn-primary float-right">Sign up</button>
        </form>
    </section>
</div>
</main>
<?php
require_once('./include/footer.php');
?>