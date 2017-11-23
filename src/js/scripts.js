var Theme;

jQuery(document).ready(function() {
    Theme = {
        /**
		 * Init
		 */
        init: function() {
            // Cache elements
            Theme.w = jQuery(window);
            Theme.html = jQuery("html");
            Theme.body = jQuery("body");
            Theme.toggleNavButton = jQuery(".toggle-nav");

            // Go!
            Theme.bindings();
        },

        bindings: function() {

            // Toggle nav
            Theme.toggleNavButton.click(function(e) {
                e.preventDefault();
                Theme.toggleNav();
            });

        },

        toggleNav: function() {
            Theme.body.toggleClass("nav--visible");
        }
    };

    Theme.init();
});
