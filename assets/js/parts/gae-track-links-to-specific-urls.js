if (!self.classList.contains("gae-event")){

    var gae_destinations_to_track = "[gae-track-links-to-specific-urls-list]".split(",");
    if (gae_destinations_to_track.indexOf(url) !== -1){
        self.classList.add("gae-event", "gae-event-links-to-specific-urls");

        self.addEventListener("click", function(){
            send_event("Links by destination",'Target link clicked',get_link_text(self));
        });
    }
}
