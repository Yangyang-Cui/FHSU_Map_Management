<?php
require_once('mysqlclass.php');
$sql = new mySQL();
$sql->connect('localhost','map','root');

$layers = $sql->select("SELECT id, elements FROM layers");
$shapes = $sql->select("SELECT * FROM shapes");
$shapearray=[];
while($shapearray[] = $shapes->fetch() );
while($row = $layers->fetch() )
{
	$row['elements']=json_decode($row['elements'],true);
	foreach($shapearray as $shape){
		//print_r($row['elements'][0]['type']);
		foreach($row['elements'] as $element)
		{
			if($element['type'] == $shape['type'] && $element['id'] == $shape['old_id'])
			{
				$sql->insert("INSERT INTO layers_shapes(layer_id, shape_id) VALUES(?,?)",[$row['id'],$shape['id']]);
			}
			else
			{
				echo "did not insert </br>";	
				echo($element['type']." : ".$element['id']."</br>".$shape['type']." : ".$shape['id']."</br></br>");
			}
		}
	}
}

?>