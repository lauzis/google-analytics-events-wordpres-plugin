if(self.dataset.gaCategory && self.dataset.gaAction && self.dataset.gaLabel){
    // <a href="link to somehting or place" data-ga-category="Shopping cart" data-ga-action="Clicked" data-ga-label="In Header">Click me </a>
    self.addEventListener("click", function(){
        send_event(self.dataset.gaCategory, self.dataset.gaAction, self.dataset.gaLabel);
    });
    self.classList.add("gae-event", "gae-event-custom-links");
};
