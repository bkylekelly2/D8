<?php $siteTitle = 'Study Spaces'; 
require_once $_SERVER['DOCUMENT_ROOT']."/modules/learningspaces/php/Mobile_Detect.php";
//http://mobiledetect.net/
$detect = new Mobile_Detect;
$submit = 'ng-change="submit();"';
// Add non event to mobile devices.
if( $detect->isMobile() && !$detect->isTablet() ){
$submit='';
}

?>
<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.6.1/angular.js"></script>
  <script src="/modules/learningspaces/js/learningspaces-angular.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="/modules/learningspaces/css/gwstyles.css" />
  <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
  <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css"/>
  <link rel="stylesheet" type="text/css" href="/modules/learningspaces/css/slick-lightbox.css"/>
  <link rel="stylesheet" href="/modules/learningspaces/css/learningspaces.css" />
  <link rel="shortcut icon" href="/themes/lai/favicon.ico" type="image/vnd.microsoft.icon" />
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous" />
  <title><?php echo $siteTitle; ?> | GW</title>
  <META HTTP-EQUIV="Pragma" CONTENT="no-cache">
  <META HTTP-EQUIV="Expires" CONTENT="-1">
</head>
<body>

	<p tabindex="-1" id="skip-link">
		<a tabindex="0" href="#main-content" class="element-invisible element-focusable">Skip Navigation</a>
	</p>
	<header class="header" id="header" role="banner">
		<div id="header-wrapper">
			<div class="gwlogo">
				<a href="/" title="<?php echo $siteTitle; ?>" target="_self">
					<img typeof="foaf:Image" src="/modules/learningspaces/images/study-spaces-logo-beta-03.png" alt="GW <?php echo $siteTitle; ?> logo" height="90">
				</a>
				<div id="initiative-of">An initiative of <a href="https://lai.gwu.edu/" target="_blank">Libraries &amp; Academic Innovation</a></div>
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


