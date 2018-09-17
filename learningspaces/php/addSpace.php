<?php 
if ($_GET['nodeID']<>''){
	$pageTitle = '<h3>Edit Space</h3>';
	$siteTitle = 'Study Spaces - Edit Space ';
} else {
		$pageTitle = '<h3>Create Space</h3>';
		$siteTitle = 'Study Spaces - Create Space ';	
}
	$nodeID = $_GET['nodeID'];
	if ($nodeID<>''){
		$room = \Drupal::entityTypeManager()->getStorage('node')->load($nodeID);
		$campus = $room->field_campus_reference->getValue()[0]['target_id'];
		$building = $room->field_building_reference->getValue()[0]['target_id'];
		$title = $room->getTitle();

		if (!empty($room->field_floor) && (isset($room->field_floor->getValue()[0]))){
			$floor = $room->field_floor->getValue()[0]['value'];
		}

		if (!empty($room->field_capacity)){
			$capacity = $room->field_capacity->getValue()[0]['value'];
		}

		if (!empty($room->field_interior_location)){
			$interior = $room->field_interior_location->getValue()[0]['value'];
		}

		if (!empty($room->field_notes)){
			$notes = $room->field_notes->getValue()[0]['value'];
		}

	}

if ($nodeID<>''){
	$pageStatus = $room->isPublished();

	if ($pageStatus==1){
		$spacePublish = 'checked';
	} else{
		$spacePublish='';
	}
		
}

?>
<?php include($_SERVER['DOCUMENT_ROOT']."/modules/learningspaces/php/header.php");?>
<script src="/modules/learningspaces/js/addSpace-angular.js"></script>
<script src="/modules/learningspaces/js/dynamicFields.js"></script>

<style>
.ng-invalid {
    border: 1px solid red;
}
</style>
<div ng-app="addSpace" ng-controller="addSpaceCtrl"> <!--outer-->

	<p tabindex="-1" id="skip-link">
		<a tabindex="0" href="#main-content" class="element-invisible element-focusable">Skip Navigation</a>
	</p>
	<header class="header" id="header" role="banner">
		<div id="header-wrapper">
			<div class="gwlogo">
				<a href="/" title="<?php echo $siteTitle; ?>" target="_self">
					<img typeof="foaf:Image" src="/modules/learningspaces/images/study-spaces-logo-03.png" alt="GW <?php echo $siteTitle; ?> logo" height="90">
				</a>
				<div id="division-of">A division of <a href="https://lai.gwu.edu/" target="_blank">Libraries &amp; Academic Innovation</a></div>
			</div>
		</div>
	</header>

	<div class="region region-navigation clearfix">
		<div id="nav-bar" aria-hidden="false" class="fadeInDown animated unsticky">
		<div id="nav-bar-wrapper">
		    <div id="stickyLogo">
		        <a href="/" title="<?php echo $siteTitle; ?> home" target="_self"><img id="monogramLogo" src="/modules/learningspaces/images/gw_mono.png" alt="GW"/></a>
		    </div>
	    <div id="navigation" role="navigation" class="responsive-menus-mean-menu-processed" style="display: block;">
	      <nav id="main-nav" style="display: block;">
        	<ul class="nice-menu nice-menu-down nice-menu-menu-division-menu nice-menus-processed sf-js-enabled sf-arrows" id="nice-menu-2">
	        <li class="menu__item menu-741 menuparent  menu-path-node-9 first odd">
			<a href="/about" class="menu__link sf-with-div">About</a>
		</li>
	        <li class="menu__item menu-741 menuparent  menu-path-node-9 first odd">
			<a href="https://acadtech.gwu.edu/classroom-search" class="menu__link sf-with-div" target="_blank">Classroom Finder <i class="fa fa-external-link-alt"></i></a>
		</li>
		<li class="menu__item menu-745 menu-path-node-45  odd ">
			<a href="/contact" class="menu__link">Contact</a>
		</li>
		</ul>
	      </nav>
	    </div>
	  </div></div>
</div>



