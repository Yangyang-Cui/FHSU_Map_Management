var globalShape;
var map;
var shapeArr = [];
//initMap holds all the code currently. This is not efficient and should be reworked once the rest of the project is functional
initMap = function() {
	  //Used for centerpoint of map. 
	  var myLatLng = {lat: 38.8718264,lng: -99.34266};
	  //These booleans control whether the next marker is part of a polyline, polygon, the center of a circle, or a normal marker
	  var polyLineActive = false;
	  var polygonActive = false;
	  var parkingActive = false;
	  var markerActive = false;
	  var circleActive = false;
	  var buildingActive = false;
	  var using = false;
	  //Generic increment variable
	  var i = 0;
	  //Array used to hold the array of lat lng data for drawing each shape
	  var pointArr = [];
	  //These are used to determine the averages of lat lngs given to polygons, buildings, anything needing a center
	  var highLat = 0;
	  var lowLat = 100;
	  var highLng = -200;
	  var lowLng = 200;
	  var buildCenter = {"lat":0, "lng":0};
	  var pointNum = 0;
	  //drawArr is meant to hold data for drawing shapes if an existing layer is selected on the back end so the user knows what already exists
	  var drawArr = [];
	  map = new google.maps.Map(document.getElementById('map'), {
		zoom: 17,
		center: myLatLng
	});
	//Centerpoint of map
	var myLatlng = new google.maps.LatLng(38.8737013,-99.341691);


	//If user has selected a circle, this function first stores the centerpoint lat lng, then draws the circle after the radius is entered
	//Radius is in meters
	map.addListener('click', function( event ) {
		if(circleActive){
			var lat1 = event.latLng.lat();
			var lng1 = event.latLng.lng();
			var center = new google.maps.LatLng(lat1,lng1);
			var radius = prompt("Enter the radius in meters:");
			radius = parseFloat(radius);
			var cityCircle = new google.maps.Circle({
				type:'circles',
				strokeColor: '#eeaf0f',
				strokeOpacity: 0.8,
				strokeWeight: 2,
				fillColor: '#000000',
				fillOpacity: 0.35,
				map: map,
				center: center,
				radius: radius
			});
			globalShape=cityCircle;
			var infowindow = new google.maps.InfoWindow({ content: prompt("Enter info about this marker if you'd like."),});
						google.maps.event.addListener(cityCircle, 'click', function() {
							infowindow.open(map, cityCircle);
						});
				//Line below accesses circle properties and logs them
			var shapeObj = {
					name:prompt("Give this circle a name."),
					type:cityCircle.type,
					strokeColor:cityCircle.strokeColor,
					strokeOpacity:cityCircle.strokeOpacity,
					strokeWeight:cityCircle.strokeWeight,
					fillOpacity:cityCircle.fillOpacity,
					fillColor:cityCircle.fillColor,
					center:cityCircle.center,
					radius:cityCircle.radius,
					infoWindow:true,
					infoWindowContent:"This is a test string for saving/sending purposes."
			};
			var jsonStr = JSON.stringify(shapeObj);
			shapeArr.push(jsonStr);
			circleActive = false;
		}
		if (polyLineActive == true) {
				var lat = event.latLng.lat();
				var lng = event.latLng.lng();
				var latlng = new google.maps.LatLng(lat,lng);
				pointArr.push(latlng);
				i++;
					var polyline = new google.maps.Polyline({
						type:'polylines',
						path: pointArr,
						geodesic: true,
						strokeColor: '#FFAA11',
						strokeOpacity: 0.5,
						strokeWeight: 2
					});
				drawArr.push(polyline);
				for(x in drawArr) { drawArr[x].setMap(null); };
				polyline.setMap(map);
				if(i == pointNum) {
					polyLineActive = false;
					i=0;
					var shapeObj = {
						name:prompt("Name this line"),
						type:polyline.type,
						strokeColor:polyline.strokeColor,
						strokeOpacity:polyline.strokeOpacity,
						strokeWeight:polyline.strokeWeight,
						latLngArray:polyline.latLngs.j[0].j,
					}
					var jsonStr = JSON.stringify(shapeObj);
					shapeArr.push(jsonStr);
					console.log(jsonStr);
					console.log(polyline);
				}
			}
			
		if (polygonActive == true) {
				var lat = event.latLng.lat();
				var lng = event.latLng.lng();
				var latlng = new google.maps.LatLng(lat,lng);
				if(i<pointNum){
				pointArr.push(latlng);
				};
				i++;
				if(highLat<event.latLng.lat()) { highLat = event.latLng.lat(); };
				if(lowLat>event.latLng.lat()) { lowLat = event.latLng.lat(); };
				if(highLng<event.latLng.lng()) { highLng = event.latLng.lng(); };
				if(lowLng>event.latLng.lng()) { lowLng = event.latLng.lng(); };
				var polygon = new google.maps.Polygon({
					type:'polygons',
					path: pointArr,
					geodesic: true,
					strokeColor: '#eeaf0f',
					strokeOpacity: 0.5,
					strokeWeight: 2
				});
				globalShape = polygon;
				drawArr.push(polygon);
				for(x in drawArr) { drawArr[x].setMap(null); };
				polygon.setMap(map);
				if(i == pointNum) {
					buildCenter["lat"] = (highLat+lowLat)/2;
					buildCenter["lng"] = (highLng+lowLng)/2;
						polygon.setMap(map);
						polygonActive= false;
						i=0;
						var shapeObj = {
							name:prompt("Name this object."),
							infoWindow:true,
							infoBoxString:prompt("Enter extra info about this object."),
							strokeColor:polygon.strokeColor,
							strokeOpacity:polygon.strokeOpacity,
							strokeWeight:polygon.strokeWeight,
							outline:polygon.latLngs.j[0].j,
							latLngCenter:buildCenter
						}
						var jsonStr = JSON.stringify(shapeObj);
						shapeArr.push(jsonStr);
						console.log(jsonStr);
					}
			}
		if (parkingActive == true) {
			var lat = event.latLng.lat();
			var lng = event.latLng.lng();
			var latlng = new google.maps.LatLng(lat,lng);
			if(i<pointNum){
				if(highLat<event.latLng.lat()) { highLat = event.latLng.lat(); };
				if(lowLat>event.latLng.lat()) { lowLat = event.latLng.lat(); };
				if(highLng<event.latLng.lng()) { highLng = event.latLng.lng(); };
				if(lowLng>event.latLng.lng()) { lowLng = event.latLng.lng(); };
				pointArr.push(latlng);
				};
				i++;
				var polygon = new google.maps.Polygon({
					type:'parking',
					path: pointArr,
					geodesic: true,
					strokeColor: '#eeaf0f',
					strokeOpacity: 0.7,
					strokeWeight: 2
				});
			globalShape = polygon;
			drawArr.push(polygon);
			for(x in drawArr) { drawArr[x].setMap(null); };
			polygon.setMap(map);
			if(i == pointNum) {

					polygon.setMap(map);
					parkingActive= false;
					i=0;
					buildCenter["lat"] = (highLat+lowLat)/2;
					buildCenter["lng"] = (highLng+lowLng)/2;
					var shapeObj = {
						name:polygon.type,
						parkingName:prompt("Give this parking lot a name (e.g., A-1, C, E)"),
						latLngCenter:buildCenter,
						zone:prompt("Is this Zone 1 or Zone 2 parking?\n(Enter 1 or 2)"),
						strokeColor:polygon.strokeColor,
						strokeOpacity:polygon.strokeOpacity,
						strokeWeight:polygon.strokeWeight,
						outline:polygon.latLngs.j[0].j,
						staffParking:true,
						disabledParking:true,
						cycleStalls:false,
						infoWindow:false,
						infoWindowContent:"Done."
					}
					var jsonStr = JSON.stringify(shapeObj);
					shapeArr.push(jsonStr);
					console.log(jsonStr);
				}
			}
		if(buildingActive == true) {
			var lat = event.latLng.lat();
			var lng = event.latLng.lng();
			var latlng = new google.maps.LatLng(lat,lng);
			pointArr.push(latlng);
			i++;
			if(highLat<event.latLng.lat()) { highLat = event.latLng.lat(); };
			if(lowLat>event.latLng.lat()) { lowLat = event.latLng.lat(); };
			if(highLng<event.latLng.lng()) { highLng = event.latLng.lng(); };
			if(lowLng>event.latLng.lng()) { lowLng = event.latLng.lng(); };
			var building = new google.maps.Polygon({
				type:'buildings',
				path: pointArr,
				geodesic: true,
				strokeColor: '#eeaf0f',
				strokeOpacity: 0.5,
				strokeWeight: 2
			});
			drawArr.push(building);
			for(x in drawArr) { drawArr[x].setMap(null); };
			building.setMap(map);
			if(i == pointNum)
			{
				buildCenter["lat"] = (highLat+lowLat)/2;
				buildCenter["lng"] = (highLng+lowLng)/2;
			var shapeObj = {
				buildingName:prompt("Enter name of building"),
				type:building.type,
				strokeColor:building.strokeColor,
				strokeOpacity:building.strokeOpacity,
				strokeWeight:building.strokeWeight,
				outline:building.latLngs.j[0].j,
				center:buildCenter,
			}
			var jsonStr = JSON.stringify(shapeObj);
			console.log(building);
			shapeArr.push(jsonStr);
			console.log(jsonStr);
			building.setMap(map);
			buildingActive = false;
			i = 0;
			}
		}
		if(markerActive == true) {
			var lat = event.latLng.lat();
			var lng = event.latLng.lng();
			var latlng = new google.maps.LatLng(lat,lng);
			var marker = new google.maps.Marker({
				position: latlng,
				type: "marker",
			});
			var infowindow = new google.maps.InfoWindow({ content: prompt("Enter info about this marker if you'd like."),});
			google.maps.event.addListener(marker, 'click', function() {
				infowindow.open(map, marker);
			}); 
			marker.setMap(map);
			//This line logs the type, infoBox, and position properties of all newly added markers
			var shapeObj = {
				type:"pois",
				category:prompt("Categorize this marker."),
				icon:"img/red-circle-big.png",
				latLng:marker.position,
				infoWindow:true,
				picture:" ",
				infoBoxString:infowindow.content,
				infoURL:true,
				infoURLTitle:"This is",
				infoURLLink:"a test.",
			}
			var jsonStr = JSON.stringify(shapeObj);
			shapeArr.push(jsonStr);
			console.log(jsonStr);
		}
		//Resets after making shapes so they don't build on themselves and so one can click the map without making markers
		if((using == true && pointArr.length == pointNum) || markerActive==true || circleActive==true) {
			markerActive = false;
			using = false;
			parkingActive = false;
			polygonActive = false;
			polyLineActive = false;
			buildingActive = false;
			circleActive = false;
			i = 0;
			pointNum = 0;
			//This clears the temporary array of any lat lng data so its fresh for the next item
			pointArr.length = 0;
			//This clears the other temporary array so it doesn't keep drawing things
			drawArr = [];
			//Sets these back to original values so that the centers of all buildings/parking lots aren't averaged together.
			var highLat = 0;
			var lowLat = 100;
			var highLng = -200;
			var lowLng = 200;
			$('#circleForm').hide();
			$('#polylineForm').hide();
			$('#polygonForm').hide();
			$('#markerForm').hide();
			$('#buildingForm').hide();
		}
	});
	
	//Handlers for buttons allowing users to control what they are creating.
	createCircle.onclick = function() {
		circleActive = true;
		alert("Click centerpoint of circle");
		$('#circleForm').show();
		
	};
	createPolyLine.onclick = function() {
		pointNum = parseInt(prompt("Enter number of points on your line:"));
		alert("Now click the points of your line.");
		using = true;
		polyLineActive = true;
		$('#polylineForm').show();
	};
	
	createPolygon.onclick = function () {
		pointNum = parseInt(prompt("Enter number of points on your line:"));
		alert("Now click the points of your line.");
		using = true;
		polygonActive= true;
		$('#polygonForm').show();
	};
	
	createMarker.onclick = function () {
		alert("Click the map to place a marker.");
		markerActive = true;
		$('#markerForm').show();
	};
	
	createBuilding.onclick = function() {
		buildingActive = true;
		using = true;
		pointNum = parseInt(prompt("Enter number of corners on the building:"));
		alert("Now click the corners in a clockwise direction.");
		$('#buildingForm').show();
	};
	createParking.onclick = function() {
		parkingActive = true;
		using = true;
		pointNum = parseInt(prompt("Enter number of corners in the parking lot (reccommended to outline rather than detail the lot)."));
		alert("Click the corners in a clockwise direction.");
	};
	
//jQuery listeners for saving a new layer and updating the one currently selected
$("#save").on('submit',function(e) {
	e.preventDefault();
	console.log(shapeArr);
	$.post("mapAddToDB.php",{data:JSON.stringify(shapeArr)});
});
$("#update").on('submit',function(e) {
	e.preventDefault();
	console.log(shapeArr);
	$.post("mapAddToDB.php",{data:JSON.stringify(shapeArr)});
});

	//Forms for shape customization listeners
	/* Non functional for now.
	$('#polygonForm').on('submit', function(e) {
		e.preventDefault();
		applyStyles();
		alert("Applied!");
	});
	$('#buildingForm').on('submit', function(e) {
		e.preventDefault();
		alert("Applied!");
	});
	$('#polylineForm').on('submit', function(e) {
		e.preventDefault();
		alert("Applied!");
	});
	$('#markerForm').on('submit', function(e) {
		e.preventDefault();
		alert("Applied!");
	});
	$('#circleForm').on('submit', function(e) {
		e.preventDefault();
		applyStyles();
		alert("Applied!");
	});
}*/
function draw(jsonArray, map) {
	for(key in jsonArray){
		for(innerKey in jsonArray[key])
	{
		switch(jsonArray[key][innerKey]['name']) {
			case "circles":
			var circle = new google.maps.Circle ({
			type:'circle',
				strokeColor: jsonArray[key][innerKey]['strokeColor'],
				strokeOpacity: jsonArray[key][innerKey]['strokeOpacity'],
				strokeWeight: jsonArray[key][innerKey]['strokeWeight'],
				fillColor: jsonArray[key][innerKey]['fillColor'],
				fillOpacity: jsonArray[key][innerKey]['fillOpacity'],
				map: map,
				center: jsonArray[key][innerKey]['center'],
				radius: jsonArray[key][innerKey]['radius']
			});
			circle.setMap(map);
			break;
			case "polylines":
			var polyline = new google.maps.Polyline ({
				path:jsonArray[key][innerKey]['latLngArray'],
				strokeColor: jsonArray[key][innerKey]['strokeColor'],
				strokeOpacity: jsonArray[key][innerKey]['strokeOpacity'],
				strokeWeight: jsonArray[key][innerKey]['strokeWeight'],
				fillColor: jsonArray[key][innerKey]['fillColor'],
				fillOpacity: jsonArray[key][innerKey]['fillOpacity'],
				map: map,
			});
			polyline.setMap(map);
			break;
			case "polygons":
			var polygon = new google.maps.Polygon({
					type:'polygon',
					name:jsonArray[key][innerKey]['name'],
					path: jsonArray[key][innerKey]['outline'],
					geodesic: true,
					strokeColor: jsonArray[key][innerKey]['strokeColor'],
					strokeOpacity: jsonArray[key][innerKey]['strokeOpacity'],
					strokeWeight: jsonArray[key][innerKey]['strokeWeight'],
				});
			polygon.setMap(map);
			break;
			case "buildings":
			var building = new google.maps.Polygon({
				type:'building',
				name:jsonArray[key][innerKey]['name'],
				buildingName:jsonArray[key][innerKey]['buildingName'],
				path: jsonArray[key][innerKey]['outline'],
				geodesic: true,
				strokeColor: jsonArray[key][innerKey]['strokeColor'],
				strokeOpacity: jsonArray[key][innerKey]['strokeOpacity'],
				strokeWeight: jsonArray[key][innerKey]['strokeWeight'],
			});
			polygon.setMap(map);
			break;
			case "pois":
			var marker  = new google.maps.Marker ({
				latLng:jsonArray[key][innerKey]['latLng'],
				icon:"img/red-circle-big.png",
				//infoWindow:jsonArray[key][innerKey]['infoWindow'],
				//picture:jsonArray[key][innerKey]['picture'],
				//infoBoxString:jsonArray[key][innerKey]['infoBoxString'],
				//infoURL:jsonArray[key][innerKey]['infoURL'],
				//infoURLTitle:jsonArray[key][innerKey]['infoURLTitle'],
				//infoURLLink:jsonArray[key][innerKey]['infoURLLink'],
			});
			marker.setMap(map);
			break;
			default:
			console.log('Error loading shape ' + innerKey);
			break;
		}
	}
	}
}

$(document).ready(draw(jsonArray,map));
//Sends array of shapes to php file for sql to add to database

};
	//This function checks what shape to edit, and pulls new values for customization from HTML form
	/*function applyStyles () {
		console.log(globalShape);
		switch (globalShape.type )
		{
			case "circle":
			globalShape.setMap(null);
			globalShape.strokeColor = $('#colorVal').val();
			console.log($('#colorVal').val());
			globalShape.fillOpacity = $('#fillOpacity').val();
			globalShape.fillColor = $('#fillColor').val();
			globalShape.strokeWeight = $('#strokeWidth').val();
			globalShape.setMap(map);
			break;
			case "building":
			break;
			case "polygon": 
			globalShape.setMap(null);
			globalShape.strokeColor = $('#colorVal').val();
			console.log($('#colorVal').val);
			globalShape.fillOpacity = $('#fillOpacity').val();
			globalShape.fillColor = $('#fillColor').val();
			globalShape.strokeWeight = $('#strokeWidth').val();
			globalShape.setMap(map);
			break;
			case "polyline":
			break;
		}
	}*/
