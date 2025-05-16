
const App = {
    /**
     * Cache elenents and init bindings
     */
    boot: function(): void {
        // Cache elements for reusing
        this.html = document.querySelector('html') as HTMLHtmlElement;
        this.body = document.querySelector('body') as HTMLBodyElement;
        this.bindings();
    },

    /**
     * Bind events
     */
    bindings: function() {
    },
};

App.boot();
