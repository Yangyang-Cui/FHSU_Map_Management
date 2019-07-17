<?php 
$title = "Modify Map";
	require('resource/session.php');
	require('mapPullFromDB.php');
	require('mapAddToDB.php');
	if(isset($_GET['layerSelect'])){
	$_SESSION['layer'] = $_GET['layerSelect'];
	}
?>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC8kwjOb5GzrWhKJsw_L1fhOy7xJ6FNr1E"></script>
  <?php require_once("include/header.php"); ?>

		<div class="sidebar" style="float:right;position: absolute;right: 2rem;height: 100%;top: 100px; right:4px">
			<button id="createMarker" style="display: block">Marker</button>
			<button id="createCircle" style="display: block">Circle</button>
			<button id="createPolyLine" style="display: block">Polyline</button>
			<button id="createPolygon" style="display: block">Polygon</button>
			<button id="createBuilding" style="display: block">Building</button>
			<button id="createParking" style="display: block">Parking Lot</button>
		<form id="save" method="post" action="mapAddToDB.php" style="top: 7px;">
		<div>
			<button id="saveLayer" name="isNew" type="submit" style="display: block">Save New</button>
			<input type="text" name="layerName" placeholder="Enter name of new layer..." style="display:block"></input>	
			<input type="checkbox" name="isTour" value="T">This layer is a tour</input>
		</form>

		</div>
		<form id="update" method="post" action="mapAddToDB.php">
			<button id="updateLayer" name="update" type="submit" style="display: block">Update Layer</button>
		</form>
</div>
	<script>
	var jsonArray =JSON.parse(<?php echo loadShapes() ?>);
	</script>
<script src="mapScript.js"></script>
<script>console.log(jsonArray)</script>
	<div class="top-map" style="width:100%;height: 105vh;">
		<div style="width: 85%; height: 100%;" id="map"></div>
	</div>
		<div>
			<?php loadShapes(); ?>
			<form id='buildingForm' style='display: none;'>
			Name of item:<input type='text' id='name'/><br />
			Hours of operation:<input type='text' id='openHours'/><br />
			Picture URL:<input type='text' id='picture'/><br />
			Add extra info about this item?<br />
			Yes<input type='radio' value='true'/> <br />
			No<input type='radio' value='false'/> <br />
			Enter details:<input type='text' id='infoWindow'></input><br />
			<button type='submit' id='apply'>Apply</button>
		</form>
		</div>
		<div>
		<form id='polygonForm' style='display: none'>
			Name of item:<input type='text' id='name'/><br />
			Picture URL:<input type='text' id='picture'/><br />
			Add extra info about this item?<br />
				Yes<input type='radio' value='true'/> <br />
				No<input type='radio' value='false'/> <br />
			Enter details:<input type='text' id='infoWindow'></input><br />
			Pick a color for the shape outline:<input type='color' id='colorVal'></input><br />
			Thickness of line/border in pixels:<input type='number' id='strokeWidth'></input><br />
			Opacity (0 to 1.0) of shape:<input type='number' step='0.01' style="width:80px" id='fillOpacity'/> <br />
			Pick a color to fill the shape:<input type='color' id='fillColor'/><br />
			<button type='submit' id='apply'>Apply</button>
		</form>
		</div>	
		<div>
		<form id='polylineForm' style = 'display: none'>
			Name of item:<input type='text' id='name'/><br />
			Opacity (0 to 1.0) of shape:<input type='number' step='0.01' style="width:80px" id='fillOpacity'/> <br />
			Pick a color for the line:<input type='color' id='fillColor'/><br />
			Thickness of line in pixels:<input type='number' id='strokeWidth'></input><br />
			<button type='submit' id='apply'>Apply</button>
		</form>
		</div>
		<div>
		<form id='circleForm' style='display: none'>
			Name of item:<input type='text' id='name'/><br />
			Pick a color for the shape outline:<input type='color' id='colorVal'></input><br />
			Thickness of line/border in pixels:<input type='number' id='strokeWidth'></input><br />
			Opacity (0 to 1.0) of shape:<input type='number' step='0.01' style="width:80px" id='fillOpacity'/> <br />
			Pick a color to fill the shape:<input type='color' id='fillColor'/><br />
			<button  type='submit' id='apply'>Apply</button>
		</form>
		</div>
		<div>
		<form id='markerForm' style='display: none'>
			Name of item:<input type='text' id='name'/><br />
			Add extra info about this item?<br />
				Yes<input type='radio' value='true'/> <br />
				No<input type='radio' value='false'/> <br />
			Enter details:<input type='text' id='infoWindow'></input><br />
			Picture filepath:<input type='text' id='picture'/><br />
			Link info from external page?<input type='checkbox' id='urlBool'/><br />
				Title of info URL: <input type='text' id='urlTitle'/><br />
				Enter URL here:<input type='text' id='infoURLLink'/><br />
			<button type='submit' id='apply'>Apply</button>
		</form>
		</div>

<script>initMap()</script>
<?php require_once('./include/footer.php'); ?>