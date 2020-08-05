(function($) {
	'use strict';
/*	
	$(selector).tagsInput({
		'autocomplete_url': url_to_autocomplete_api,
		'autocomplete': { option: value, option: value},
		'height':'100px',
		'width':'300px',
		'interactive':true,
		'defaultText':'add a tag',
		'onAddTag':callback_function,
		'onRemoveTag':callback_function,
		'onChange' : callback_function,
		'delimiter': [',',';'],   // Or a string with a single delimiter. Ex: ';'
		'removeWithBackspace' : true,
		'minChars' : 0,
		'maxChars' : 0, // if not provided there is no limit
		'placeholderColor' : '#666666'
	});
*/

	$('.bb-settings .wp-list-table').DataTable({
		// paging: eval($self.data('paging')),
		// ordering: eval($self.data('ordering')),
		// info: eval($self.data('info')),
		// searching: eval($self.data('searching')),
		// pageLength: eval($self.data('page-length')),
		lengthMenu: [ 
			[10, 25, 50, 100, -1], 
			[10, 25, 50, 100, "All"] 
		],
		responsive: true,
		bDestroy: true,
		"order": [[ 0, "desc" ]]
	});
	
	$('.bb-multi-select').multiSelect({
		selectableHeader: "<span class='dashicons dashicons-search'></span><input type='text' class='bb-filter-input' autocomplete='off' placeholder='Selectable items..'>",
		selectionHeader: "<span class='dashicons dashicons-search'></span><input type='text' class='bb-filter-input' autocomplete='off' placeholder='Selection items..'>",
		afterInit: function(ms){
			var that = this,
			    $selectableSearch = that.$selectableUl.prev(),
			    $selectionSearch = that.$selectionUl.prev(),
			    selectableSearchString = '#'+that.$container.attr('id')+' .ms-elem-selectable:not(.ms-selected)',
			    selectionSearchString = '#'+that.$container.attr('id')+' .ms-elem-selection.ms-selected';

			that.qs1 = $selectableSearch.quicksearch(selectableSearchString)
				.on('keydown', function(e){
					if (e.which === 40){
						that.$selectableUl.focus();
						return false;
					}
				});

			that.qs2 = $selectionSearch.quicksearch(selectionSearchString)
				.on('keydown', function(e){
					if (e.which == 40){
						that.$selectionUl.focus();
						return false;
					}
				});
		},
		afterSelect: function(){
			this.qs1.cache();
			this.qs2.cache();
		},
		afterDeselect: function(){
			this.qs1.cache();
			this.qs2.cache();
		}
	});
	
	$(document).ready(function(){
		$('.bb-field .bb-tags').tagsInput({
			'width':'99%'
		});
		
		$('.bb-colorpicker').wpColorPicker();
		
		$('.bb-dropdown').select2();
	});
	
	var frame;
	$('.bb-upload-image').on('click', function(){
		var $self = $(this);
		
		if($self.hasClass('uploaded')) {
			$self.css({backgroundImage: ''});
			$self.find('input').val('');
			$self.removeClass('uploaded');
			return;
		}
		
		event.preventDefault();
		// If the media frame already exists, reopen it.
		if ( frame ) {
		  frame.open();
		  return;
		}

		// Create a new media frame
		frame = wp.media({
		  title: 'Choose image',
		  button: {
			text: 'Use this image'
		  },
		  multiple: false  // Set to true to allow multiple files to be selected
		});


		// When an image is selected in the media frame...
		frame.on( 'select', function() {

		  // Get media attachment details from the frame state
		  var attachment = frame.state().get('selection').first().toJSON();

		  // Send the attachment URL to our custom image input field.
		  $self.css({backgroundImage: 'url("'+attachment.url+'")'});
		  $self.find('input').val(attachment.id);
		  $self.addClass('uploaded');

		});

		// Finally, open the modal on click
		frame.open();
	});
	
	$.fn.serializeObject = function () {
	    var o = {};
	    var a = this.serializeArray();
	    $.each(a, function () {
	        if (o[this.name] !== undefined) {
	            if (!o[this.name].push) {
	                o[this.name] = [o[this.name]];
	            }
	            o[this.name].push(this.value || '');
	        } else {
	            o[this.name] = this.value || '';
	        }
	    });
	    var $radio = $('input[type=radio],input[type=checkbox]',this);
	    $.each($radio,function(){
	        if(!o.hasOwnProperty(this.name)){
	            o[this.name] = '';
	        }
	    });
	    return o;
	};

	$('.bb-field-row[data-dependency="true"]').each(function(index){
		var $self = $(this),
			__value = $self.data('value').split(',');
		$self.css({display: 'none'});
		
		if( __value.indexOf( $('#' + $self.data('element')).val() ) > -1) {
			$self.css({display: 'flex'});
		}
		$('#' + $self.data('element')).on('change', function(){
			if( __value.indexOf( $(this).val() )  > -1 ) {
				$self.css({display: 'flex'});
			} else {
				$self.css({display: 'none'});
			}
		});
	});

	$( '.bb-field-row .plus, .bb-field-row .minus' ).on( 'click', function() {
		
		function isInt( n ) {
			return n % 1 === 0;
		}
		
		// Get values
		var $number = $( this ).closest( '.bb-number' ).find( '.bb-number-value' ),
			currentVal = parseFloat( $number.val() ),
			max = parseFloat( $number.attr( 'max' ) ),
			min = parseFloat( $number.attr( 'min' ) ),
			step = $number.attr( 'step' );

		// Format values
		if ( !currentVal || currentVal === '' || currentVal === 'NaN' ) {
			currentVal = 0;
		}
		if ( max === '' || max === 'NaN' ) {
			max = '';
		}
		if ( min === '' || min === 'NaN' ) {
			min = 0;
		}
		if ( step === 'any' || step === '' || step === undefined || parseFloat( step ) === 'NaN' ) {
			step = 1;
		}

		// Change the value
		if ( $( this ).is( '.plus' ) ) {

			if ( max && ( max == currentVal || currentVal > max ) ) {
				$number.val( max );
			} else {

				if ( isInt( step ) ) {
					$number.val( currentVal + parseFloat( step ) );
				} else {
					$number.val( (currentVal + parseFloat( step )).toFixed( 1 ) );
				}
			}

		} else {

			if ( min && ( min == currentVal || currentVal < min ) ) {
				$number.val( min );
			} else if ( currentVal > 0 ) {
				if ( isInt( step ) ) {
					$number.val( currentVal - parseFloat( step ) );
				} else {
					$number.val( (currentVal - parseFloat( step )).toFixed( 1 ) );
				}
			}

		}

		// Trigger change event
		$number.trigger( 'change' );
	} );
	
	// Ajax action
	$('.bb-settings .bb-form').on('submit', function(){
		
		bb_begin_ajax();
		$.post( ajaxurl, $( this ).serializeObject(), function(response) {
			response = $.parseJSON(response);
			$.growl({ title: response.title, message: response.message, location: 'br', style: response.status });
			bb_end_ajax();
			if(typeof response.custom_js != undefined) {
				eval(response.custom_js);
			}
		});
		
		return false;

	});
	
	function bb_redirect(url){
		window.location.href = url;
	}
	
	function bb_reset_form(){
		$('.bb-form')[0].reset();
	}
	function bb_add_content(el, content){
		$(el).html(content);
	}
	
	function bbgetParameterByName(name, url) {
	    if (!url) url = window.location.href;
	    name = name.replace(/[\[\]]/g, "\\$&");
	    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
	        results = regex.exec(url);
	    if (!results) return null;
	    if (!results[2]) return '';
	    return decodeURIComponent(results[2].replace(/\+/g, " "));
	}
	
	function bb_after_add(id){
		$('.bb-form').find('input[name="ID"]').val(id);
		window.history.pushState("edit", "Edit", "?page="+bbgetParameterByName('page', window.location.href)+"&ID="+id);
	}
	
	function bb_begin_ajax(){
		$('.bb-ajax-loading').css({display: 'flex'});
	}
	function bb_end_ajax(){
		$('.bb-ajax-loading').css({display: 'none'});
	}
	
	// Couple field
	$('.bb-add-couple').on('click', function(){
		var $self = $(this);
		var count = $self.data('count');
		var $parent = $self.closest('.bb-field');
		var $clone = $parent.find('.bb-couple-clone').html().replace(/bb_insert_key/gi, count + 1).replace(/bb_name_param/gi, 'name');
		
		// $parent.find('.bb-couples').removeClass('bb-no-minus');
		if($parent.find('.bb-hidden-value').length > 0) {
			$parent.find('.bb-hidden-value').remove();
		}
		$parent.find('.bb-couples').append($clone);
		$self.data('count', count + 1);
	});
	$('.bb-minus-couple').live('click', function(){
		var $self = $(this);
		var $parent = $self.closest('.bb-couples');
		
		if($parent.find('.bb-couple').length <= 1) {
			//$parent.addClass('bb-no-minus');
			$parent.append('<input class="bb-hidden-value" type="hidden" name="'+$parent.data('name')+'" value="" />');
			//return;
		}
		$self.closest('.bb-couple').remove();
		
	});
	
}(window.jQuery));
