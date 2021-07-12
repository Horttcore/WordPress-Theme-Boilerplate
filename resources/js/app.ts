const App = {
    /**
     * Cache elenents and init bindings
     */
    boot: function(): void {
        // Cache elements for reusing
        this.html = document.querySelector('html') as HTMLHtmlElement;
        this.body = document.querySelector('body') as HTMLBodyElement;
        this.toggleNavButton = document.querySelector(".js-toggle-navigation") as HTMLElement;
        this.toggleSubNavButton = document.querySelectorAll(".menu-item-has-children > a, .page_item_has_children > a") as NodeListOf<HTMLAnchorElement>;
        this.bindings();
    },

    /**
     * Bind events
     */
    bindings: function() {

        this.toggleNavButton.addEventListener('click', (event: Event) => {
            event.preventDefault();
            App.toggleNav();
        });

        this.toggleSubNavButton.forEach(element => {
            element.addEventListener('click', (event: Event) => {
                event.preventDefault();
                this.toggleSubNav(element, event);
            })
        });
    },

    toggleNav: function(): void {
        this.body.classList.toggle("nav-is--visible");
    },

    toggleSearch: function(): void {
        this.body.classList.toggle("search-is--visible");
    },

    toggleSubNav: function(element, event: Event): void {
        element.parentNode.classList.toggle("subnav-is--visible");
    }
};

App.boot();
