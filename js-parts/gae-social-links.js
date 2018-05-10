var social_links = get_social_profile_links();
var social_link_tracker_added = false;
for (x in social_links){
    if (url.indexOf(social_links[x].url)!=-1){
        //1.. Social buttons - add events for clicking the social buttons
        self.click(function(){
            var self = $(this);
            var url="";
            url = self.attr("href");
            var text = get_link_text(self);
            if (text.length==0){
                var social_links = get_social_profile_links();
                for (x in social_links) {
                    if (url.indexOf(social_links[x].url)!=-1) {
                        text = social_links[x].title;
                        break;
                    }
                }
            }
            send_event("Contacts",'Social button clicked',text);
            social_link_click = true;

        });
        self.addClass("gae-events");
        social_link_tracker_added = true;
    }
}

if (social_link_tracker_added){
  //skipp looping cause we already added the event
  return;
}
