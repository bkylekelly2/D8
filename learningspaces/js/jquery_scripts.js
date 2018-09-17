jQuery( document ).ready(function() {
///////////////////////////  // Handler for .ready() called.

  var popupMargins = 40;
  var windowWidth = jQuery(window).width();
  var windowHeight = jQuery(window).height();
  if (windowWidth >= 600) popupMargins = 100;

  updateContainer();
  updateMapDimensions();

  jQuery(window).resize(function() {

    updateContainer();
    updateMapDimensions();

    windowWidth = jQuery(window).width();
    windowHeight = jQuery(window).height();

    // Putting this here instead of in updateContainer() because it was causing errors re: the dialog not being initialized
    if (windowWidth >= 600) {
      popupMargins = 100;
    } else {
      popupMargins = 40;
    }
    jQuery("#filters-dialog, #room").dialog("option", "height", windowHeight - popupMargins);
    jQuery("#filters-dialog, #room").dialog("option", "width", "calc(100% - " + popupMargins + "px)");

  });

  var effectDur = 400;
  jQuery("#filters-dialog").dialog({
    autoOpen: false,
    modal: true,
    draggable: false,
    resizable: false,
    show: {effect:"slide", duration: effectDur, direction:"down"},
    hide: {effect:"slide", duration: effectDur, direction:"down"},
    width: "calc(100% - " + popupMargins + "px)",
    height: windowHeight - popupMargins,
    title: jQuery("#spaces-filters h2").text(),
    create: function() {
    },
    buttons: {
      "Apply Filters": function() {
      angular.element(document.getElementById('page')).scope().setAppliedFiltersTrue();
	  jQuery( this ).dialog("close");
      angular.element(document.getElementById('page')).scope().submitFilters();
      },
      Cancel: function() {
      jQuery(this).dialog("close");
	var	formValues = angular.element(document.getElementById('page')).scope().getTheFormData();
	angular.element(document.getElementById('page')).scope().cancel(formValues);
      }
    },
    open: function() {

		////////////////////////////////////////////////////////////////////
		var formDataValues = angular.element(document.getElementById('page')).scope().getTheFormData();
		angular.element(document.getElementById('page')).scope().setModalOpenTrue();
		////////////////////////////////////////////////////////////////////
		console.log("open-start");//////////////////////////////////////////
		console.log(formDataValues);////////////////////////////////////////
		console.log("open-end");////////////////////////////////////////////
		////////////////////////////////////////////////////////////////////		
		
      jQuery('.ui-widget-overlay').hide().fadeIn(effectDur);
      // Move the filters from their normal location in the page to inside the dialog (I tried getting around this, but it seemed like the less buggy/fragile route)
      if (jQuery(this).attr("id") == "filters-dialog") {
        jQuery(this).append(jQuery("#spaces-filters"));
      }
      // Add an empty link so that jQuery UI Dialog has something initial but hidden to set focus on, both so that keystrokes for sure work there,
      // and so that other elements don't look oddly focused by default.
      jQuery(this).prepend('<a href="#" class="sr-only dialog-focus" onclick="return false"></a>');
      // Make the links in the contents of the space information open in new tab / have "external link" icon, 
      // so that one doesn't risk losing dialog after needing to hit back (the page refreshes in mobile browsers instead of leaving the current modal state)
      var infoLinks = jQuery(this).find(".information-contents a");
      infoLinks.attr("target","_blank");
      infoLinks.append(' <i class="fa fa-external-link-alt"></i>');
      // This prevents the body from scrolling and thus the popup from going off-page when trying to scroll within it
      jQuery("body").css({ overflow: 'hidden' });
      // This allows one to close the popup by clicking in the dark area around it
      jQuery('.ui-widget-overlay').bind('click', function() {
	jQuery(this).prev().find(".ui-dialog-content").dialog("close");
      });
    },
    beforeClose: function() {
      // This returns the body to its previous state that no longer prevents scrolling 
      jQuery("body").css({ overflow: 'inherit' });
      // Instead of removing/hiding the modal background overlay immediately (while the hide slide effect is still happening), 
      // create another overlay that slowly fades out (since trying to manipulate the default overlay close behavior seems nearly impossible).
      // Thanks to StackOverflow user "Luke": https://stackoverflow.com/a/12848924/5285945
      jQuery('.ui-widget-overlay:first')
        .clone()
        .appendTo('body')
        .show()
        .fadeOut(effectDur, function(){ 
          jQuery(this).remove();
        })
      ;
    },
    close: function() {
	angular.element(document.getElementById('page')).scope().setModalOpenFalse();
	/////////////////////////////////////////////////////////////////
		
      // Re-append the filters to its normal location in the page
      if (jQuery(this).attr("id") == "filters-dialog") {
        jQuery("#spaces-listing").after(jQuery("#spaces-filters"));
        jQuery("#list-trigger").focus();
      }
    },
  });
///////////////////////////////////////////////////////////////////////////////////////
  jQuery("#room").dialog({
    autoOpen: false,
    modal: true,
    draggable: false,
    resizable: false,
    show: {effect:"slide", duration: effectDur, direction:"down"},
    hide: {effect:"slide", duration: effectDur, direction:"down"},
    width: "calc(100% - " + popupMargins + "px)",
    height: windowHeight - popupMargins,
    title: jQuery("#spaces-filters h2").text(),
    create: function() {
    },
    buttons: {
      "Apply Filters": function() {
        //jQuery(".provisionally-changed").removeClass("provisionally-changed");
        jQuery( this ).dialog("close");
      },
      Cancel: function() {
        jQuery( this ).dialog("close");
      }
    },
    open: function() {
      jQuery('.ui-widget-overlay').hide().fadeIn(effectDur);
      // Move the filters from their normal location in the page to inside the dialog (I tried getting around this, but it seemed like the less buggy/fragile route)
      if (jQuery(this).attr("id") == "filters-dialog") {
        jQuery(this).append(jQuery("#spaces-filters"));
      }
      // Add an empty link so that jQuery UI Dialog has something initial but hidden to set focus on, both so that keystrokes for sure work there,
      // and so that other elements don't look oddly focused by default.
      jQuery(this).prepend('<a href="#" class="sr-only dialog-focus" onclick="return false"></a>');
      // Make the links in the contents of the space information open in new tab / have "external link" icon, 
      // so that one doesn't risk losing dialog after needing to hit back (the page refreshes in mobile browsers instead of leaving the current modal state)
      var infoLinks = jQuery(this).find(".information-contents a");
      infoLinks.attr("target","_blank");
      infoLinks.append(' <i class="fa fa-external-link-alt"></i>');
      // This prevents the body from scrolling and thus the popup from going off-page when trying to scroll within it
      jQuery("body").css({ overflow: 'hidden' });
      // This allows one to close the popup by clicking in the dark area around it
      jQuery('.ui-widget-overlay').bind('click', function() {
	jQuery(this).prev().find(".ui-dialog-content").dialog("close");
      });
    },
    beforeClose: function() {
      // This returns the body to its previous state that no longer prevents scrolling 
      jQuery("body").css({ overflow: 'inherit' });
      // Instead of removing/hiding the modal background overlay immediately (while the hide slide effect is still happening), 
      // create another overlay that slowly fades out (since trying to manipulate the default overlay close behavior seems nearly impossible).
      // Thanks to StackOverflow user "Luke": https://stackoverflow.com/a/12848924/5285945
      jQuery('.ui-widget-overlay:first')
        .clone()
        .appendTo('body')
        .show()
        .fadeOut(effectDur, function(){ 
          jQuery(this).remove();
        })
      ;
    },
    close: function() {
      // Re-append the filters to its normal location in the page
      if (jQuery(this).attr("id") == "filters-dialog") {
        jQuery("#spaces-listing").after(jQuery("#spaces-filters"));
        jQuery("#list-trigger").focus();
      }
    },
  });
///////////////////////////////////////////////////////////////////////////////////////

  // If the filters are changed while in the dialog, add a class to indicate that such a change is provisional, 
  // so that these can be undone if "Cancel" or "X" is chosen instead of "Apply Filters"
  //jQuery("body").on("change", "#filters-dialog input", function() {
   // jQuery(this).toggleClass("provisionally-changed");
  //});

  jQuery("#filter-trigger").on("click keypress", function(e) {
    if (e.type == "click" || (e.type == "keypress" && e.which == 13)) {
      jQuery("#filters-dialog").dialog().dialog("open");
      if (e.type == "click") jQuery(this).blur();
    }
  });
  jQuery("#map-trigger").on("click keypress", function(e) {
    if (e.type == "click" || (e.type == "keypress" && e.which == 13)) {
      jQuery(this).addClass("selected").siblings().removeClass("selected");
      jQuery("#rooms").hide();
      jQuery("#spaces-map").show();
      jQuery(".pane-local-footer-gwtoday-footer-panel-pane, #footer").hide();
      if (e.type == "click") jQuery(this).blur();
    }
  });
  jQuery("#list-trigger").on("click keypress", function(e) {
    if (e.type == "click" || (e.type == "keypress" && e.which == 13)) {
      jQuery(this).addClass("selected").siblings().removeClass("selected");
      jQuery("#rooms").show();
      jQuery(".pane-local-footer-gwtoday-footer-panel-pane, #footer").show();
      if (jQuery("#map-trigger").is(":visible")) {
        jQuery("#spaces-map").hide();
      }
      if (e.type == "click") jQuery(this).blur();
    }
  });

  var roomsObserver = new MutationObserver( function(mutations) {
    // After new results have been loaded: 
    // * Hide the "We're finding your spaces [loading ...]" text
    // * Recheck the map dimensions (in case they've pushed the footer in our out of view)
    jQuery("#initial-page-loading").hide();
    updateMapDimensions();
//console.log("scrollTop is: " + jQuery(window).scrollTop());
//console.log("spaces-listing height is: " + jQuery("#spaces-listing").outerHeight());
//console.log("spaces-listing offset.top is: " + jQuery("#spaces-listing").offset().top);
//console.log("partially in window (with buffer)?: " + ((jQuery("#spaces-listing").outerHeight() + jQuery("#spaces-listing").offset().top - jQuery(window).scrollTop()) > 100) );
//console.log("partially in window (with buffer)?: " + ((jQuery("#spaces-listing").outerHeight() + jQuery("#spaces-listing").offset().top - jQuery(window).scrollTop())) );

  });
  roomsObserver.observe( document.getElementById("rooms"), { childList: true } );

  var loadObserver = new MutationObserver( function(mutations) {
    if (jQuery("#load").text().trim() == "") {
      jQuery("#load").hide();
    } else {
      jQuery("#load").show();
    }
  });
  loadObserver.observe( document.getElementById("load"), { childList: true, subtree: true, characterData: true } );

  jQuery("#main-content").on("click keypress", ".roomTeaser, .infoWindowRoom", function(e) {
    if (e.type == "click" || (e.type == "keypress" && e.which == 13)) {
      var rid = jQuery(this).attr('data-room-id');
      var spaceTitle = "";
      if (jQuery(this).hasClass("roomTeaser")) {
        spaceTitle = jQuery(this).find("h2").text();
      } else {
        // At the moment we're apparently concatenating building name plus room name/number (at least for teaser, so make consistent)
        spaceTitle = jQuery(this).closest(".infoWindowRooms").find("h3").text() + " " + jQuery(this).text();
      }
      jQuery.ajax({
        async: true,
        type: "POST",
        url: "/learningspaces/get_room",
        data: { roomID: rid },
        cache: false,
        success: function(data){
          jQuery("#room").html(data);
          var roomButton = {
            Close: function() { 
				jQuery(this).dialog("close"); 
			}
          };
			
        if (rid!==0){ //added in case of no results
			jQuery("#room").dialog("option","buttons",roomButton).dialog("option","title",spaceTitle).dialog("open");
			
		}
		  
          // Initialize the image carousel. Using Slick over others tried out such as Bootstrap, lightSlider, and jCarousel, 
          // since it seems to have good support for swiping, responsiveness, multiple slides at a time, graceful fallbacks for edge cases (e.g. fewer slides than slidesToShow), etc.)
          // Demos and documentation here: http://kenwheeler.github.io/slick/
          // Init event functions needs to be run before slick is initialized.  Tests if there are images not currently displayed (by presence of next arrow) in order to add a class to the carousel.
          jQuery('.slick').on('init reinit setPosition', function (event, slick, direction) {
            if (jQuery(".slick .slick-next").length) {
              jQuery(".slick").addClass("unseen-images");
            } else {
              jQuery(".slick").removeClass("unseen-images");
            }
          });
          $('.slick').slick({
            slidesToShow: 3,
            prevArrow: '<span class="slick-prev"><span class="off-screen">Previous</span></span>',
            nextArrow: '<span class="slick-next"><span class="off-screen">Next</span></span>',
            infinite: false,
            responsive: [
              {
                breakpoint: 850,
                settings: {
                  slidesToShow: 2,
                }
              },
              {
                breakpoint: 500,
                settings: {
                  slidesToShow: 1,
                }
              }
            ]
          });
          if (jQuery(window).width() > 500) {
            // Initialize the image carousel's lightbox, which is based on upon the same 'Slick' code
            $('.slick').addClass("clickable-images").slickLightbox({
              itemSelector: 'div[data-large-image]',
              src: 'data-large-image',
              slick: {
                infinite: false,
                prevArrow: '<span class="slick-prev"><span class="off-screen">Previous</span></span>',
                nextArrow: '<span class="slick-next"><span class="off-screen">Next</span></span>',
              },
              layouts: { closeButton: '<span class="slick-lightbox-close"><span class="off-screen">Close</span></span>', },
              imageMaxHeight: '1',
            }).on({
              // Set focus in the lightbox upon opening it. Otherwise hitting Escape closes both the lightbox and the jQueryUI dialog.
              'show.slickLightbox': function() {
                jQuery(".slick-lightbox .slick-current").focus();
              }, 
            }).on({
              // Set focus back on the dialog upon closing the lightbox.  Otherwise, focus gets lost and one isn't able to use keys in the dialog
              'hide.slickLightbox': function() {
                jQuery("#room .dialog-focus").focus();
              }, 
            });
          } else {
            jQuery(".slick a").on("click focus", function(e) {
              e.preventDefault();
            });
          }

          // Initialize a Google map of just the single space in question inside the dialog
          var sslat = parseFloat($("#single-space-map").data("latitude"));
          var sslon = parseFloat($("#single-space-map").data("longitude"));
          if (!isNaN(sslat) && !isNaN(sslon))  {
            var sscenter = new google.maps.LatLng(sslat, sslon);
            var ssmap = new google.maps.Map($("#single-space-map")[0], { 
              zoom: 17, 
              center: sscenter,
            });
            var ssmarker = new google.maps.Marker({position: sscenter, map: ssmap});
          }

        }
      });
    }
  });
	
  // Toggle the filter sections on or off either by clicking on the header, or by hitting Enter while it's in focus (for our tab-based users)
  jQuery(".filter_division h3").on("click keypress", function(e) {
    if (e.type == "click" || (e.type == "keypress" && e.which == 13)) {
      var filter = jQuery(this).closest(".filter_division");
      var toggle = jQuery(this).find(".filter-toggle");
      var contents = jQuery(this).next();
      if (filter.hasClass("collapsed")) {
        contents.slideDown(100, function() {
          toggle.html("&ndash;");
          toggle.attr("title","Collapse this filter");
          filter.removeClass("collapsed");
          if (!jQuery('#filters-dialog').dialog('isOpen')) updateMapDimensions();
        });
      } else {
        contents.slideUp(100, function() {
          toggle.text("+")
          toggle.attr("title","Show this filter");
	  filter.addClass("collapsed");
          if (!jQuery('#filters-dialog').dialog('isOpen')) updateMapDimensions();
        });
      }
    }
  });

/////////////////////////////////////////////////
});

