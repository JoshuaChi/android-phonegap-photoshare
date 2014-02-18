jQuery(document).ready(function(){

	jQuery('#loginlink').click(function(e) {    
		e.preventDefault();
		jQuery('#loginformwrapper').toggle();
		jQuery("#loginlink").toggleClass("menu-open");
	});
			 
	jQuery('#registerlink').click(function(e) {    
		e.preventDefault();
		jQuery('#registerformwrapper').toggle();
		jQuery("#registerlink").toggleClass("menu-open");
	});
	
	jQuery('#aboutlink').click(function(e) {    
		e.preventDefault();
		jQuery('#aboutwrapper').toggle();
		jQuery("#aboutlink").toggleClass("menu-open");
	});
			 
	jQuery("#aboutwrapper").mouseup(function() {
		return false
	});		
							 
	jQuery("#registerformwrapper").mouseup(function() {
		return false
	});		
									
	jQuery("#loginformwrapper").mouseup(function() {
		return false
	});		
						
	jQuery(document).mouseup(function(e) {
		if(jQuery(e.target).parent("a.signin").length==0) {
			jQuery("#aboutlink").removeClass("menu-open");
			jQuery("#aboutwrapper").hide();
			jQuery("#loginlink").removeClass("menu-open");
			jQuery("#loginformwrapper").hide();
			jQuery("#registerlink").removeClass("menu-open");
			jQuery("#registerformwrapper").hide();
		}
	});   		 
		 
		 
 jQuery("a.sunny").click( function(){ jQuery
		("body").removeClass().addClass("sunny");
	});

 jQuery("a.lightrain").click( function(){ jQuery
		("body").removeClass().addClass("lightrain");
	});

	jQuery("a.thunderstorm").click( function(){ jQuery
		("body").removeClass().addClass("thunderstorm");
	});		
	 
	jQuery("a.clearnight").click( function(){ jQuery
		("body").removeClass().addClass("clearnight");
	});		
	
	jQuery("a.aurora").click( function(){ jQuery
		("body").removeClass().addClass("auroraborealis");
	});		
	
});
