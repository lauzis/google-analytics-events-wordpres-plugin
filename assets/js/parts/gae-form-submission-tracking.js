$( "form" ).each(function(){

    var self = $(this);
    if (!self.hasClass("gae-event")){
        self.submit(function(event){
            //lets try to find title

            var self = $(this);
            var formId = self.attr("id");
            var gravityFormId = get_gravity_form_id(formId);
            var mailchimpFormId = get_mail_chimp_id(formId);
            var category = self.data("gaCategory");
            var action = self.data("gaAction");
            var label = self.data("gaLabel");
            var value = self.data("gaValue");

            if (!category){
                category = "Form";
            }
            if (!action){
                action = "Form Submitted";
            }
            if (!label){
                label = get_link_text(self);
            }
            if (!value){
                value = null;
            }

            //special cases of forms
            if (gravityFormId){
                label = "Gravity form "+gravityFormId;
            }
            if (mailchimpFormId){
                label = "Mailchimp form "+mailchimpFormId;
            }

            send_event(category, action, label, value)

        });
        self.addClass("gae-event");
        self.addClass("gae-event-form-submission");
    }
});