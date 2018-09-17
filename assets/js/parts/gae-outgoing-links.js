if (!self.hasClass("gae-event")){

    if (is_outgoing_url(url)){
        self.click(function(){
            var text = get_link_text(self);
            send_event("Outgoing links",'Outgoing link clicked', text.trim()+' button clicked');
        });
        self.addClass("gae-event");
        self.addClass("gae-event-outgoing-links");

    };
}

