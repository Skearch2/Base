$( document ).ready( function() {
	//$( ".dropzone" ).options( {
	Dropzone.options.myAwesomeDropzone = {
		maxFiles: 1,
		acceptedFiles: "image/*",
		addRemoveLinks: false,
		autoProcessQueue: false,

		init: function() {
			var dz = this;

			// Set the submit button to process the queue
			$( ".dropzone button[type=submit]" ).click( function(e) {
				// Stop the data from being sent
				e.preventDefault();
				e.stopPropagation();
				dz.processQueue();
			 } );
		 	dz.on( "sending", function( file, xhr, formData ) {
				$( "#hold_me" ).append( "Width: " + file.width + " Height: " + file.height );
				$.each( $( "#add_data" ), function() {
					formData.append( this.attr('name'), this.attr('value') );
				} );
				formData.append( 'test', "Width: " + file.width + " Height: " + file.height );
			} );
		}
	} //);

} );
