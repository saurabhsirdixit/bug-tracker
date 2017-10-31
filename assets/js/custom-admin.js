jQuery( document ).ready(function() {

	jQuery ('.tabs').tabs ();

	var GalleryState;
	// Uploading files
	var file_frame;

	jQuery('body').on('click', '#tbs_website_logo_id', function (event) {
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
			var attachment_url = attachment.url; 
			jQuery('.tbs-website-logo-class').val(attachment_url);
			jQuery('.tbs-website-logo-class-display').attr( 'src', attachment_url );
			file_frame = undefined;
		});	

		// Finally, open the modal
		file_frame.open();
	});

	jQuery('body').on('click', '#tbs_hero_banner_1', function (event) {
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
			var attachment_url = attachment.url; 
			jQuery('.banner-image-first').val( attachment_url );
			jQuery('.img1').attr( 'src', attachment_url );
			file_frame = undefined;
		});	

		// Finally, open the modal
		file_frame.open();
	});
	
	jQuery('body').on('click', '#tbs_hero_banner_2', function (event) {
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
			var attachment_url = attachment.url; 
			jQuery('.banner-image-second').val( attachment_url );
			jQuery('.img2').attr( 'src', attachment_url );
			file_frame = undefined;
		});	

		// Finally, open the modal
		file_frame.open();
	});


	jQuery('body').on('click', '#tbs_hero_banner_3', function (event) {
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
			var attachment_url = attachment.url; 
			jQuery('.banner-image-third').val( attachment_url );
			jQuery('.img3').attr( 'src', attachment_url );
			file_frame = undefined;
		});	

		// Finally, open the modal
		file_frame.open();
	});

	jQuery('body').on('click', '#tbs_hero_banner_4', function (event) {
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
			var attachment_url = attachment.url; 
			jQuery('.banner-image-fourth').val( attachment_url );
			jQuery('.img4').attr( 'src', attachment_url );
			file_frame = undefined;
		});	

		// Finally, open the modal
		file_frame.open();
	});

});