function updateContainer() {

  var mobileNav = jQuery("#navigation-mobile");
  var triggers = jQuery("#triggers");
  var spacesListing = jQuery("#spaces-listing");

  if (mobileNav.length == 1 && mobileNav.css("position") == "fixed") {
    triggers.css("top", mobileNav.outerHeight());
    spacesListing.css("margin-top", mobileNav.outerHeight() + triggers.outerHeight());
  } else {
    triggers.css("top", 0);
    spacesListing.css("margin-top", 0);
  }

  // If we're wide enough for the map to show next to the listing (detected by #map-trigger being hidden via CSS media queries),
  // then trigger the "Spaces/List" option to be highlighted and make sure the map is shown (in case it was explicitly hidden previously by 
  // a click on #map-trigger followed by a click on #list-trigger)
  if (jQuery("#map-trigger").is(":hidden")) {
    jQuery("#list-trigger").click();
    jQuery("#spaces-map").show();
  // Though if the map were previously explicitly set to display:block, hide it again if we're resizing back down
  } else if (jQuery("#list-trigger.selected").length) {
    jQuery("#spaces-map").hide();
  }

}

// This also includes setting the sticky navbar, since I'm including scrolling functions in here (which I'm including here to make use of several of the variables defined here)
function updateMapDimensions() {

  var windowHeight = jQuery(window).height();
  var header = jQuery("#header");
  var headerHeight = header.height();
  var nav = jQuery("#nav-bar:visible");
  var navMobile = jQuery("#navigation-mobile:visible");
  var navHeight = (nav.height() || 0) + (navMobile.height() || 0); // the "|| 0" part because sometimes the menu changes mean one of these might not exist and thus return null
  var triggers = jQuery("#triggers:visible");
  var fixedTriggersHeight = triggers.css("position") === "fixed" ? triggers.outerHeight() : 0;
  var mapDiv = jQuery("#map-wrapper");
  // Get initial scrollTop and visibleHeader values on initial page load (which might be below fold)
  var scrollTop = jQuery(document).scrollTop();
  var visibleHeader = Math.max(0, headerHeight - scrollTop);

  // Set the navbar to be sticky if the page is sufficiently scrolled down
  if (visibleHeader == 0) nav.removeClass("unsticky").addClass("sticky");

  // Then calculate visibleFooter, since its offset will be affected by navbar's stickiness or not
  var footer1 = jQuery(".pane-local-footer-gwtoday-footer-panel-pane:first");
  var footer1Top = footer1.offset().top;
  var visibleFooter = Math.max(0, windowHeight + scrollTop - footer1Top);
  if (footer1.is(":hidden")) visibleFooter = 0;

  // On page load or resize, set the dimensions for the map and set the navbar to be sticky if the page is sufficiently scrolled down
  mapDiv.height(windowHeight - visibleHeader - navHeight - fixedTriggersHeight - visibleFooter)
        .width(mapDiv.parent().width())
        .css("top", visibleHeader + navHeight + fixedTriggersHeight);

  // When scrolling, adjust the map to be as tall as the window minus the visible portion of the header and minus the navbar height and minus any triggers/tabs if they're displaying.
  // Also make the navbar sticky if scrolling past its location in the normal flow
  jQuery(document).scroll(function() {
    // Update scrollTop, visibleHeader, and visibleFooter values after scrolling and any possible sticky navbar setting
    scrollTop = jQuery(this).scrollTop();
    visibleHeader = Math.max(0, headerHeight - scrollTop);
    if (visibleHeader == 0) {
      nav.addClass("sticky").removeClass("unsticky");
    } else {
      nav.removeClass("sticky").addClass("unsticky");
    }
    footer1Top = footer1.offset().top;
    visibleFooter = Math.max(0, windowHeight + scrollTop - footer1Top);
    if (footer1.is(":hidden")) visibleFooter = 0;
    mapDiv.height(windowHeight - visibleHeader - navHeight - fixedTriggersHeight - visibleFooter)
          .css("top", visibleHeader + navHeight + fixedTriggersHeight);
  });

}