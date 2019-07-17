<?php
require_once('resource/session.php');
require_once('mysqlclass.php');
//This file will be handling the SELECT statements to pull layer/shape data from table
//SELECT s.id, s.shape_info FROM shapes s JOIN layers_shapes l ON l.shape_id = s.id WHERE l.layer_id = ?
//Image files for icons etc. are in img folder. Save the proper string for file name (if user selects a heart, save file name as "img/heart.png")

//Student schedule data will look like this as a JSON element: "days": [MON: "12:30PM-1:20PM", TUE:"", WED:"12:30PM-1:20PM", THU:"", FRI:"12:30PM-1:20PM", SAT:"", SUN:""];

//This function finds what layers a user has access to and makes a dropdown choice for them to choose or delete from
function loadList() {
	$sql = new mySQL();
	$sql->connect('localhost','map','root');
	$layerList = $sql->select("SELECT id, name FROM layers WHERE user_id=?", [$_SESSION['id']]);
	echo "<form id='direct' method='GET' action='mapAddShapes.php'>";
	echo "<select name='layerSelect' id='layerList'>";
	while($row = $layerList->fetch()) {
		echo("<option id='layerList' name='layerSelect' value=".$row['name'].">".$row['name']."</option>");
	}
	echo("</select>");
	echo "<button type='submit'>Edit Selected</button>";
	echo "<button type='submit' name='delete' value='1'>Delete Selected Layer</button>";
	echo "</form>";	
}

//This function is meant to grab information from the database, format it to meet what front end is needing, and echo it to them
function loadShapes() {
	$shape_info = [];
	$layer_info = [];
	$sql = new mySQL();
	$sql->connect('localhost','map','root');
	$shape_info = $sql->select("SELECT * FROM shapes");
	$layer_info = $sql->select("SELECT * FROM layers");
	generateJSON();
}

//Function that generates JSON file for front end using database information
function generateJSON()
{
	$combined = array('buildings'=>[],
						'circles'=>[],
						'pois'=>[],
						'parking'=>[],
						'polygons'=>[],
						'polylines'=>[],
						'layersMenuOptions'=>[],
						'toursMenuOptions'=>[],
						'layers'=>[],
						'tours'=>[],
						'mapSettings'=>[],
						'mapStyles'=>[]
						);
	$sql = new mySQL();
	$sql->connect('localhost','map','root');
	$shape_info = $sql->select("SELECT s.id,s.shape_info,s.extra_info,s.type,l.name FROM shapes AS s 
									JOIN layers_shapes AS ls ON ls.shape_id = s.id 
									JOIN layers AS l ON ls.layer_id = l.id");
	
	while($row = $shape_info->fetch() )
	{
		if($row['type'] == 'buildings')
		{
			$combined['buildings'][] = array_merge(json_decode($row['shape_info'],true),json_decode($row['extra_info'],true));
		}
		if($row['type'] == 'circles')
		{
			$combined['circles'][] = array_merge(json_decode($row['shape_info'],true),json_decode($row['extra_info'],true));
		}
		if($row['type'] == 'pois')
		{
			$combined['pois'][] = array_merge(json_decode($row['shape_info'],true),json_decode($row['extra_info'],true));
		}
		if($row['type'] == 'polylines')
		{
			$combined['polylines'][] = array_merge(json_decode($row['shape_info'],true),json_decode($row['extra_info'],true));
		}
		if($row['type'] == 'polygons')
		{
			$combined['polygons'][] = array_merge(json_decode($row['shape_info'],true),json_decode($row['extra_info'],true));
		}
		if($row['type'] == 'parking')
		{
			$combined['parking'][] = array_merge(json_decode($row['shape_info'],true),json_decode($row['extra_info'],true));
		}
	}
	$l_menu = $sql->select("SELECT action, label, menu_item_id FROM layer_menu");
	$t_menu = $sql->select("SELECT label, tour, menu_item_id FROM tour_menu");
	while($row = $l_menu->fetch())
	{
		$combined['layersMenuOptions'][] = ['layerID'=>$row['action'],'label'=>$row['label'],'id'=>$row['menu_item_id']];
	}
	while($row = $t_menu->fetch() )
	{
		$combined['toursMenuOptions'][] = ['label'=>$row['label'],'tourID'=>$row['tour'],'id'=>$row['menu_item_id']];
	}
	$tours = $sql->select("SELECT name, description, elements FROM tours");
	$m_styles = $sql->select("SELECT style_info FROM map_styles");
	$m_settings = $sql->select("SELECT setting_info, extra_info FROM map_settings");
	while($row = $tours->fetch() )
	{
		$combined['tours'][] = ['name'=>$row['name'],'description'=>$row['description'],'elements'=>json_decode($row['elements'],true)];
	}
	while($row = $m_styles->fetch() )
	{
		$combined['mapStyles'][] = json_decode($row['style_info']);
	}
	while($row = $m_settings->fetch() )
	{
		$combined['mapSettings'][] = array_merge(json_decode($row['setting_info'],true),json_decode($row['extra_info'],true));
	}
	$layers = $sql->select("SELECT name, description, elements FROM layers");
	while($row = $layers->fetch() )
	{
		$combined['layers'][] = ['layerName'=>$row['name'],'layerDescription'=>$row['description'],'elements'=>json_decode($row['elements'],true)];
	}
	$fhandler = fopen('jsonFromDB.json','w+');
	fwrite($fhandler, json_encode($combined));
	fclose($fhandler);
	
	
}