//tracking form values, that needs to be tracked
//TODO local storage
$(value_tracking_selector).change(function(){
    var self = $(this);
    var id = self.attr("id");
    if(id){
        tracked_form_values[id] = self.val();
    }
});

debug_message("TODO: Assigned keypress events on form fields");
