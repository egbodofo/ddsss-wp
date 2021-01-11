

////////////////////////////////////

jQuery(function($){
    
           $('#booking-rules-table').on('click', '.booking_rule_edit', function(event){
              var p_li = $(this).parent();
				p_li.find('label, input, textarea').css('display', 'block')
					.animate({opacity: 1}, 400);
                p_li.find('input[type="button"]').css('display', 'inline-block');
                
                $(this).addClass('booking_rule_edit_opened');
                $(this).removeClass('booking_rule_edit');
                
                $('#booking-rules-table').on('click', '.booking_rule_edit_opened', function(event){
                   $(this).addClass('booking_rule_edit');
                   $(this).removeClass('booking_rule_edit_opened');
                   var ppp_li = $(this).parent();
				    ppp_li.find('label, input, textarea').animate({opacity: 0}, 400).css('display', 'none'); 
                });    
                
                $('#booking-rules-table').on('click', 'input[type="button"]', function(event){ 
                   event.stopPropagation(); 
                   var booking_rule_id = $(this).data('i'),
                       pp_li = $(this).parent(),
                       rule_title = pp_li.find('[id^="update_rule_title"]').val();
              jQuery('#booking-rules-table').html('<span class="spin_f"><i class="fas fa-spinner fa-spin fa-2x"></i></span>');      
        jQuery.ajax({
		url : babe_rules_lst.ajax_url,
		type : 'POST',
		data : {
			action : 'update_rule',
            booking_rule_id : booking_rule_id,
            rule_title : rule_title,
            // check
	        nonce : babe_rules_lst.nonce
		},
		success : function( msg ) {
            //jQuery("#booking-rules-table").html(msg);
            location.reload(true);
		  }
        });
                });    
           });
           
       ////////////////////////////////////////////////    

       $('#booking-rules-table').on('click', '.booking_rule_del', function(event){
          event.stopPropagation(); 
          var booking_rule_id = $(this).data('i');
          
          babe_overlay_open();
                    
          $('#confirm_del_rule').on('click', '#delete', function(event){
           babe_overlay_close();
                       
           jQuery('#booking-rules-table').html('<span class="spin_f"><i class="fas fa-spinner fa-spin fa-2x"></i></span>');      
        jQuery.ajax({
		url : babe_rules_lst.ajax_url,
		type : 'POST',
		data : {
			action : 'del_rule',
            booking_rule_id : booking_rule_id,
            // check
	        nonce : babe_rules_lst.nonce
		},
		success : function( msg ) {
            jQuery("#booking-rules-table").html(msg);
            ///////////////    
		  }
        });
       }); ///////  end click delete  
    });

});

//////////////////////////////

jQuery(function($){
    
       var start_val = $('input[name="babe_tmp_settings[basic_booking_period]"]:checked').data('label');
    
       update_booking_period_label(start_val);
       
       $('input[name="babe_tmp_settings[basic_booking_period]').on('change',function(){
          var new_val = $(this).data('label');
          update_booking_period_label(new_val);
       });
       
       ////////////////////
       function update_booking_period_label(val){
          $('.booking_period_label').html(val);        
       }
});

//////////////////////////////

function alertObj(obj) { 
    var str = ""; 
    for(k in obj) { 
        str += k+": "+ obj[k]+"\r\n"; 
    } 
    alert(str); 
}

