document.querySelectorAll("form").forEach(function(form){

    if (form.classList.contains("gae-event")){
        return;
    }

    form.addEventListener("submit", function(){

        var formId = form.getAttribute("id");
        var gravityFormId = get_gravity_form_id(formId);
        var mailchimpFormId = get_mail_chimp_id(formId);
        var category = form.dataset.gaCategory;
        var action = form.dataset.gaAction;
        var label = form.dataset.gaLabel;
        var value = form.dataset.gaValue;

        if (!category){
            category = "Form";
        }
        if (!action){
            action = "Form Submitted";
        }
        if (!label){
            label = get_link_text(form);
        }
        if (!value){
            value = null;
        }

        //special cases of forms
        if (gravityFormId){
            form.classList.add("gae-form-tracking-gravity-success");
            label = "Gravity form "+gravityFormId;
        }
        if (mailchimpFormId){
            label = "Mailchimp form "+mailchimpFormId;
            form.classList.add("gae-mailchimp");
        }

        send_event(category, action, label, value)

    });
    form.classList.add("gae-event", "gae-event-form-submission-tracking");
});
