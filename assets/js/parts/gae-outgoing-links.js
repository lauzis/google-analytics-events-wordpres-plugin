if (!self.hasClass("gae-events")){

    if (is_outgoing_url(url)){
        self.click(function(){
            var text = get_link_text(self);
            send_event("Outgoing links",'Outgoing link clicked', text.trim()+' button clicked');
        });
        self.addClass("gae-events");
        self.addClass("gae-events-outgoing-links");

    };

    debug_message("Assigned click events on outgoing links!");
}

