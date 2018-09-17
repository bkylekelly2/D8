// JavaScript Document	
jQuery( document ).ready(function() {
"use strict";

//set error messages to hide by default
jQuery('.error').hide();
	
var max_fields      = 10;
var wrapper         = $(".container1");
var add_button      = $(".add_form_field");

var x = 1;
jQuery(add_button).click(function(e){
	e.preventDefault();
	if(x < max_fields){
		x++;
		$(wrapper).prepend('<div style="padding-top:1em;"><input type="file" name="image[]" id="image[]" accept="image/*" ><a href="#" class="delete">Delete</a></div>'); //add input box
	}
else {
alert('You Reached the limits');
}
});

jQuery(wrapper).on("click",".delete", function(e){
	e.preventDefault(); $(this).parent('div').remove(); x--;
});
	

});