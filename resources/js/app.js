const App = {
    /**
     * Cache elenents and bind events
     */
    boot: function() {
        // Cache elements for reusing
        App.html = jQuery("html");
        App.body = jQuery("body");
        App.toggleNavButton = jQuery(".navigation-toggle");
        App.toggleSubNavButton = jQuery(".menu-item-has-children > a");

        App.bindings();
    },

    /**
     * Bind events
     */
    bindings: function() {
        App.toggleNavButton.click(function(e) {
            e.preventDefault();
            App.toggleNav();
        });

        App.toggleSubNavButton.click(function(e) {
            if (!App.toggleNavButton.is(":visible")) return;

            e.preventDefault();
            App.toggleSubNav(jQuery(this));
        });
    },

    /**
     * Toogle nav
     */
    toggleNav: function() {
        App.body.toggleClass("nav-is--visible");
    },

    /**
     * Toggle subnav
     */
    toggleSubNav: function(button) {
        let container = button.parent();
        let subnav = container.find("> ul");

        container.toggleClass("subnav-is--visible");
        subnav.slideToggle();
    }
};

jQuery(document).ready(function() {
    App.boot();
});
