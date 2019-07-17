<?php
//SAVE SHAPE INFORMATION AS KEY:VALUE
//IF A VALUE IS CHECKED ON CREATION PAGE, ADD A 'T' TO AN EXTRA COLUMN FOR FRONT-END MENU OPTION PURPOSES LATER
require_once('mysqlclass.php');
require_once('resource/session.php');
require_once('mapAddShapes.php');
require_once('mapPullFromDB.php');
$idArr = array();
$SQL = new mySQL();
$SQL->connect('localhost','map','root');
if(isset($_GET['delete']) && $_SESSION['permission'] == 0) {
	$SQL->delete("DELETE FROM layers WHERE id = ? VALUES(?)",[$_GET['layerSelect']]);
	generateJSON();
}
else if( isset($_GET['delete']) && $_SESSION['permission']==1) {
	$SQL->delete("DELETE FROM layers WHERE id = ? AND user_id = ? VALUES(?,?)",[$_GET['layerSelect'],$_GET['permission']]);
	generateJSON();
}
else if(isset($_POST['data'])){
$infoArray = json_decode($_POST['data']);
	for($i = 1; $i < count($infoArray); $i++) {
		if(isset($_POST['isNew'])) {
			if($infoArray[0]=='isNew' AND count($infoArray)==1) { break; };
			if($infoArray[$i] == 'isNew') { continue; };
			//$layer_id = $SQL->insert("INSERT INTO layers VALUES ()",[
			$idArr[] = $SQL->insert("INSERT INTO shapes(shape_info) VALUES (?)",[$infoArray[$i]]);
			$SQL->insert("INSERT INTO layers_shapes(layer_id, shape_id) VALUES (?,?)",[$_SESSION['layer'],$idArr]);
			echo($infoArray[$i]);
		}
	}
	for($i=0; $i<count($idArr);$i++) {
		if(isset($_POST['isNew']) && isset($_POST['isTour'])) {
			$SQL->insert("INSERT INTO layers(name, map_id, code, user_id) VALUES(?, ?, ?, ?)",[$_POST['layerName'],1, "T", $_SESSION['id']]);
		}
		else if(isset($_POST['isNew']) && !isset($_POST['isTour'])) {
			$SQL->insert("INSERT INTO layers(name, map_id, user_id) VALUES(?, ?, ?)",[$_POST['layerName'],1, $_SESSION['id']]);
		}
		else if(isset($_POST['update'])) {
		$SQL->update("UPDATE shapes SET shapes.shape_info = ? WHERE layers_shapes.id = ?",[$_GET['layerSelect']]);
		}
	}
	generateJSON();
}
