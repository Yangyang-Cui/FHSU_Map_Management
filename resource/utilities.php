<?php

function check_empty_fields($required_fields_array){
    // initialize an array to store error messages
    $form_errors = array();

    // loop through the required fields array and popular the form error array
    foreach($required_fields_array as $name_of_field){
        if(!isset($_POST[$name_of_field]) || $_POST[$name_of_field] == NULL) {
            $form_errors[] = $name_of_field . " is a required field";
        }
    }
    return $form_errors;
}

function check_min_length($fields_to_check_length){
    // initialize an array to store error messages
    $form_errors = array();

    foreach($fields_to_check_length as $name_of_field => $minimum_length_required){
        if(strlen(trim($_POST[$name_of_field])) < $minimum_length_required) {
            $form_errors[] = $name_of_field ." is too short, must be {$minimum_length_required} characters long";
        }
    }
    return $form_errors;
}

function check_pattern($pattern, $string, $field_name) {
	if(!preg_match($pattern, $string)) 
	{
		return[$field_name." does not meet requirements."];
	}
	return[];
}

function check_email($data){
    // initialize an array to store error messages
    $form_errors = array();
    $key = 'email';
    // check if the key email exist in data array
    if(array_key_exists($key, $data)){

        // check if the email field has a value
        if($_POST[$key] != null){
            // Remove all illegal characters from email
            $key = filter_var($key, FILTER_SANITIZE_EMAIL);

            // check if input is a valid email address
            if(filter_var($_POST[$key], FILTER_VALIDATE_EMAIL) === false){
                $form_errors[] = $key . " is not a valid email address";
            }
        }
    }
    return $form_errors;
}

function show_errors($form_errors_array){
    $errors = "<p><ul style='color:red;'>";

    // loop through error array and display all items in a list
    foreach($form_errors_array as $the_error){
        $errors .= "<li> {$the_error} </li>";
    }
    $errors .= "</ul></p>";
    return $errors;
}

function flashMessage($message, $successful = false){
    return '<div class="alert alert-'.($successful ? 'success' : 'danger').'">'.$message.'</div>';
    /*
    if($successful){
        $data = "<div class='alert alert-success'>{$message}</div>";
    } else {
        
        $data = "<div class='alert alert-danger'>{$message}</div>";
    }
    return $data;*/
}

function redirectTo($page){
    header("Location: {$page}.php");
}

function checkDuplicateEntries($table, $column_name, $value, $db){

    try {
        $sqlQuery = "SELECT * FROM " .$table. " WHERE " .$column_name."=:$column_name";
        $statement = $db->prepare($sqlQuery);
        $statement->execute(array(":$column_name" => $value));


        if($row = $statement->fetch()){
            return true;
        }
        return false;
    } catch (PDOException $ex) {
        // handle exception
        //$result = flashMessage("An error occurred: ". $ex->getMessage());
    }
}

function rememberMe($user_id){
    $encryptCookieData = base64_encode("UaQte2h5i4y3d8nt1stemYO6DEC{$user_id}");
    // Cookie set to expire in about 30 days
    setcookie("rememberUserCookie", $encryptCookieData, time() + 60*60*24*100, "/");
}

function isCookieValid($db) {
    $isValid = false;
    if(isset($_COOKIE['rememberUserCookie'])) {
        $decryptCookieData = base64_decode($_COOKIE['rememberUserCookie']);
        $user_id = explode('UaQte2h5i4y3d8nt1stemYO6DEC', $decryptCookieData);
        $userID = $user_id[1];

        $sqlQuery = "SELECT * FROM users WHERE id = :id";
        $statement = $db->prepare($sqlQuery);
        $statement->execute(array(':id' => $userID));
        if($row = $statement->fetch()){
            $id = $row['id'];
            $first_name = $row['first_name'];
            $last_name = $row['last_name'];
            $_SESSION['id'] = $id;
            $_SESSION['first_name'] = $first_name;
            $_SESSION['last_name'] = $last_name;
            $isValid = true;
        } else {
            $isValid = false;
            $this->signout();
        }
    }
    return $isValid;
}

function signout(){
    unset($_SESSION['email']);
    unset($_SESSION['id']);

    if(isset($_COOKIE['rememberUserCookie'])) {
        unset($_COOKIE['rememberUserCookie']);
        setcookie('rememberUserCookie', null, -1, '/');
    }
    session_destroy();
    session_regenerate_id(true);
    redirectTo('index');
}

function guard() {
    $isValid = true;
    $inactive = 60 * 10; // 10 mins
    $fingerprint = md5($_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT']);

    if((isset($_SESSION['fingerprint']) && $_SESSION['fingerprint'] != $fingerprint)){
        $isValid = false;
        signout();
    } else if((isset($_SESSION['last_active']) && (time() - $_SESSION['last_active']) > $inactive) && $_SESSION['email']){
        $isValid = false;
        signout();
    } else {
        $_SESSION['last_active'] = time();
    }
    
    return $isValid;
}

function isValidImage($file){
    $form_errors = array();

    // split file name into an array using the dot (.)
    $part = explode(".",$file);

    // target the last element in the array
    $extension = end($part);

    switch(strtolower($extension)){
        case 'jpg':
        case 'gif':
        case 'bmp':
        case 'png':

        return $form_errors;
    }

    $form_errors[] = $extension." is not a valid image extension";
    return $form_errors;
}

function uploadAvatar($first_name,$last_name){

    $isImageMoved = false;

    if($_FILES['avatar']['tmp_name']){

        $temp_file = $_FILES['avatar']['tmp_name'];
        $ds = DIRECTORY_SEPARATOR; // uploads/
        $avatar_name = $first_name.$last_name.".jpg";

        $path = "img".$ds.$avatar_name; //uploads/demo.jpg

        if(move_uploaded_file($temp_file, $path)){
            $isImageMoved = true;
        }
    }
    return $isImageMoved;
}