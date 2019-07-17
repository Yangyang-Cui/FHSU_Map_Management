<?php 
	$title = "Edit Project";
	require_once('resource/session.php');
	require_once('mapPullFromDB.php');
	require_once("include/header.php");
	require_once('resource/utilities.php');
?>
<main class="container">
	<h1>Welcome <?php echo(" ".$_SESSION['first_name']." ".$_SESSION['last_name']."!"); ?></h1>
	<h2>Select one of your projects:</h2>
	<?php loadList(); ?>
</main>
<?php 
	require_once('include/footer.php');
?>