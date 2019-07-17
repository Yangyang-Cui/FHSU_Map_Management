<?php

if((isset($_SESSION['id']) || isset($_GET['user_identity'])) && !isset($_POST['updateProfileBtn'])){
    if(isset($_GET['user_identity'])){
        $url_encoded_id = $_GET['user_identity'];
        $decode_id = base64_decode($url_encoded_id);
        $url_id_array = explode("encodeuserid", $decode_id);
        $id = $url_id_array[1];
    } else {
        $id = $_SESSION['id'];
    }
   
    $sqlQuery = "SELECT * FROM users WHERE id = :id";
    $statement = $db->prepare($sqlQuery);
    $statement->execute(array(':id' => $id));

    while($rs = $statement->fetch()){
        $first_name = $rs['first_name'];
        $last_name = $rs['last_name'];
        $email = $rs['email'];
        $date_joined = strftime("%b %d, %Y", strtotime($rs['join_date']));
    }

    $user_pic = "img/".$first_name.$last_name.".jpg";
    $default = "img/default_profile.jpg";

    if(file_exists($user_pic)){
        $profile_picture = $user_pic;
    } else {
        $profile_picture = $default;
    }

    $encode_id = base64_encode("encodeuserid{$id}");

} else if(isset($_POST['updateProfileBtn'])){
    // initialize an array to store any error message from the form
    $form_errors = array();

    // form validation
    $required_fields = array('email', 'first_name', 'last_name');

    // call the function to check empty field and merge the return data into form_error array
    $form_errors = array_merge($form_errors, check_empty_fields($required_fields));
    echo count($form_errors).'-1';
    // fields that requires checking for minimum length
   // $fields_to_check_length = array('username' => 4);
   //$form_errors = array_merge($form_errors, check_pattern('/.{8,16}/',$_POST['password'],'password'));
   //echo count($form_errors).'-2';

    // call the function to check minimum required length and merge the return data into form_error array
    //$form_errors = array_merge($form_errors, check_min_length($fields_to_check_length));

    // email validation / merge the return data into form_error array
    $form_errors = array_merge($form_errors, check_email($_POST));
    echo count($form_errors).'-3';

    // validate if file has a valid extension
    isset($_FILES['avatar']['name'])? $avatar = $_FILES['avatar']['name'] : $avatar = null;
    if($avatar != null) {
        $form_errors = array_merge($form_errors, isValidImage($avatar));
    }

    echo count($form_errors).'-4';
    // collect form data and store in variables
    $email = $_POST['email'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $hidden_id = $_POST['hidden_id'];

    if(empty($form_errors)){
        try{
            // create SQL update statement
            $sqlUpdate = 'UPDATE users SET first_name = :first_name, last_name = :last_name, email =:email WHERE id=:id';

            // use PDO prepared to sanitize data
            $statement = $db->prepare($sqlUpdate);

            // update the record in the database
            $statement->execute(array(':first_name' => $first_name, ':last_name' => $last_name, ':email' => $email, ':id' => $hidden_id));

            // check if one new row was created
            if($statement->rowCount() == 1 || uploadAvatar($first_name,$last_name)) {
                $result = flashMessage("Update successfully", true);
            } else {
                $result = flashMessage("You have not made any changes");
            }
        } catch (PDOException $ex){
            $result = flashMessage(("An error occurred in : " .$ex->getMessage()));
        }
    } else {
        if(count($form_errors) == 1) {
            $result = flashMessage("There was 1 error in the form<br>");
        } else {
            $result = flashMessage('There were '.count($form_errors). ' errors in the form<br>');
        }
    }
}