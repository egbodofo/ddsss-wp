(function($) {

	$(document).ready(function() {

		var bookingForm = $('.lava-booking-form');

		if (bookingForm.length) {
			var today = new Date();
			var tomorrow = new Date();
			var minDays = bookingForm.data('min-days');
			var outDay = new Date();
			outDay.setDate(outDay.getDate() + minDays);

			$('input[id^="bf_check_in_date"]').datepicker({
				dateFormat     : lava_js_data.date_time_format,
				firstDay       : lava_js_data.date_start,
				minDate        : today,
				maxDate        : '+365D',
				numberOfMonths : 1,
				onSelect       : function() {
					var unique = $(this).attr('id').replace('bf_check_in_date_', '');
					var checkout = $('#bf_check_out_date_' + unique);
					var date = $(this).datepicker('getDate');
					if (date) {
						date.setDate(date.getDate() + minDays);
					}
					checkout.datepicker('option', 'minDate', date);
				}
			}).on('click', function() {
				$(this).datepicker('show');
			});

			$('input[id^="bf_check_out_date"]').datepicker({
				dateFormat     : lava_js_data.date_time_format,
				minDate        : tomorrow,
				maxDate        : '+365D',
				numberOfMonths : 1,
				onSelect       : function() {
					var unique = $(this).attr('id').replace('bf_check_out_date_', '');
					var check_in = $('#bf_check_in_date_' + unique);
					var date = $(this).datepicker('getDate');
					if (date) {
						date.setDate(date.getDate() - minDays);
					}
					check_in.datepicker('option', 'maxDate', date);
				}
			}).on('click', function() {
				$(this).datepicker('show');
			});

			$('input[id^="bf_check_in_date"]').datepicker('setDate', 'today');
			$('input[id^="bf_check_out_date"]').datepicker('setDate', outDay);

    		bookingForm.find('select[name="bf_guests"]').dropkick({
	            mobile: true,
	            change: function() {
	                var selectedIndex = this.selectedIndex;
	                $(this.data.select).find('option').each(function(index, elem) {
	                    if (index === selectedIndex) {
	                        $(elem).attr('selected', 'selected');
	                    } else {
	                        $(elem).removeAttr('selected');
	                    }
	                });
	            }
	        });
		}

	    $(document.body)

		    .on('show.bs.modal', '.lava-booking-form-modal', function() {
		        var $this = $(this);
		        $this.after('<div class="modal-backdrop show"></div>');
		        var searchform = $this.parent().find('.hotel-booking-search');
		        if (searchform.length) {
		        	var checkInDate = searchform.find('input[name="bf_check_in_date"]').datepicker('getDate');
		        	var checkOutDate = searchform.find('input[name="bf_check_out_date"]').datepicker('getDate');
		        	var guests = searchform.find('.hb_input_guests :selected').val();
		        	var $guests = $this.find('select[name="bf_guests"]');
		        	if (checkInDate) {
		        		$this.find('input[name="bf_check_in_date"]').datepicker('setDate', checkInDate);
		        	}
		        	if (checkOutDate) {
		        		$this.find('input[name="bf_check_out_date"]').datepicker('setDate', checkOutDate);
		        	}
		        	if ('' != guests) {
		        		$guests.find(':selected').removeAttr('selected', '');
		        		$guests.find('option[value="'+ guests +'"]').attr('selected', 'selected');
		        	}
		        }
		    })

		    .on('hide.bs.modal', '.lava-booking-form-modal', function() {
		        var $this = $(this);
		        $this.siblings('.modal-backdrop').remove();
		    })

	    	.on('submit', '.booking-form', function(e) {
		        e.preventDefault();
		        var $form = $(this);
		        var $message = $form.siblings('.booking-form-message');
		        var hasEmptyFields = false;

		        $form.find('.validate').each(function() {
		            var $field = $(this);
		            if ($field.val() === '') {
		                $field.addClass('invalid');
		                hasEmptyFields = true;
		            } else {
		                $field.removeClass('invalid');
		            }
		        });

		        if (hasEmptyFields) {
		        	$message.html('<span class="error">' + lava_js_data.required_fields + '</span>');
		        	return false;
		        }

		        $.ajax({
		            type: 'POST',
		            url: lava_js_data.ajax_url,
		            dataType: 'json',
		            data: {
		                action: 'lava_booking_form',
		                bf_data: $form.serialize(),
		            },
		            beforeSend: function() {
		            	$form.find('booking-form-submit').addClass('hb_loading');
		            },
		            error: function(xhr, status) {
		                console.log(xhr);
		                console.log(status);
		            },
		            success: function(response) {
		            	if (response.data.message) {
		            		$message.html(response.data.message);
		            		$form.find('booking-form-submit').removeClass('hb_loading');
		            		$form.hide();
		            	}
		            }
		        });
		    });

	});

})(jQuery);
