<?php
$wt = \Drupal::config('field.storage.node.field_work_type')->get();
$f = \Drupal::config('field.storage.node.field_facilities')->get();
$nl = \Drupal::config('field.storage.node.field_noise_level')->get();
$c = \Drupal::config('field.storage.node.field_campus')->get();
	
$workTypeValues = $wt['settings']['allowed_values'];
$workTypeCount = count($workTypeValues);	


$facilitiesValues = $f['settings']['allowed_values'];
$facilitiesCount = count($facilitiesValues);	

//ng-model="$parent.facilities[facility.name]" name="name_facilities" ng-true-value="'{{facility.value}}'" ng-false-value="''"
$noiseLevelValues = $nl['settings']['allowed_values'];
$noiseLevelCount = count($noiseLevelValues);	


?>
<!DOCTYPE html>
<html lang="en" ng-app="learningSpaces" ng-controller="learningSpacesCtrl">
<head>
  <title>Learning Spaces | GWU</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
<script src="//ajax.googleapis.com/ajax/libs/angularjs/1.6.1/angular.js"></script>
<script src="/modules/learningspaces/js/learningspaces.js"></script>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
	<script>
	 function closeRoom() {
		document.getElementById('room').style.display = 'none';		
		document.getElementById('rooms').style.display = 'block';
	}
</script>
  <link rel="shortcut icon" href="/themes/lai/favicon.ico" type="image/vnd.microsoft.icon" />
    <style>
       #map {
        height: 100vh;
        width: 100%;
       }
    </style>
	</head>
<div class="container-fluid">

      <div class="row">
        <div class="col-xs-6 col-md-4" >
<form name="spacesForm" >
<input type="hidden" name="name_limit" ng-model="model_limit" value="35">
			<div class="field_block">
				<h3 id="campus" style="border:1px solid #000;background-color:#e5e5e5;">
				Campus
				</h3>
				<div>
				<input type="radio" ng-model="campus" name="name_campus" value="433" ng-click="submit()"> Foggy Bottom<br>
				<input type="radio" ng-model="campus" name="name_campus" value="434" ng-click="submit()"> Mount Vernon<br>
				</div>
			</div>
			<div class="field_block">
				<h3 id="work_types" style="border:1px solid #000;background-color:#e5e5e5;">
				I want to work...
				</h3>
				<div>
				<?php 
				for ($x = 0; $x <= ($workTypeCount-1); $x++) { ?>
				<input type="checkbox" ng-model="workType.<?php echo $workTypeValues[$x]['value']; ?>" name="name_workType" value="<?php echo $workTypeValues[$x]['value']; ?>" id="<?php echo $workTypeValues[$x]['value']; ?>" ng-click="submit();">
				<?php echo $workTypeValues[$x]['label']; ?> <br>
				<?php } ?>
				</div>
			</div>
			<div class="field_block">
				<h3 id="noiseLevel" style="border:1px solid #000;background-color:#e5e5e5;">
				Noise Level
				</h3>
				<div>

				<?php for ($x = 0; $x <= ($noiseLevelCount-1); $x++) { ?>
					<input type="checkbox" ng-model="noiseLevel.<?php echo $noiseLevelValues[$x]['value']; ?>" name="name_noiseLevel" value="<?php echo $noiseLevelValues[$x]['value']; ?>" ng-click="submit()">
					<?php echo $noiseLevelValues[$x]['label']; ?><br>
				<?php } ?>
				</div>
			</div>
			<div class="field_block">
				<h3 id="facilities" style="border:1px solid #000;background-color:#e5e5e5;">
				Facilities
				</h3>
				<div>
				<?php
					for ($x = 0; $x <= ($facilitiesCount-1); $x++) { ?>
					<input type="checkbox" ng-model="facilities.<?php echo $facilitiesValues[$x]['value']; ?>" value="<?php echo $facilitiesValues[$x]['value']; ?>" 
				    ng-click="submit()" ><?php echo $facilitiesValues[$x]['label']; ?><br>
				<?php } ?>
				</div>
			</div>
		</div>
        <div class="col-xs-6 col-md-4">
		<div id="room" style="display:none;position:relative;top:0px;left:0px;height:100vh;width:100vw;background-color:000;">

</div>
			<div id="rooms">
			<p><ul>
			  <li ng-repeat="room in rooms track by $index" >
				<a href="#" id="{{room.roomID}}" data-ng-click="getRoom($event)" >{{ room.title }}</a>
			  </li>
			</ul>
			</p>
			</div>
			
		</div>
        <div class="col-xs-6 col-md-4"><div id="map"></div></div>
		<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAURI1nEFFuHJwkubm0_tDU9bcMXuHJ0qw"></script>
      </div>

</div>

<input type="hidden" ng-model="limit" ng-name="limit" value="35">
<button ng-click="submit();">Submit</button>
</form>



</body>
</html>
