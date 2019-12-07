$( document ).ready( function() {
	console.log( "Initialized" );
	// First we build a dropzone on the div set aside
	//$( "#my-dropzone" ).dropzone( { url: $( "#dropzone-url" ).val() } );

	// Gather information
	var param = $( "#dropzone-fallback > input" ).attr( 'name' );

	// Next we enable options
	Dropzone.options.myDropzone = {
		//method: 'post',
		paramName: param,
		acceptedFiles: "image/*",
		addRemoveLinks: false,
		uploadMultiple: false,
		init: function() {
			var myDropzone = this;

			this.on( "sending", function( file, xhr, formData ) {
				console.log( "Sending data!" );
				formData.append( $("#imageid").attr('name'), $("#imageid").attr('value') );
				/*
				$.each( $( "#dropzone-data" ), function() {
					formData.append( this.attr( 'name' ), this.attr( 'value' ) );
				} );
				*/
				//myDropzone.processQueue();
			 } );
		}
	};

 } );
