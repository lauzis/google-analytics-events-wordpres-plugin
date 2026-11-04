if (!self.classList.contains("gae-event")){

    var social_links = get_social_profile_links();

    for (var social_index = 0; social_index < social_links.length; social_index++){
        if (url.indexOf(social_links[social_index].url)!=-1){

            var social_title = social_links[social_index].title;
            self.addEventListener("click", function(){
                var text = get_link_text(self);
                if (text.length==0 || text==="unknow"){
                    text = social_title;
                }
                send_event("Contacts",'Social button clicked',text);
            });
            self.classList.add("gae-event", "gae-event-social-links");
            //one tracker per link
            break;
        }
    }
}