<div class="container-fluid" id="main-content"><!--container-->

  <div class="row"><!--row-->
    <div class="col-lg-6 col-lg-offset-3 float-center"><!--col-->
	<div class="float-left" style=" border:1px solid #000;"><!--float-->
		<div id="formWrapper">
			<label for="addSpacesForm"><?php echo $pageTitle; ?></label>
		
			<div id="errors">
			<?php if ($_GET['errors']){
			echo $_GET['errors'];
			} ?>
			</div>
		
			<form name="addSpaceForm" id="addSpaceForm" enctype="multipart/form-data" method="post" action="/process" >
			
			<div id="title">
				<h3 tabindex="0">
				Title
				</h3>
				<input type="text" name="title" id="title" value="<?php echo $title; ?>"   >
				<span id="errortitle" class="error">Title is required.</span>
				<P class="helper_text">Helper Text</P>
			</div>
			<div id="campus">
				<h3 tabindex="0">
				Campus
				</h3>
				<select ng-change="submit_campus()" data-id="selectCampus" name="campus" ng-model="campus">
				<option></option>
				<?php for ($x = 0; $x <= (count($Campus['nid'])-1); $x++) { 
				$title = $Campus['title'][$x];
				$nid = $Campus['nid'][$x];
				if ($campusID==$nid){
					$selected = 'selected="selected"';
				}
				?>
				<option value="<?php echo $nid; ?>" <?php echo $selected; ?> ><?php echo $title; ?></option>
				<?php } ?>
				</select>
				<span id="errorCampus" class="error">Campus is required.</span>
				<P class="helper_text">Helper Text</P>
			</div>
			
			
				
			<div id="building"  >
				<h3 tabindex="0">
				Building
				</h3>
				<div>
				<select  id="selectBuilding" name="building" >
				<option></option>
				<option ng-repeat="bF in buildingFilter track by $index" value="{{bF.buildingID}}" >
					{{bF.title}}
				</option>
				</select>
				<span id="errorBuilding" class="error">Building is required.</span>
			</div>
				
			<BR>
				
			<div><label for="room_number">Room Number/Name</label>
			<input type="text" name="field_room_number" data-id="room_number"  >
			<P class="helper_text">Helper Text</P>
			</div>
			
			<div><label for="field_floor">Floor</label>
			<input type="text" name="field_floor" data-id="floor"  >
				<P class="helper_text">Helper Text</P>
			</div>
			
			<div><label for="field_seating_capacity">Seating Capacity</label>
			<input type="number" min="1" name="inputCapacity" id="inputCapacity" >
			<span id="errorCapacity" class="error">Seating capacity is required.</span>
				<P class="helper_text">Helper Text</P>
			</div>
			
						
			<div id="access_type">
				<h3 tabindex="0">
				Access Type
				</h3>
				<select  data-id="accessType" id="accessType" name="accessType"  >
				<option></option>
				<?php for ($x = 0; $x <= (count($AccessType['nid'])-1); $x++) { 
				$title = $AccessType['title'][$x];
				$ngtitle = str_replace(" ","_",$AccessType['title'][$x]);
				$nid = $AccessType['nid'][$x];
				?>
				<option value="<?php echo $nid; ?>"><?php echo $title; ?></option>
				<?php } ?>
				</select>
				<span id="errorAccessType" class="error">Access Type is required.</span>
				<P class="helper_text">Helper Text</P>
			</div>
					
					
			<div id="study_types">
				<h3 tabindex="0">
				Type of Space
				</h3>
				<select  data-id="selectStudyType" name="selectStudyType" id="selectStudyType"  >
				<option></option>
				<?php for ($x = 0; $x <= (count($studyTypes['nid'])-1); $x++) { 
				$title = $studyTypes['title'][$x];
				$ngtitle = str_replace(" ","_",$studyTypes['title'][$x]);
				$nid = $studyTypes['nid'][$x];
				?>
				<option value="<?php echo $nid; ?>"><?php echo $title; ?></option>
				<?php } ?>
				</select>
			</div>
				<span id="errorSpaceType" class="error">Type of Space is required.</span>
				<P class="helper_text">Helper Text</P>
		
					
					
			<div id="space_types">
				<h3 tabindex="0">
				Type of Study Space
				</h3>
				<select  data-id="selectSpaceType" id="selectSpaceType" name="selectSpaceType"  >
				<option></option>
				<?php for ($x = 0; $x <= (count($spaceTypes['nid'])-1); $x++) { 
				$title = $spaceTypes['title'][$x];
				$ngtitle = str_replace(" ","_",$spaceTypes['title'][$x]);
				$nid = $spaceTypes['nid'][$x];
				?>
				<option value="<?php echo $nid; ?>"><?php echo $title; ?></option>
				<?php } ?>
				</select>
			</div>
				<span id="errorStudyType" class="error">Type of Study Space is required.</span>
				<P class="helper_text">Helper Text</P>
			
					
					
			<div id="noise_expectations">
				<h3 tabindex="0">
				Noise Expectation
				</h3>
				<select data-id="selectNoiseExpectation"  >
				<?php $count = count($noiseExpectations['nid'])-1; 
				for ($x = 0; $x <= ($count); $x++) { 
				$title = $noiseExpectations['title'][$x];
				$ngtitle = str_replace(" ","_",$noiseExpectations['title'][$x]);
				$nid = $noiseExpectations['nid'][$x];
				?>
				<option value="<?php echo $nid; ?>" ><?php echo $title; ?></option>
				<?php } ?>
				</select>
			</div>
				<span id="errorNoiseExpectation" class="error">Noise Expectation is required.</span>
				<P class="helper_text">Helper Text</P>
					
			<div class="filter_division intersection" id="amenities" >
				<h3 tabindex="0">
				Amenities
				</h3>
				<div>
					<ul>
				<?php for ($x = 0; $x <= (count($Amenities['nid'])-1); $x++) { 
				$title = $Amenities['title'][$x];
				$ngtitle = str_replace(" ","_",$Amenities['title'][$x]);
				$nid = $Amenities['nid'][$x];
				?>
					<li>
					<input type="checkbox" name="name_amenity" value="<?php echo $nid; ?>" id="<?php echo $nid; ?>" data-id="inputAmenities[]">
					<label for="<?php echo $nid; ?>">
					<?php echo $title; ?>
					</label>
					</li>
				<?php } ?>
			    </ul>
				</div>
				<P class="helper_text">Helper Text</P>
			</div>
			
			<div><label for="field_reservation_information">Reservation Information</label>
			<input type="text" name="field_reservation_information" id="field_reservation_information" >
				<P class="helper_text">Helper Text</P>
			</div>
			
			
			<div class="filter_division collapsed intersection" id="furniture">
				<h3 tabindex="0">

				Furniture
				</h3>
				<div>
				<ul>
				<?php for ($x = 0; $x <= (count($Furniture['nid'])-1); $x++) { 
				$title = $Furniture['title'][$x];
				$ngtitle = str_replace(" ","_",$Furniture['title'][$x]);
				$nid = $Furniture['nid'][$x];
				?>
					<li>
					<input type="checkbox" name="name_furniture" value="<?php echo $nid; ?>" id="<?php echo $nid; ?>" data-id="inputFurniture[]">
					<label for="<?php echo $nid; ?>">
					<?php echo $title; ?>
					</label>
					</li>
				<?php } ?>
				</div>
				<P class="helper_text">Helper Text</P>
			</div>		

				
		<div class="filter_division collapsed intersection" id="technology">
				<h3 tabindex="0">
				Technology and Equipment
				</h3>
				<div>
				<ul>
				<?php for ($x = 0; $x <= (count($Technology['nid'])-1); $x++) { 
				$title = $Technology['title'][$x];
				$ngtitle = str_replace(" ","_",$Technology['title'][$x]);
				$nid = $Technology['nid'][$x];
				?>
					<li>
					<input type="checkbox" name="name_technology" value="<?php echo $nid; ?>" id="<?php echo $nid; ?>" data-id="inputTechnology[]">
					<label for="<?php echo $nid; ?>">
					<?php echo $title; ?>
					</label>
					</li>
				<?php } ?>
				</div>
			<P class="helper_text">Helper Text</P>
			</div>		
				
			
			<div id="image">
				<h3 tabindex="0">
				Image
				</h3>
				<input type="file" name="image[]" accept="image/*" id="image[]">
				<span id="errorImage" class="error">Image is required.</span>
				<div class="container1">
				<button class="add_form_field">Add Image <span style="font-size:16px; font-weight:bold;">+ </span></button>
				</div>		
				<P class="helper_text">Helper Text</P>
			</div>
			
			<div><label for="field_interior">Interior Description</label>
				<textarea name="field_interior" id="field_interior" ng-model="interior" data-ck-editor data-id="inputInterior"></textarea>
				<P class="helper_text">Helper Text</P>
			</div>
			
			<div><label for="field_notes">Notes</label>
				<textarea name="field_notes" id="field_notes" ng-model="notes" data-ck-editor data-id="inputNotes"></textarea>
				<P class="helper_text">Helper Text</P>
			</div>	
			
		<div class="space_publish" id="div_space_publish" >
		<fieldset>
		<div class="spacePublish" style="border:1px solid #ededed; margin-top:10px;margin-bottom:10px;">
		Publish: <input type="checkbox" class="spacePublish" name="spacepublish" value="1" <?php echo $spacePublish; ?>>
			 
		</div>
		</fieldset>
		</div>
			<div><button ng-click="submit()">Submit</button></div>
		</form>
		
	</div><!--float-->
	</div><!--col-->
  </div>  <!--row-->
	
</div><!--container-->
			
</div><!--outer-->


<?php include($_SERVER['DOCUMENT_ROOT']."/modules/learningspaces/php/footer.php");?>
