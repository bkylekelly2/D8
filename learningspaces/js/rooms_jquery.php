// JavaScript Document	
jQuery( document ).ready(function() {
"use strict";

do_ajax();


	
	
jQuery('#workTypeItems li').click(function(){
	
if(jQuery(this).hasClass('highlighted')){
	
	jQuery(this).removeClass('highlighted');
	jQuery( "form[name='spacesForm'] #input_workType" ).val("");

} else {
	
	jQuery(this).addClass('highlighted').siblings().removeClass('highlighted');
	 var $this = jQuery(this).data().id;
	 jQuery( "form[name='spacesForm'] #input_workType" ).val($this);
	
}

do_ajax();
});

jQuery('#noiseLevelsItems li').click(function(){
	
if(jQuery(this).hasClass('highlighted')){
	
	jQuery(this).removeClass('highlighted');
	jQuery( "form[name='spacesForm'] #input_noiseLevels" ).val("");

} else {
	
	jQuery(this).addClass('highlighted').siblings().removeClass('highlighted');
	 var $this = jQuery(this).data().id;
	 jQuery( "form[name='spacesForm'] #input_noiseLevels" ).val($this);
}

do_ajax();
});

jQuery('#campusItems li').click(function(){
	
if(jQuery(this).hasClass('highlighted')){
	
	jQuery(this).removeClass('highlighted');
	jQuery( "form[name='spacesForm'] #input_campus" ).val("");

} else {
	
	jQuery(this).addClass('highlighted').siblings().removeClass('highlighted');
	 var $this = jQuery(this).data().id;
	 jQuery( "form[name='spacesForm'] #input_campus" ).val($this);
	
}

do_ajax();
});

jQuery('#facilitiesItems li').click(function(){
	
var thisValue = jQuery(this).data().id;
var formInput = jQuery( "form[name='spacesForm'] #input_facilities" );
	
if(jQuery(this).hasClass('highlighted')){
	
	jQuery(this).removeClass('highlighted');

	var newValue = removeValue(formInput.val(), thisValue);
	
	formInput.val(newValue);


} else {
	
	jQuery(this).addClass('highlighted');
	
	if (formInput.val()===""){
		formInput.val( formInput.val() +  thisValue );	
	} else {
		formInput.val( formInput.val() +  "," + thisValue );		
	}
	

	formInput.val(formInput.val());
	
}

do_ajax();
});
	
	
///////////////////////////////////////////////////////
	
function removeValue(list, value) {
  return list.replace(new RegExp(",?" + value + ",?"), function(match) {
      var first_comma = match.charAt(0) === ',',
          second_comma;

      if (first_comma &&
          (second_comma = match.charAt(match.length - 1) === ',')) {
        return ',';
      }
      return '';
    });
}
	
function do_ajax(){

var formData = jQuery( "form[name='spacesForm']" );
var campus = jQuery( "form[name='spacesForm'] #input_campus" ).val();
var workType = jQuery( "form[name='spacesForm'] #input_workType" ).val();
var noiseLevels = jQuery( "form[name='spacesForm'] #input_noiseLevels" ).val();
var facilities = jQuery( "form[name='spacesForm'] #input_facilities" ).val();
var limit = jQuery( "form[name='spacesForm'] #input_limit" ).val();

jQuery.ajax({
  async:true,
  type: "POST",
  url: "/learningspaces/get_rooms",
  data:formData.serializeArray(),
  cache: false,
  success: function(data){
     jQuery("#results").html(data);
  }
});
jQuery.ajax({
  async:true,
  type: "POST",
//dataType: 'json',
  url: "/learningspaces/get_buildings",
  data:formData.serializeArray(),
  cache: false,
  success: function(json){
	var centerLattitude = '';
	var centerLongitude = '';
	  
	switch(campus){

			case '432': //viginia campus
				centerLattitude = '';
				centerLongitude = '';
				break;

			case '433': //foggy bottom
				centerLattitude = 38.8991785;
				centerLongitude = -77.0484407;
				break;

			case '434':  //mount vernon
				centerLattitude = 38.9178832;
				centerLongitude = -77.0934827;
				break;
			default:
				centerLattitude = 38.8991785;
				centerLongitude = -77.0484407;
				break;
	}
	
        var myLatlng = new google.maps.LatLng(centerLattitude, centerLongitude);
        var mapOptions = {
            zoom: 16,
            center: myLatlng
        };
        var map = new google.maps.Map(document.getElementById('map'), mapOptions);
	 
//console.log(json);
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		jQuery.each(jQuery.parseJSON(json), function (item, value) {
			jQuery.each(value, function (item2, value2) {
				var marker = new google.maps.Marker({
					position: new google.maps.LatLng(parseFloat(value2.lattitude), parseFloat(value2.longitude)),
					map: map,
					title: value2.title_building
				});
				var attachment = '<div style="width:auto;height:auto;background-color:#ededed;color:#fff; overflow-y: scroll;">';
				jQuery.ajax({
					async:true,
					type: "POST",
					url: "/learningspaces/get_roomslist",
					data:{input_buildingID: value2.buildingID,input_campus: campus,input_workType: workType,input_facilities: facilities,input_noiseLevels: noiseLevels,input_limit: limit},
					cache: false,
					success: function(more){
					//console.log(more);
					jQuery.each(JSON.parse(more), function(ii, obj) {
					//console.log(obj2);
					attachment = attachment +'<div onClick="getRoom('+obj.roomID+')" style="cursor:pointer;">'+obj.title+'</div>';
					});
					attachList(marker, attachment);
					}
				});
				attachment = attachment + '</div>';
			});
		});
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



  
  
  }
	
	
});
	
}
	
function attachList(marker, attachment) {
        var infowindow = new google.maps.InfoWindow({
          content: attachment
        });

        marker.addListener('click', function() {
          infowindow.open(marker.get('map'), marker);
        });
      }


});
