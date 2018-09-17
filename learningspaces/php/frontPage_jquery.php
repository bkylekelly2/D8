<?php
$wt = \Drupal::config('field.storage.node.field_work_type')->get();
$f = \Drupal::config('field.storage.node.field_facilities')->get();
$nl = \Drupal::config('field.storage.node.field_noise_levels')->get();
$c = \Drupal::config('field.storage.node.field_campus')->get();
	
$typeValues = $wt['settings']['allowed_values'];
$typesCount = count($typeValues);	
for ($x = 0; $x <= ($typesCount-1); $x++) {
$workTypes .= '<li class="Class_filter" data-id="'.$typeValues[$x]['value'].'">'.$typeValues[$x]['label'].'</li>';
}

$facilitiesValues = $f['settings']['allowed_values'];
$facilitiesValuesCount = count($facilitiesValues);	
for ($x = 0; $x <= ($facilitiesValuesCount-1); $x++) {
$facilities .= '<li class="Class_filter"  data-id="'.$facilitiesValues[$x]['value'].'">'.$facilitiesValues[$x]['label'].'</li>';
}

$noiseLevelsValues = $nl['settings']['allowed_values'];
$noiseLevelsCount = count($noiseLevelsValues);	
for ($x = 0; $x <= ($noiseLevelsCount-1); $x++) {
$noiseLevels .= '<li class="Class_filter"  data-id="'.$noiseLevelsValues[$x]['value'].'">'.$noiseLevelsValues[$x]['label'].'</li>';
}

	
//$campuses .= '<li class="Class_filter"  data-id="432">Virginia Campus</li>';
$campuses .= '<li class="Class_filter highlighted"  data-id="433">Foggy Bottom</li>';
$campuses .= '<li class="Class_filter"  data-id="434">Mount Vernon</li>';


	
$output = <<<EOHTML
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Learning Spaces | GWU</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="/modules/learningspaces/js/rooms.js"></script>
  <link rel="shortcut icon" href="/themes/lai/favicon.ico" type="image/vnd.microsoft.icon" />
 <style>
 .highlighted{
	background-color:aliceblue;
}

.Class_filter{
	border: 1px solid #e5e5e5;
}
</style>
    <style>
       #map {
        height: 100vh;
        width: 100%;
       }
    </style>
<script>
	function getRoom(roomID){
//	alert(roomID);
	jQuery.ajax({
	async:true,
	type: "POST",
	url: "/learningspaces/get_room",
  	data:{roomID: roomID},
	cache: false,
	success: function(data){
		jQuery("#modal").html(data);
		jQuery("#results").hide();
		jQuery("#modal").show();
	}
	});
	
	
	
}
function closeModal(){
	jQuery("#modal").hide();	
	jQuery("#results").show();
}

</script>
</head>
<div class="container-fluid">
      <div class="row">
        <div class="col-xs-6 col-md-4">
			<div class="field_block">
				<h3 id="campus" style="border:1px solid #000;background-color:#e5e5e5;">
				Campus
				</h3>
				<ul id="campusItems" style="">
					$campuses
				</ul>
			</div>
			<div class="field_block">
				<h3 id="work_types" style="border:1px solid #000;background-color:#e5e5e5;">
				I want to work...
				</h3>
				<ul id="workTypeItems" style="">
					$workTypes
				</ul>
			</div>
			<div class="field_block">
				<h3 id="noiseLevels" style="border:1px solid #000;background-color:#e5e5e5;">
				Noise Levels
				</h3>
				<ul id="noiseLevelsItems" style="">
					$noiseLevels
				</ul>
			</div>
			<div class="field_block">
				<h3 id="facilities" style="border:1px solid #000;background-color:#e5e5e5;">
				Facilities
				</h3>
				<ul id="facilitiesItems" style="">
					$facilities
				</ul>
			</div>
		</div>
        <div class="col-xs-6 col-md-4"><div id="results"></div><div id="modal" style="display:none;position:relative;top:0px;left:0px;height:100vh;width:100vw;background-color:000;"></div></div>
        <div class="col-xs-6 col-md-4"><div id="map"></div></div>
		<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAURI1nEFFuHJwkubm0_tDU9bcMXuHJ0qw"></script>
      </div>
</div>

<form name="spacesForm" id="spacesForm" method="post">
  <input type="hidden" value="" name="input_workType" id="input_workType">
  <input type="hidden" value="" name="input_noiseLevels" id="input_noiseLevels">
  <input type="hidden" value="" name="input_facilities" id="input_facilities">
  <input type="hidden" value="433" name="input_campus" id="input_campus">
  <input type="hidden" value="35" name="input_limit" id="input_limit">
</form>	




</body>
</html>
EOHTML;


?>
