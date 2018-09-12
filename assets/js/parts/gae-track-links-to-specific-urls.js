if (!self.hasClass("gae-events")){

    var gae_destinations_to_track = "[gae-track-links-to-specific-urls-list]";
    gae_destinations_to_track = gae_destinations_to_track.split(",");
    var gaeD2T = null;
    for(gaeD2T  in gae_destinations_to_track) {
        if (url===gae_destinations_to_track[gaeD2T]){
            self.addClass("gae-events");
            self.addClass("gae-events-urls-by-destination");

            self.click(function(){
                var self = $(this);
                var text = get_link_text(self);
                send_event("Links by destination",'Target link clicked',text);
            });
        }
    }
}

