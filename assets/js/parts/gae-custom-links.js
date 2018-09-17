if(self.data("gaCategory") && self.data("gaAction") && self.data("gaLabel")){
    // <a href="link to somehting or place" data-ga-category="Shopping cart" data-ga-action="Clicked" data-ga-label="In Header">Click me </a>
    self.click(function(){
        send_event(self.data("gaCategory"), self.data("gaAction"), self.data("gaLabel"));
    });
    self.addClass("gae-event");
    self.addClass("gae-event-custom-links");
};