//EMAIL ADDRESS LINKS CLICKED

document.querySelectorAll('a[href^="mailto:"]').forEach(function(link){

    link.addEventListener("click", function(){
        var click_position = get_element_position(link);
        send_event('Contacts', "Email address clicked"+ click_position, link.textContent.trim());
    });

    link.classList.add("gae-event", "gae-event-contact-links");
});


//PHONE NUMBERS CLICKED
document.querySelectorAll('a[href^="tel:"]').forEach(function(link){

    link.addEventListener("click", function(){
        var selected_phone = link.getAttribute("href").replace("tel:","");
        var click_position = get_element_position(link);
        send_event("Contacts", "Phone number clicked "+ click_position, selected_phone.trim());
    });

    link.classList.add("gae-event", "gae-event-contact-links");
});
