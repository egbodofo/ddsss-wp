

////////////////////////////////////

jQuery(function($){
    
       get_prices_form();
       
       get_prices_block();
       
       //////////////////////////////
       
       $('#categories').on('change', function(){
          get_prices_form();
          get_prices_block();
       });
       
       ////////////////////////////////
       
       $('#prices-block').on('click', '.view-rate-title', function(){
           var rate_id = $(this).data('rate-id');
           $(this).toggleClass('opened');
           $('.view-rate-block .view-rate-details[data-rate-id="'+rate_id+'"]').toggleClass('opened');
       });
       
       ///////////////////delete rate/////////////////////////////    

       $('#prices-block').on('click', '.view-rate-details-item-del', function(event){
          //event.stopPropagation(); 
          var rate_id = $(this).data('rate-id');
          var rate_details = $(this).parent();
          var rate_block = $(rate_details).parent();
          
          babe_overlay_open();
                    
          $('#confirm_del_rate').on('click', '#delete', function(event){
           babe_overlay_close();
                       
          $(rate_details).html('<span class="spin_f"><i class="fas fa-spinner fa-spin fa-2x"></i></span>');      
        $.ajax({
		url : babe_prices_lst.ajax_url,
		type : 'POST',
		data : {
			action : 'delete_rate',
            post_id : $('#prices-block').data('obj-id'),
            rate_id : rate_id,
            // check
	        nonce : babe_prices_lst.nonce
		},
		success : function( msg ) {
            $(rate_block).remove();
            ///////////////    
		  }
        });
       }); ///////  end click delete  
    });
       
       /////////////////get_prices_block///////////////////////////////    

       function get_prices_block(){
        
        var cat_slug = $('#categories').val();
                       
           //$('#prices-block').html('<span class="spin_f"><i class="fas fa-spinner fa-spin fa-2x"></i></span>');      
        $.ajax({
		url : babe_prices_lst.ajax_url,
		type : 'POST',
		data : {
			action : 'get_price_details_block',
            cat_slug : cat_slug,
            post_id : $('#prices-block').data('obj-id'),
            // check
	        nonce : babe_prices_lst.nonce
		},
		success : function( msg ) {
            $("#prices-block").html(msg);
            ///////////////
            $( '#prices-block' ).sortable({
                axis: "y",
                placeholder: "ui-state-highlight",
                update: function( event, ui ) {
                   var count = $('#prices-block').children().length;
                   if (count){
                    var i = 1;
                    var rate_orders = {};
                    $('#prices-block').children().each(function(ind, elm){
                        $(elm).attr('data-order', i);
                        rate_orders[$(elm).data('rate-id')] = i;
                        i++;
                    });
                    rates_reorder(rate_orders);
                   }
                }
            });
            ///////////////
            check_base_rate();    
		  }
        });
      }
      
      /////////////////rates_reorder///////////////////////////////    

       function rates_reorder(rate_orders){
          
          var cat_slug = $('#categories').val();
          
           $('#prices-block').css('opacity', '0.5');
                       
           $.ajax({
		   url : babe_prices_lst.ajax_url,
		   type : 'POST',
		   data : {
			action : 'rates_reorder',
            rate_orders : rate_orders,
            post_id : $('#prices-block').data('obj-id'),
            // check
	        nonce : babe_prices_lst.nonce
		   },
		   success : function( msg ) {
            $('#prices-block').css('opacity', '1');   
		   },
           error : function() {
            $('#prices-block').css('opacity', '1');
           }
          });
       }
           
       /////////////////get_prices_form///////////////////////////////    

       function get_prices_form(){
        
        var cat_slug = $('#categories').val();
                       
           $('#prices-form').html('<span class="spin_f"><i class="fas fa-spinner fa-spin fa-2x"></i></span>');      
        $.ajax({
		url : babe_prices_lst.ajax_url,
		type : 'POST',
		data : {
			action : 'get_price_details_form',
            cat_slug : cat_slug,
            post_id : $('#prices-form').data('obj-id'),
            // check
	        nonce : babe_prices_lst.nonce
		},
		success : function( msg ) {
            $("#prices-form").html(msg);
            add_datepicker('#_rate_date_from');
            add_datepicker('#_rate_date_to');   
		  }
        });
       }
    
    /////////////////clear_prices_form///////////////////////////////    

       function clear_prices_form(){
          $('#prices-form').find('input[type="text"]').val('');
          $('#rate-price-conditional-holder').html('');
       }
    
    /////////////////check_base_rate///////////////////////////////    

       function check_base_rate(){
                             
        $.ajax({
		url : babe_prices_lst.ajax_url,
		type : 'POST',
		data : {
			action : 'check_base_rate',
            post_id : $('#prices-form').data('obj-id'),
            // check
	        nonce : babe_prices_lst.nonce
		},
		success : function( msg ) {
            if (msg != ''){
              $('#publish').css('display', 'inline-block'); 
            } else {
              $('#publish').css('display', 'none');  
            }    
		  }
        });
       }
    
    ////////////////add_datepicker/////////////////
    function add_datepicker(id) {
      $( id ).datepicker({
	    numberOfMonths: 1,
        dateFormat: babe_prices_lst.date_format
      });
    }
    
    ///////////////conditional////////
    
    $('#prices-form').on('change', '#rate-price-conditional-generator select', function(el){
        var val = parseInt($(this).val());
        if (val == 0){
            $(this).addClass('select_option_gray');
        } else {
            $(this).removeClass('select_option_gray');
        }
    });
    
    ///////////add_price_conditional
    
    $('#prices-form').on('click', '#rate-price-conditional-generator #add_price_conditional', function(el){
        el.stopPropagation();
        el.preventDefault();
        
        var result_block = $('#rate-price-conditional-holder');
        
        var guests_sign = parseInt($('#rate-price-conditional-generator select[name="conditional_guests_sign_tmp"]').val());
        var guests_number = parseInt($('#rate-price-conditional-generator input[name="conditional_guests_number_tmp"]').val());
        var units_sign = parseInt($('#rate-price-conditional-generator select[name="conditional_units_sign_tmp"]').val());
        var units_number = parseInt($('#rate-price-conditional-generator input[name="conditional_units_number_tmp"]').val());
        
        if ( isNaN(guests_sign) ) {
            guests_sign = 0;
        }
        if ( isNaN(guests_number) ){
            guests_number = '';
        }
        if ( isNaN(units_sign) ){
            units_sign = 0;
        }
        if ( isNaN(units_number) ){
            units_number = '';
        }
        
        var _price_general = {};
        $(".set-age-price.age-price-conditional-tmp").each(function(){_price_general[$(this).data('ind')] = $(this).val();});
        
        var price_adult_check = $(".set-age-price.age-price-conditional-tmp").first().val();
        
        if ( ( (guests_sign && guests_number != '') || (units_sign && units_number != '') ) && price_adult_check){
            ////////////
            var count = $(result_block).children().length;
            var index = count + 1;
            var html = '<li class="conditional_price_block" data-ind="'+index+'"><div class="conditional_price_block_inner">';
            var html_inputs = '<input type="hidden" name="conditional_order['+index+']" value="'+index+'">';
            
            if (guests_sign){
                
                html_inputs += '<input type="hidden" name="conditional_guests_sign['+index+']" value="'+guests_sign+'">';
                html_inputs += '<input type="hidden" name="conditional_guests_number['+index+']" value="'+guests_number+'">';
                html += $('#rate-price-conditional-generator .conditional_guests_number_label').html() + ' ' + $('#rate-price-conditional-generator select[name="conditional_guests_sign_tmp"] option:selected').text() + ' ' + guests_number;
            }
            if (units_sign){
                
                if (guests_sign){
                    html += ' '+ $('#rate-price-conditional-generator .conditional_operator_label').html() + ' ';
                }
                
                html_inputs += '<input type="hidden" name="conditional_units_sign['+index+']" value="'+units_sign+'">';
                html_inputs += '<input type="hidden" name="conditional_units_number['+index+']" value="'+units_number+'">';
                html += $('#rate-price-conditional-generator .conditional_units_number_label').html() + ' ' + $('#rate-price-conditional-generator select[name="conditional_units_sign_tmp"] option:selected').text() + ' ' + units_number;
            }
            
            html += ' ' + $('#rate-price-conditional-generator .conditional_result_label').html() + ' ';
            
            $('#rate-price-conditional-generator').find(".set-age-price.age-price-conditional-tmp").each(function(ind, elm){
                var cur_price = $(elm).val();
                var age_index = $(elm).data('ind');
                var age_label = $(elm).closest('tr').find('.age_title').text();
                html += age_label + cur_price + ' ';
                html_inputs += '<input type="hidden" name="conditional_price['+index+']['+age_index+']" value="'+cur_price+'">';
            });
            
            html += '</div>'+html_inputs+'</li>';
            $(result_block).append(html);
            
            $( result_block ).sortable({
                axis: "y",
                placeholder: "ui-state-highlight",
                update: function( event, ui ) {
                    var count = $(result_block).children().length;
                    var i = 1;
                    $(result_block).children().each(function(ind, elm){
                        var block_index = $(elm).data('ind');
                        $(elm).find('input[name="conditional_order['+block_index+']"]').val(i);
                        i++;
                    });
                }
            });
            ///////////////////
        }
        
    });
    
    //////////////////////////////////////
    
     $('#prices-form').on('click', '#rate_new_open', function(el){
        el.stopPropagation();
        el.preventDefault();
        $('#prices-form .rate_form_inner.no_active').removeClass('no_active');
        $('#rate_new_open').remove();
     });
    
    //////////////////////////////////////
    
     $('#prices-form').on('click', '#add_price', function(el){
        el.stopPropagation();
        el.preventDefault();
        save_prices();
     });
    
    /////////////////save_prices///////////////////////////////    

       function save_prices(){
        
        var cat_slug = $('#categories').val(),
            _rate_title = $('#_rate_title').val(),
            _rate_date_from = $('#_rate_date_from').val(),
            _rate_date_to = $('#_rate_date_to').val(),
            _price_from = $('#_price_from').val(),
            _rate_min_booking = $('#_rate_min_booking').val(),
            _rate_max_booking = $('#_rate_max_booking').val();
        
        var start_days = {};
        $('#prices-form input[name^="start_days"]').each(function(i, el){
            var ind = $(el).val();
            if ($(el).is(':checked')){
                start_days[ind] = ind;
            }
        });
        
        var apply_days = {};
        $('#prices-form input[name^="apply_days"]').each(function(i, el){
            var ind = $(el).val();
            if ($(el).is(':checked')){
                apply_days[ind] = ind;
            }
        });
        
        var _price_general = {};
        $(".set-age-price.age-price-general").each(function(){
           if ($(this).val() != ''){ 
             _price_general[$(this).data('ind')] = $(this).val();
           } 
        });
        
        var _price_general_check = {};
        $(".set-age-price.age-price-general").each(function(){_price_general_check[$(this).data('ind')] = '';});
        //////////////
        var _prices_conditional = {};
        $("#rate-price-conditional-holder").children().each(function(ind, elm){
            var block_index = $(elm).data('ind');
            _prices_conditional[ind] = {};
            _prices_conditional[ind].order = $(elm).find('input[name="conditional_order['+block_index+']"]').val();
            if ($(elm).find('input[name="conditional_guests_sign['+block_index+']"]').length){
                _prices_conditional[ind].conditional_guests_sign = $(elm).find('input[name="conditional_guests_sign['+block_index+']"]').val();
                _prices_conditional[ind].conditional_guests_number = $(elm).find('input[name="conditional_guests_number['+block_index+']"]').val();
            }
            if ($(elm).find('input[name="conditional_units_sign['+block_index+']"]').length){
                _prices_conditional[ind].conditional_units_sign = $(elm).find('input[name="conditional_units_sign['+block_index+']"]').val();
                _prices_conditional[ind].conditional_units_number = $(elm).find('input[name="conditional_units_number['+block_index+']"]').val();
            }
            
            var _prices_conditional_tmp = {};
            $('#rate-price-conditional-generator').find(".set-age-price.age-price-conditional-tmp").each(function(ind2, elm2){
                var age_index = $(elm2).data('ind');
                if ($(elm).find('input[name="conditional_price['+block_index+']['+age_index+']"]').val() != ''){
                   _prices_conditional_tmp[age_index] = $(elm).find('input[name="conditional_price['+block_index+']['+age_index+']"]').val();
                }
            });
            _prices_conditional[ind].conditional_price = _prices_conditional_tmp;
        });
        //////////////
        
        var price_adult_check = $(".set-age-price.age-price-general").first().val();
        
        if( _rate_title != '' && price_adult_check != '' ){
            
            $('#add_price').parent().find('.spin_f').removeClass('no_active');
             
        $.ajax({
		url : babe_prices_lst.ajax_url,
		type : 'POST',
		data : {
			action : 'save_rate',
            cat_slug : cat_slug,
            post_id : $('#prices-form').data('obj-id'),
            _rate_title: _rate_title,
            _rate_date_from: _rate_date_from,
            _rate_date_to: _rate_date_to,
            _rate_min_booking: _rate_min_booking,
            _rate_max_booking: _rate_max_booking,
            _price_general: _price_general,
            _price_from: _price_from,
            _prices_conditional: _prices_conditional,
            start_days: start_days,
            apply_days: apply_days,
            // check
	        nonce : babe_prices_lst.nonce
		},
		success : function( msg ) {
		    $('#add_price').parent().find('.spin_f').addClass('no_active'); 
            clear_prices_form();
            get_prices_block();
            ///////////////    
		  },
        error : function() {
            $('#add_price').parent().find('.spin_f').addClass('no_active');
        }  
        });
        }
    }
    ////////////////////////////

});

