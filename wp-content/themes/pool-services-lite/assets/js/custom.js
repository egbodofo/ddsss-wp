function pool_services_lite_menu_open_nav() {
	window.pool_services_lite_responsiveMenu=true;
	jQuery(".sidenav").addClass('show');
}
function pool_services_lite_menu_close_nav() {
	window.pool_services_lite_responsiveMenu=false;
 	jQuery(".sidenav").removeClass('show');
}

jQuery(function($){
 	"use strict";
   	jQuery('.main-menu > ul').superfish({
		delay:       500,
		animation:   {opacity:'show',height:'show'},
		speed:       'fast'
   	});
});

jQuery(document).ready(function () {
	window.pool_services_lite_currentfocus=null;
  	pool_services_lite_checkfocusdElement();
	var pool_services_lite_body = document.querySelector('body');
	pool_services_lite_body.addEventListener('keyup', pool_services_lite_check_tab_press);
	var pool_services_lite_gotoHome = false;
	var pool_services_lite_gotoClose = false;
	window.pool_services_lite_responsiveMenu=false;
 	function pool_services_lite_checkfocusdElement(){
	 	if(window.pool_services_lite_currentfocus=document.activeElement.className){
		 	window.pool_services_lite_currentfocus=document.activeElement.className;
	 	}
 	}
 	function pool_services_lite_check_tab_press(e) {
		"use strict";
		// pick passed event or global event object if passed one is empty
		e = e || event;
		var activeElement;

		if(window.innerWidth < 999){
		if (e.keyCode == 9) {
			if(window.pool_services_lite_responsiveMenu){
			if (!e.shiftKey) {
				if(pool_services_lite_gotoHome) {
					jQuery( ".main-menu ul:first li:first a:first-child" ).focus();
				}
			}
			if (jQuery("a.closebtn.mobile-menu").is(":focus")) {
				pool_services_lite_gotoHome = true;
			} else {
				pool_services_lite_gotoHome = false;
			}

		}else{

			if(window.pool_services_lite_currentfocus=="responsivetoggle"){
				jQuery( "" ).focus();
			}}}
		}
		if (e.shiftKey && e.keyCode == 9) {
		if(window.innerWidth < 999){
			if(window.pool_services_lite_currentfocus=="header-search"){
				jQuery(".responsivetoggle").focus();
			}else{
				if(window.pool_services_lite_responsiveMenu){
				if(pool_services_lite_gotoClose){
					jQuery("a.closebtn.mobile-menu").focus();
				}
				if (jQuery( ".main-menu ul:first li:first a:first-child" ).is(":focus")) {
					pool_services_lite_gotoClose = true;
				} else {
					pool_services_lite_gotoClose = false;
				}
			
			}else{

			if(window.pool_services_lite_responsiveMenu){
			}}}}
		}
	 	pool_services_lite_checkfocusdElement();
	}
});

(function( $ ) {
	jQuery(window).load(function() {
	    jQuery("#status").fadeOut();
	    jQuery("#preloader").delay(1000).fadeOut("slow");
	})
	$(window).scroll(function(){
		var sticky = $('.header-sticky'),
			scroll = $(window).scrollTop();

		if (scroll >= 100) sticky.addClass('header-fixed');
		else sticky.removeClass('header-fixed');
	});
	$(document).ready(function () {
		$(window).scroll(function () {
		    if ($(this).scrollTop() > 100) {
		        $('.scrollup i').fadeIn();
		    } else {
		        $('.scrollup i').fadeOut();
		    }
		});
		$('.scrollup i').click(function () {
		    $("html, body").animate({
		        scrollTop: 0
		    }, 600);
		    return false;
		});
	});
	$(window).on('load', function() {
  		$(this).impulse();
	});
})( jQuery );