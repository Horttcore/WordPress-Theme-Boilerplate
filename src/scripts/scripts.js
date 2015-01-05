var Theme;

jQuery(document).ready(function(){

	Theme = {

		/**
		 * Init
		 */
		init:function(){

			// Cache elements
			Theme.w = jQuery(window);
			Theme.html = jQuery('html');

			// Go!
			Theme.bindings();

		},

		bindings:function(){

			// Lightbox
			jQuery('a[href$=".jpg"],a[href$=".jepg"],a[href$=".png"]').fancybox();

		},

		submitForm:function( form, options ) {

			if ( Theme.validateForm( form ) && ( undefined === options || undefined === options.validate || ( options && typeof options.validate === 'function' && true === options.validate() ) ) ) {

				if ( options && typeof options.before === 'function' )
					options.before();

				form.addClass('submitting');
				var button = form.find('button[type=submit]').addClass('loading');
				var data = form.serialize();

				jQuery.post( ajaxurl, data, function(response){

					button.removeClass('loading');

					if ( undefined !== options && false !== options.empty ) {
						form.find('input[type="text"],textarea,select').val('');
						form.find('input[type="radio"], input[type="checkbox"]').removeAttr('checked');
					}

					if ( options && typeof options.response === 'function' )
						options.response(form,response);
					else
						form.before(response);

					if ( options && typeof options.after === 'function' )
						options.after(response);

					form.removeClass('submitting');

				});

			}

		},

		validateForm:function( form ){

			if ( form.hasClass('submitting') )
				return false;

			// Remove old validation
			jQuery('.error-input').removeClass('error-input');
			form.find('.message').remove();

			// Cache
			var submit = true,
				requiredFields = form.find('input.required, textarea.required');

			// Validate the fields
			requiredFields.each(function(){
				var obj = jQuery(this);
				if ( '' === obj.val() ) {
					obj.addClass( 'error-input' );
					submit = false;
				}
			});

			return submit;
		}

	};

	Theme.init();

});