<div id="page" class="clearfix" ng-app="learningSpaces" ng-controller="learningSpacesCtrl">
<div class="container-fluid" id="main-content">

      <div class="row">

        <div id="spaces-listing" class="col-xs-6 col-md-4">
		<form name="spacesForm" >
		<h1><?php echo $siteTitle; ?></h1>

		<ul id="triggers">
	          <li id="list-trigger" class="selected" tabindex="0">
            	    <i class="fa fa-list"></i> Spaces
	          </li>
	          <li id="filter-trigger" tabindex="0">
	            <i class="fa fa-sliders-h"></i> Filter
          	  </li>
        	  <li id="map-trigger" tabindex="0">
            	    <i class="fa fa-map-marker-alt"></i> Map
	          </li>
      		</ul>

			<div class="filter_division" id="campus">
				<h2>
				Campus
				</h2>
				<div>
				<ul>
					<li>
					<input type="radio" ng-model="campus" name="name_campus" value="433" ng-click="submit_campus()" id="foggy-bottom">
					<label for="foggy-bottom">
					Foggy Bottom
					</label>
					</li>
					<li>
					<input type="radio" ng-model="campus" name="name_campus" value="434" ng-click="submit_campus()" id="mt-vernon">
					<label for="mt-vernon">
					Mount Vernon
					</label>
					</li>
				</ul>
				</div>
			</div>
			<div id="results_count">
				<div ng-cloak>Showing {{showing}} of {{total}} results</div>
			</div>

		<div id="filters-dialog" style="display:none;"></div>
		<div id="room" style="display:none;"></div>
		<div id="noRoom" class="hide">We can&rsquo;t find a study space based on these search parameters. Expand your search by deselecting some filters.</div>
		<div id="rooms">
			<div id="initial-page-loading">We're finding you spaces <img src="/modules/learningspaces/images/loading-01.gif"/></div>
			
		<div ng-repeat="room in rooms track by $index" ng-cloak>
			
			<div class="roomTeaser" data-room-id="{{room.roomID}}"  data-id="{{room.roomID}}" tabindex="0" ng-mouseenter="teaserMouseEnter(room.roomID,true)" ng-focus="teaserMouseEnter(room.roomID)" id="{{room.roomID}}" onmouseleave="angular.element(this).scope().teaserMouseLeave()" onblur="angular.element(this).scope().teaserMouseLeave()">
		   <div class="teaserImage" style="background-image: url({{room.image_url}})"  ><img class="space-image" src="{{room.image_url}}" alt="{{room.image_alt}}"></div>
		   <div class="teaserContents">
		   <div class="teaserTitle"><h2><span class="teaserBuilding">{{room.title_building}}</span> <span class="teaserRoom">{{room.title_room}}</span></h2>
		   <div class="teaserTitleDetails"> {{room.floor}} </div></div>
		   <div class="teaserDetails">
			<div ng-if="room.isReservable" class="teaserReservable">Reservable</div>
           <div><div class="teaserSpaceType">{{room.spaceType}}</div><div class="teaserSeating">{{room.spaceCapacity}}</div></div>
           </div>
		   </div></div>
			
		</div>
			
			
			
			
			
			
		</div>
		<div id="load" ng-cloak><span ng-click="loadMoreResults();" class="reg-button lightblue"><a href="">{{loadMore}}</a></span></div>
		</div>
        <div id="spaces-filters" class="col-xs-6 col-md-4">
		<h2>Filter the spaces</h2>
			<div class="filter_division union" id="space_types">
				<h3 tabindex="0">
				<span class="filter-toggle" title="Collapse this filter">&ndash;</span>
				Type of Space
				</h3>
				<div>
				<ul>
				<?php for ($x = 0; $x <= (count($spaceTypes['nid'])-1); $x++) { 
				$title = $spaceTypes['title'][$x];
				$ngtitle = str_replace(" ","_",$spaceTypes['title'][$x]);
				$nid = $spaceTypes['nid'][$x];
				?>
					<li>
					<input type="checkbox" ng-model="spaceType.<?php echo $ngtitle; ?>" name="name_spaceType" value="<?php echo $nid; ?>" id="<?php echo $nid; ?>" <?php echo $submit; ?> >
					<label for="<?php echo $nid; ?>">
					<?php echo $title; ?>
					</label>
					<div id="<?php echo $ngtitle; ?>"></div>
					</li>
				<?php } ?>
				</ul>
				<div class="filter-explanation">
				<a href="https://acadtech.gwu.edu/classroom-search" target="_blank">Find a classroom instead <i class="fa fa-external-link-alt"></i></a>
				<span class="filter-explanation-tooltip-trigger" tabindex="0" title="Classrooms are not yet listed here, but rather are searchable in the Classroom Finder. Classrooms are generally available as study spaces when a class is not in session.">(huh?)</span>
				</div>
				</div>
			</div>
			
			
			
				
				
			<div class="filter_division union" id="noise_expectations">
				<h3 tabindex="0">
				<span class="filter-toggle" title="Collapse this filter">&ndash;</span>
				Noise Expectation
				</h3>
				<div>
				<ul>
				<?php for ($x = 0; $x <= (count($noiseExpectations['nid'])-1); $x++) { 
				$title = $noiseExpectations['title'][$x];
				$ngtitle = str_replace(" ","_",$noiseExpectations['title'][$x]);
				$nid = $noiseExpectations['nid'][$x];
				?>
					<li>
					<input type="checkbox" ng-model="noiseExpectation.<?php echo $ngtitle; ?>" name="name_noiseExpectation" value="<?php echo $nid; ?>" id="<?php echo $nid; ?>" <?php echo $submit; ?>>
					<label for="<?php echo $nid; ?>">
					<?php echo $title; ?>
					</label>
					<div id="<?php echo $ngtitle; ?>"></div>
					</li>
				<?php } ?>
				</ul>
				</div>
			</div>
			<div class="filter_division intersection" id="amenities">
				<h3 tabindex="0">
				<span class="filter-toggle" title="Collapse this filter">&ndash;</span>
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
					<input type="checkbox" ng-model="amenity.<?php echo $ngtitle; ?>" name="name_amenity" value="<?php echo $nid; ?>" id="<?php echo $nid; ?>" <?php echo $submit; ?>>
					<label for="<?php echo $nid; ?>">
						<img src="<?php echo $Amenities['iconURL'][$x]; ?>" alt="<?php echo $Amenities['iconALT'][$x]; ?>"/>
					<?php echo $title; ?>
					</label>
					<div id="<?php echo $ngtitle; ?>"></div>
					</li>
				<?php } ?>
				</ul>
				</div>
			</div>
			<div class="filter_division intersection" id="technology">
				<h3 tabindex="0">
				<span class="filter-toggle" title="Collapse this filter">&ndash;</span>
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
					<input type="checkbox" ng-model="technology.<?php echo $ngtitle; ?>" name="name_technology" value="<?php echo $nid; ?>" id="<?php echo $nid; ?>" <?php echo $submit; ?>>
					<label for="<?php echo $nid; ?>">
						<img src="<?php echo $Technology['iconURL'][$x]; ?>" alt="<?php echo $Technology['iconALT'][$x]; ?>"/>
					<?php echo $title; ?>
					</label>
					<div id="<?php echo $ngtitle; ?>"></div>
					</li>
					
				<?php } ?>
				</div>
			</div>
				
					
			<div class="filter_division collapsed intersection" id="furniture">
				<h3 tabindex="0">
				<span class="filter-toggle" title="Show this filter">+</span>
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
					<input type="checkbox" ng-model="furniture.<?php echo $ngtitle; ?>" name="name_furniture" value="<?php echo $nid; ?>" id="<?php echo $nid; ?>" <?php echo $submit; ?>>
					<label for="<?php echo $nid; ?>">
						<img src="<?php echo $Furniture['iconURL'][$x]; ?>" alt="<?php echo $Furniture['iconALT'][$x]; ?>"/>
					<?php echo $title; ?>
					</label>
					<div id="<?php echo $ngtitle; ?>"></div>
					</li>
				<?php } ?>
				</div>
			</div>		
				
				
				
			<div class="filter_division collapsed union" id="building"  >
				<h3 tabindex="0">
				<span class="filter-toggle" title="Show this filter">+</span>
				Locations
				</h3>
				<div>
				<ul>
				<li ng-repeat="bF in buildingFilter track by $index">
					<input type="checkbox" ng-model="building[bF.filter]" name="name_building" value="{{bF.buildingID}}" id="{{bF.buildingID}}" ng-click="submit()">
					<label for="{{bF.buildingID}}">
					{{bF.title}}
					</label>
				<div id="{{bF.filter}}"></div>
				</li>
				</ul>
				</div>
			</div>
			
			
			
		</div>
	</form>
        <div id="spaces-map" class="col-xs-6 col-md-4">
		<!-- Need another div around the map so that it can be set to fixed position while #spaces-map above stays in place for the sake of width measurements -->
		<div id="map-wrapper">
			<h2>Map of the spaces</h2>
			<div id="map"></div>
		</div>
	</div>
      </div>
