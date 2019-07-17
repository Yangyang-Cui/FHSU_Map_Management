<pre>
<?php
require_once('mysqlclass.php');
$SQL = new mySQL();
$SQL->connect('localhost','map','root');
$jsonFile = file_get_contents('json_fhsuDataTypes.json');
$data=json_decode($jsonFile, true);
/*
foreach($data['buildings'] as $building){
	
	$shape_info=json_encode($building['buildingOutline']);
	$data['buildings']=array_diff_key($building,['buildingOutline']);
	$extra_info=json_encode($building);
	$SQL->insert("INSERT INTO shapes(shape_info,extra_info, old_id) VALUES(?,?,?)",[$shape_info,$extra_info,$building['id']]);
}

foreach($data['pois'] as $poi)
{
	$shape_info=json_encode($poi['latLng']);
	$data['pois']=array_diff_key($poi,['latLng']);
	$extra_info=json_encode($poi);
	$SQL->insert("INSERT INTO shapes(shape_info,extra_info, old_id) VALUES(?,?,?)",[$shape_info,$extra_info,$poi['id']]);
}

foreach($data['circles'] as $circle)
{
	$shape_info=[$circle['latLngCenter'],$circle['radius']];
	$shape_info=json_encode($shape_info);
	$data['circles']=array_diff_key($circle,[['latLngCenter'],['radius']]);
	$extra_info=json_encode($circle);
	$SQL->insert("INSERT INTO shapes(shape_info,extra_info, old_id) VALUES(?,?,?)",[$shape_info,$extra_info,$circle['id']]);
}

foreach($data['polylines'] as $polyline)
{
	$shape_info=json_encode($polyline['latLngArray']);
	$data['polylines']=array_diff_key($polyline,['latLngArray']);
	$extra_info=json_encode($polyline);
	$SQL->insert("INSERT INTO shapes(shape_info,extra_info, old_id) VALUES(?,?,?)",[$shape_info,$extra_info,$polyline['id']]);
}

foreach($data['polygons'] as $polygon)
{
	$shape_info=json_encode($polygon['outline']);
	$data['polygons']=array_diff_key($polygon,['outline']);
	$extra_info = json_encode($polygon);
	$SQL->insert("INSERT INTO shapes(shape_info,extra_info, old_id) VALUES(?,?,?)",[$shape_info,$extra_info,$polygon['id']]);
}
/*
foreach($data['parking'] as $parking)
{
	$shape_info=json_encode($parking['parkingOutline']);
	$data['parking']=array_diff_key($parking,['parkingOutline']);
	$extra_info=json_encode($parking);
	$SQL->insert("INSERT INTO shapes(shape_info,extra_info, old_id) VALUES(?,?,?)",[$shape_info,$extra_info,$parking['id']]);
}

foreach($data['layers'] as $layer)
{
	$layer_elements=json_encode($layer['elements']);
	$layer_name=json_encode($layer['layerName']);
	$description=json_encode($layer['layerDescription']);
	$SQL->insert("INSERT INTO layers(name,description,elements,map_id,code,old_id) VALUES(?,?,?,?,?,?)",[$layer_name,$description,$layer_elements,1,"L",$layer['id']]);
}

foreach($data['layersMenuOptions'] as $layerMenu)
{
	$id=json_encode($layerMenu['id']);
	$label=json_encode($layerMenu['label']);
	$action=json_encode($layerMenu['layerID']);	
	$SQL->insert("INSERT INTO layer_menu(action,label,menu_item_id) VALUES(?,?,?)",[$action,$label,$id]);
}

foreach($data['toursMenuOptions'] as $tourMenu)
{
	$id=json_encode($tourMenu['id']);
	$label=json_encode($tourMenu['label']);
	$tour=json_encode($tourMenu['tourID']);
	$SQL->insert("INSERT INTO tour_menu(label, tour, menu_item_id) VALUES(?,?,?)",[$label,$tour,$id]);
}

foreach($data['mapSettings'] as $mapSettings)
{
	$setting_info=json_encode([$mapSettings['id'],$mapSettings['zoom'],$mapSettings['mapCenter']]);
	$data['mapSettings']=array_diff_key($mapSettings,[['id'],['zoom'],['mapCenter']]);
	$extra_info=json_encode($mapSettings);
	$SQL->insert("INSERT INTO map_settings(setting_info,extra_info) VALUES(?,?)",[$setting_info,$extra_info]);
}

foreach($data['mapStyles'] as $mapStyles)
{
	$style_info=json_encode($mapStyles);
	$SQL->insert("INSERT INTO map_styles(style_info) VALUES(?)",[$style_info]);
}
*/
foreach($data['tours'] as $tour)
{
	$tour_elements=json_encode($tour['elements']);
	$tour_name=json_encode($tour['tourName']);
	$description=json_encode($tour['tourDescription']);
	$SQL->insert("INSERT INTO tours(name,description,elements) VALUES(?,?,?)",[$tour_name,$description,$tour_elements]);
}