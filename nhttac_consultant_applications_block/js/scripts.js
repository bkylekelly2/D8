jQuery( document ).ready(function() {
  "use strict";

var postData = '';
var query = '';
var sort = '';
do_ajax(postData);



 // jQuery('#status_asc').click(function(){
  //  postData='{ query : \'1\' }';
 //   alert(postData);
    //do_ajax(postData);
 // });

  jQuery('body').on('click', '#status', function() {
    if (jQuery('#status').hasClass("ASC")){
      query = "status";
      sort = 'ASC';
    }
    if (jQuery('#status').hasClass("DESC")){
      query = "status";
      sort = 'DESC';
    }
    do_ajax(query,sort);
  });


  jQuery('body').on('click', '#active', function() {
    if (jQuery('#active').hasClass("ASC")){
      query = "active";
      sort = 'ASC';
    }
    if (jQuery('#active').hasClass("DESC")){
      query = "active";
      sort = 'DESC';
    }
    do_ajax(query,sort);
  });


  jQuery('body').on('click', '#title', function() {
    if (jQuery('#title').hasClass("ASC")){
     query = "title";
      sort = 'ASC';
    }
    if (jQuery('#title').hasClass("DESC")){
      query = "title";
      sort = 'DESC';
    }
    do_ajax(query,sort);
  });


  jQuery('body').on('click', '#location', function() {
    if (jQuery('#location').hasClass("ASC")) {
      query = "location";
      sort = 'ASC';
    }
    if (jQuery('#location').hasClass("DESC")){
      query = "location";
      sort = 'DESC';
    }
    do_ajax(query,sort);
  });

  function do_ajax(postQuery,postSort){

    jQuery.ajax({
      async:true,
      type: "POST",
      url: "/nhttac/applications",
      data:{ query: postQuery, sort: postSort  },
      cache: false,
      success: function(data){
        jQuery("#results").html(data);
      }
    });

  }

});

