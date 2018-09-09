$( "form" ).each(function(){

    var self = $(this);
    if (!self.hasClass("gae-event")){
        self.submit(function(event){
            //lets try to find title

            var self = $(this);
            var category = self.data("gaCategory");
            var action = self.data("gaAction");
            var label = self.data("gaLabel");
            var value = self.data("gaValue");

            if (!category){
                category = "Form";
            }
            if (!action){
                action = "Form Submited";
            }
            if (!label){
                label = get_link_text(self);
            }
            if (!value){
                value = null;
            }

            send_event(category, action, label, value)

        });
        self.addClass("gae-event");
        self.addClass("gae-event-form-submition");
    }
});