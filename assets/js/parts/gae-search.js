document.querySelectorAll("form").forEach(function(form){

    if (form.classList.contains("gae-event")){
        return;
    }

    var search_field = form.querySelector('input[name="s"]');
    if (!search_field){
        return;
    }

    form.addEventListener("submit", function(){
        send_event("Search", "Search Submitted", search_field.value, null);
    });
    form.classList.add("gae-event", "gae-event-search");

    search_field.addEventListener("change", function(){
        send_event("Search", "Search Used", search_field.value, null);
    });
    search_field.classList.add("gae-event", "gae-event-search");
});
