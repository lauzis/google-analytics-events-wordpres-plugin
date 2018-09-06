var track_elements ='[gae-custom-element-tracking-class]';

if (track_elements.length){

    $(track_elements).each(function(){

        var self = $(this);

        if (!self.hasClass("gae-events")){
            self.on("click",function(){

                var self = $(this);
                var category = self.data("gaCategory");
                var action = self.data("gaAction");
                var label = self.data("gaLabel");
                var value = self.data("gaValue");
                if (!category){
                    category = self.prop("tagName");
                }
                if (!action){
                    action = "Clicked";
                }
                if (!label){
                    label = get_link_text(self);
                }
                if (!value){
                    value = null;
                }

                send_event(category, action, label, value)
            });
            self.addClass("gae-events");
            self.addClass("gae-events-custom-element-tracking");
        }

    });
}

debug_message("Assigned click events to custom elements");