jQuery( document ).ready(function() {
  "use strict";

  jQuery('#clickme').click(function(){

alert('kyle');
  });


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

  }

});