<?php
require_once('./resource/session.php');
require_once('./resource/Database.php');
require_once('./resource/utilities.php');
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title><?php if(isset($title)) echo $title ?></title>
    <link rel="icon" href="./img/tiger.png">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- Including jQuery -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    
    <link rel="stylesheet" type="text/css" media="screen" href="./css/style.css" />
</head>

<body>
  <?php print_r($_SESSION); ?>
    <nav class="navbar navbar-expand-md navbar-dark fixed-top" style="background-color:#eaaf0f;">
      <div class="container">
        <a class="navbar-brand" href="index.php"><img src="./img/tiger.png" alt="tiger">FHSU Map Management</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarsExampleDefault">
          <ul class="navbar-nav mr-auto">
            <li class='text-hide'><?php echo guard(); ?></li>
            <li class="nav-item">
              <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
            </li>
            <?php if(!isset($_SESSION['permission'])): ?>
            <li class="nav-item">
              <a class="nav-link" href="login.php">Login</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="signup.php">Sign up</a>
            </li>
            <?php elseif($_SESSION['permission']== 2): ?>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php if(isset($_SESSION['email'])) echo $_SESSION['email']; ?></a>
              <div class="dropdown-menu" aria-labelledby="dropdown01">
                <a class="dropdown-item" href="profile.php">My Profile</a>
                <a class="dropdown-item" href="logout.php">Logout</a>
              </div>
            </li>
            <?php elseif($_SESSION['permission']==1): ?>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php if(isset($_SESSION['email'])) echo $_SESSION['email']; ?></a>
              <div class="dropdown-menu" aria-labelledby="dropdown01">
                <a class="dropdown-item" href="profile.php">My Profile</a>
                <a class="dropdown-item" href="logout.php">Logout</a>
              </div>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="mapAddShapes.php">Modify Map</a>
            </li>
			<li class="nav-item">
              <a class="nav-link" href="mapProjectList.php">Project List</a>
            </li>
            <?php elseif($_SESSION['permission']==0): ?>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php if(isset($_SESSION['email'])) echo $_SESSION['email']; ?></a>
              <div class="dropdown-menu" aria-labelledby="dropdown01">
                <a class="dropdown-item" href="profile.php">My Profile</a>
                <a class="dropdown-item" href="logout.php">Logout</a>
              </div>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="mapAddShapes.php">Modify Map</a>
            </li>
			<li class="nav-item">
              <a class="nav-link" href="mapProjectList.php">Project List</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="showPermission.php">Modify permission</a>
            </li>
            <?php endif ?>
          </ul>
        </div>
      </div>
    </nav>