</div>

<div class="panel-pane pane-views-panes pane-local-footer-gwtoday-footer-panel-pane">
  <div class="view view-local-footer view-id-local_footer view-display-id-gwtoday_footer_panel_pane">
    <div class="view-content">
      <div class="views-row views-row-1 views-row-odd views-row-first views-row-last">
        <div id="gwtoday-local-footer">
          <div id="gwtoday-footer">
 	    <div class="promotional-four-col">
              <div class="footer-logo" id="promo-item-1">
                <div class="field field-name-field-gwtoday-logo field-type-text-long field-label-hidden">
                  <div class="field-items">
                    <div class="field-item even">
                      <p><img alt="" src="/modules/learningspaces/images/gw_iddol_libraries_2c-220.png" style="width: 220px; height: 45px;"></p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="footer-address" id="promo-item-2">
                <div class="field field-name-field-gwtoday-address field-type-text-long field-label-hidden">
                  <div class="field-items">
                    <div class="field-item even">
                      <div>Gelman Library</div>
                      <div>2130 H Street, NW</div>
                      <div>Washington, DC 20052</div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="footer-social-links" id="promo-item-3">
                <div class="field field-name-field-gwtoday-social-links field-type-text-long field-label-hidden">
                  <div class="field-items">
                    <div class="field-item even">
                      <p>202-994-6558</p>
                      <p><a href="mailto:gelman@gwu.edu">gelman@gwu.edu</a></p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="footer-quick-links" id="promo-item-4">
                <div class="field field-name-field-gwtoday-quick-links field-type-text-long field-label-hidden">
                  <div class="field-items">
                    <div class="field-item even">
                      <a href="/about">About <?php echo $siteTitle; ?></a>
                      <br/>
                      <a href="/contact">Contact Us</a>
                      <br/>
                      <a href="/user">Staff Login</a>
                      <br/>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
