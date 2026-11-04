var track_elements ='[gae-custom-element-tracking-class]';
var tracked_custom_elements = [];

// left empty in the settings, or never filled in (the placeholder survives)
if (track_elements.length && track_elements.indexOf("[gae-") !== 0){
    try {
        tracked_custom_elements = document.querySelectorAll(track_elements);
    } catch (e) {
        debug_message("Custom element tracking: not a valid selector: "+track_elements);
    }
}

tracked_custom_elements.forEach(function(element){

    if (!element.classList.contains("gae-event")){
        element.addEventListener("click", function(){

            var category = element.dataset.gaCategory;
            var action = element.dataset.gaAction;
            var label = element.dataset.gaLabel;
            var value = element.dataset.gaValue;
            if (!category){
                category = element.nodeName;
            }
            if (!action){
                action = "Clicked";
            }
            if (!label){
                label = get_link_text(element);
            }
            if (!value){
                value = null;
            }

            send_event(category, action, label, value)
        });
        element.classList.add("gae-event", "gae-event-custom-element-tracking");
    }

});
