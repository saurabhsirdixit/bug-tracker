jQuery( document ).ready(function() {

	var GalleryState;
	// save project data
	var file_frame;

	jQuery('body').on('click', '#save_proj_data', function (event) { 
	
		var staff_id = jQuery(this).attr('proj_id');

		// If the media frame already exists, reopen it.
		if ( file_frame ) {
		  file_frame.open();
		  return;
		}
		// Create the media frame.
		file_frame = wp.media.frames.file_frame = wp.media({
			title: jQuery( this ).data( 'uploader_title' ),
			button: {
			text: jQuery( this ).data( 'uploader_button_text' ),
			},
			multiple: false  // Set to true to allow multiple files to be selected
		});

		// When an image is selected, run a callback.
		file_frame.on( 'select', function() { 
			// We set multiple to false so only get one image from the uploader
			attachment = file_frame.state().get('selection').first().toJSON();

			// Do something with attachment.id and/or attachment.url here
			var attachment_id = attachment.id;

			jQuery.ajax({
				url: '/tbs-bug-tracker/wp-admin/admin-ajax.php',
				type: 'POST',
				data: {
				action: 'save_new_project',
				attachment_id: attachment_id,
				proj_id: proj_id,
				},
				success:function(data){
					jQuery("#id").html(data);
					file_frame = undefined;
				}

			});
		});

		// Finally, open the modal
		file_frame.open();
	});

	jQuery("body").on ('click','#fetch_project_data',function(){
		var staff_id = jQuery(this).attr('proj_id');
		jQuery.ajax({
			url: '/tbs-bug-tracker/wp-admin/admin-ajax.php',
			type: 'POST',
			data: {
			  action: 'fetch_project_data',
			  proj_id: proj_id,
			},
			success:function(data){
			    jQuery("#id").html(data);
			    file_frame = undefined;
			}

		});

	});
});
