//Newsletter - add event for successfully subscribing to the newsletter
if($('.mc4wp-success').length>0){
    send_event("Contacts","Newsletter subscribed", lang);
}


debug_message("TODO: Assigned success events on mailchimp form");