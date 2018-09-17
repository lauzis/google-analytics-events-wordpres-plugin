if (!self.hasClass("gae-event")){

    var gae_destinations_to_track = "[gae-track-links-to-specific-urls-list]";
    gae_destinations_to_track = gae_destinations_to_track.split(",");
    var gaeD2T = null;
    for(gaeD2T  in gae_destinations_to_track) {
        if (url===gae_destinations_to_track[gaeD2T]){
            self.addClass("gae-event");
            self.addClass("gae-event-links-to-specific-urls");

            self.click(function(){
                var self = $(this);
                var text = get_link_text(self);
                send_event("Links by destination",'Target link clicked',text);
            });
        }
    }
}

