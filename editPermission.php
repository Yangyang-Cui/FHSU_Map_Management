<?php
$title = "Edit Permission";
require_once('include/header.php');
$detail_sql = "SELECT * FROM users WHERE id=".$_GET['id'];
//$detail_sql = "SELECT * FROM users WHERE email= 'cuiyang21@gmail.com'";

$detail = $db->query($detail_sql);
foreach($detail as $row) {

}
// update permission
if(isset($_POST['changePermissionBtn'])) {
    // collect form data and store in variables
    $id = $_GET['id'];
    $email=$_POST['email'];
    $first_name=$_POST['first_name'];
    $last_name=$_POST['last_name'];
    $permission=$_POST['permission'];
    try {
        // create SQL insert statement
        $sqlInsert = "UPDATE users SET email = :email, first_name = :first_name, last_name = :last_name, permission = :permission WHERE id=:id";

        // use PDO prepared to sanitize data
        $statement = $db->prepare($sqlInsert);

        // add the data into the database
        $statement->execute(array(
            ':email' => $email,
            ':first_name' => $first_name,
            ':last_name' => $last_name,
            ':permission' => $permission,
            ':id' => $id
        ));
        redirectTo('showPermission');

  
    } catch (PDOException $ex) {
        $result = flashMessage("An error occurred: ". $ex->getMessage());
    }

}

// delete article
if(isset($_POST['delete_account'])) {
    // collect form data and store in variables
    $id = $_GET['id'];
    try {
        // create SQL insert statement
        $sqlInsert = "DELETE FROM users WHERE id=:id";

        // use PDO prepared to sanitize data
        $statement = $db->prepare($sqlInsert);

        // add the data into the database
        $statement->execute(array(
            ':id' => $id
        ));
        redirectTo('showPermission');
  
    } catch (PDOException $ex) {
        $result = flashMessage("An error occurred: ". $ex->getMessage());
    }

}

?>
<main class="container">

    <?php if(!isset($_SESSION['email'])): ?>
    <p class="lead">You are not authorized to view this page <a href="login.php">Login</a>
     Not yet a member? <a href="signup.php">Sign up</a></p>
    <?php else: ?>
        <form action="" method="post">
            <div class="form-group">
                <label for="emailField">Email</label>
                <input type="text" name="email" class="form-control" id="emailField" value="<?php echo $row['email']; ?>">
            </div>
            <div class="form-group">
                <label for="first_nameField">First name</label>
                <input type="text" name="first_name" value="<?php echo $row['first_name']; ?>" class="form-control" id="fist_nameField">
            </div>
            <div class="form-group">
                <label for="last_nameField">Last name</label>
                <input type="text" name="last_name" value="<?php echo $row['last_name']; ?>" class="form-control" id="last_nameField">
			</div>
			<div class="form-group">
                <label for="permission">Permission</label>
                <input type="text" name="permission" value="<?php echo $row['permission']; ?>" class="form-control" id="permission">
            </div>

            <input type="hidden" name="hidden_id" value="<?php if(isset($id)) echo $id; ?>">
			<button type="submit" name="changePermissionBtn" class="btn btn-primary float-right">Change permission</button>
			<button type="submit" name="delete_account" class="btn btn-primary">Delete this account</button>
        </form>
    <?php endif ?>

</main>
<?php
require_once('include/footer.php');
?>