if (!self.classList.contains("gae-event")){

    if (is_outgoing_url(url)){
        self.addEventListener("click", function(){
            send_event("Outgoing links",'Outgoing link clicked', get_link_text(self)+' button clicked');
        });
        self.classList.add("gae-event", "gae-event-outgoing-links");

    };
}
