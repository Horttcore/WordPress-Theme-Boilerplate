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

		}

	};

	Theme.init();

});