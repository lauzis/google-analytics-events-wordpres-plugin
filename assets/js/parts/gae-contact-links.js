//EMAIL ADDRESS LINKS CLICKED
$('a[href^="mailto:"]').click(function(){

    var self = $(this);
    var selected_email = $(this).text();

    var click_position=get_element_position(self);

    send_event('Contacts', "Email address clicked"+ click_position, selected_email.trim());

})

$('a[href^="mailto:"]').addClass("gae-event");


//PHONE NUMBERS CLICKED
$('a[href^="tel:"]').click(function(){
    var self = $(this);

    var selected_phone = self.attr("href");
    selected_phone = selected_phone.replace("tel:","");
    var click_position=get_element_position(self);

    send_event("Contacts", "Phone number clicked "+ click_position, selected_phone.trim());

});
$('a[href^="tel:"]').addClass("gae-event");