<footer id="footer" class="region region-footer">
<div id="footer-wrapper">
    <div class="footer-logof">
        <a rel="home" href="https://www.gwu.edu/" target="_blank">
        <img typeof="foaf:Image" src="/modules/learningspaces/images/gw_txh_2cs_rev.png" alt="GW logo" width="300" height="42">
        </a>
    </div>
    <div class="row-one">
        <ul>
            <li>
                <a href="http://www.campusadvisories.gwu.edu" target="_blank">Campus Advisories</a>
            </li>
            <li>
                <a href="http://my.gwu.edu/files/policies/EqualEmploymentOpportunityStatement.pdf" target="_blank">Non-Discrimination Policy</a>
            </li>
            <li>
                <a href="https://www.gwu.edu/privacy-policy" target="_blank">Privacy Policy</a>
            </li>

        </ul>
    </div>
    <div class="row-two">
        <ul>
            <li>
                <a href="https://www.gwu.edu/contact-gw" target="_blank">Contact GW</a>
            </li>
            <li>
                <a href="https://www.gwu.edu/terms-use" target="_blank">Terms of Use</a>
            </li>
            <li>
                <a href="https://www.gwu.edu/copyright" target="_blank">Copyright</a>
            </li>
            <li>
                <a href="https://www.gwu.edu/az-index" target="_blank">A-Z Index</a>
            </li>
        </ul>
    </div>
</div>
</footer>


<script src="/modules/learningspaces/js/jquery2.js"></script>
<!-- Mean menu is what converts the full-size horizontal navbar to a hamburger-style menu in smaller screens. -->
<script src="/modules/learningspaces/js/meanmenu.js"></script>
<script type="text/javascript">
  jQuery(document).ready(function () {
    jQuery('nav').meanmenu({"meanScreenWidth":"599","menuText":"GW <?php echo $siteTitle; ?>"});
  });
</script>
<script>
// prevent jQuery Mobile from disabling in-page links
jQuery(document).ready(function() {
  jQuery("a").each(function () {
    if (this.getAttribute("href").charAt(0) == "#") {
      jQuery(this).attr("data-ajax",false);
    }
  });
});
// prevent jQuery Mobile from rearranging the markup around filter inputs
jQuery(document).bind('mobileinit',function(){
  jQuery.mobile.keepNative = ".filter_division input";
});
</script>
	  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="/modules/learningspaces/js/jquery-ui.min.js"></script>
	<script src="/modules/learningspaces/js/javascript_scripts.js"></script>
	<script src="/modules/learningspaces/js/jquery_scripts.js"></script>
	<script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
	<script src="/modules/learningspaces/js/slick-lightbox.js"></script>
	<script defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAURI1nEFFuHJwkubm0_tDU9bcMXuHJ0qw"></script>
</body>
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<META HTTP-EQUIV="Expires" CONTENT="-1">
</html>
