(function($) {
	'use strict';

	$('document').ready(function(){
		
		$('.bbsm-button-delete').live('click', function(){
            var $self = $(this),
                id = $self.attr('data-id'),
                $table = $self.closest('table').DataTable(),
                $row = $self.closest('tr');
                
            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this scene!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then(function(willDelete){
                
                if (willDelete) {
                    $('.bb-ajax-loading').css({display: 'flex'});
                    $.post(ajaxurl, { 'action': 'bbsm_delete_scene', id: id }, function(response) {
                        
                        response = JSON.parse(response);
                        if(typeof response.status != 'undefined') {
                            $.growl({ title: response.title, message: response.message, location: 'br', style: response.status });
                            
                            if(response.status == 'notice') {
                                $table.row($row).remove();
                                $table.draw();
                            }
                        }
                        
                        $('.bb-ajax-loading').css({display: 'none'});
                        
                    });
                }
            });
            
            return;
            
        });
		
		$('.bbsm-button-duplicate').live('click', function(){
            var $self = $(this),
				id = $self.attr('data-id'),
                base_url = $self.attr('data-base-url'),
                $table = $self.closest('table').DataTable(),
                $row = $self.closest('tr');
                
            swal({
                title: "Are you sure?",
                text: "Copy this scene!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then(function(willDuplicate){
                
                if (willDuplicate) {
                    $('.bb-ajax-loading').css({display: 'flex'});
                    $.post(ajaxurl, { 'action': 'bbsm_duplicate_scene', id: id }, function(response) {
                        
                        response = JSON.parse(response);
                        if(typeof response.status != 'undefined') {
                            $.growl({ title: response.title, message: response.message, location: 'br', style: response.status });
                            
                            if(response.status == 'notice') {
								
								var row = '<tr>'+
									'<td><strong>'+response.row.id+'</strong></td>'+
									'<td>'+response.row.title+'</td>'+
									'<td>'+response.row.name+'</td>'+
									'<td style="text-align: right">'+
										'<a class="button success bbhelp--top" bbhelp-label="Edit" title="Edit" href="'+base_url+response.row.id+'">'+
											'<span class="dashicons dashicons-edit"></span>'+
										'</a>'+'\n'+
										'<button data-base-url="'+base_url+'" class="bbsm-button-duplicate button primary bbhelp--top" bbhelp-label="Duplicate" data-id="'+response.row.id+'">'+
											'<span class="dashicons dashicons-admin-page"></span></button>'+'\n'+
										'<button class="bbsm-button-delete button danger bbhelp--top" bbhelp-label="Delete" data-id="'+response.row.id+'">'+
											'<span class="dashicons dashicons-trash"></span></button>'+'\n'+
									'</td>'+
								'</tr>';
									
                                $table.row.add($(row)).draw(false);
                            }
                        }
                        
                        $('.bb-ajax-loading').css({display: 'none'});
                        
                    });
                }
            });
            
            return;
            
        });
    
	});
}(window.jQuery));
