var formsUsed = [];

function formBeenUsed(formId){

    for (var i = 0; i < formsUsed.length; i++){
        if (formsUsed[i].formId===formId){
            return true;
        }
    }
    return false;
}

document.querySelectorAll("form").forEach(function(form){

    var gravityFormId = get_gravity_form_id(form.getAttribute("id"));
    var mailChimpId = get_mail_chimp_id(form.getAttribute("id"));
    var form_id = gravityFormId ? gravityFormId : get_link_text(form);

    form.querySelectorAll('textarea,input[type="email"],input[type="text"],select').forEach(function(input){

        if(input.classList.contains("gae-event")){
            return;
        }

        input.addEventListener("change", function(){
            var input_id = input.getAttribute("id") ? input.getAttribute("id") : input.getAttribute("name");

            var category = input.dataset.gaCategory;
            var action = input.dataset.gaAction;
            var label = input.dataset.gaLabel;
            var value = input.dataset.gaValue;

            if (!category){
                category = "Form";
            }
            if (!action){
                action = "Form Used";
            }
            if (!label){
                label = get_link_text(form);
            }
            if (!value){
                value = null;
            }

            //special cases of forms
            if (gravityFormId){
                label = "Gravity form used "+gravityFormId;
            }
            if (mailChimpId){
                label = "Mailchimp form used "+mailChimpId;
            }

            if (!formBeenUsed(form_id)){
                send_event(category, action, label, value);
                formsUsed.push({"formId":form_id,"fieldId":input_id});
            } else {
                debug_message("Already sent event about this form use, not sending second time! Category:"+category+", Action:"+action+", Lable:"+label+", Value:"+value);
            }

        });
        input.classList.add("gae-event", "gae-event-form-tracking-field-change");

    });
});
