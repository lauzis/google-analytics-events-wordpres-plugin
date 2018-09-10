var formsUsed = [];

function formBeenUsed(formId){

    let x = null;
    for (x in formsUsed){
        if (typeof(formsUsed[x].formId)!=="undefined" && formsUsed[x].formId===formId){
            return true;
        }
    }
    return false;
}

$("form").each(function(){

    let form = $(this);
    let gravityFormId=get_gravity_form_id(form.attr("id"));
    let form_id = null;

    if (gravityFormId){
        form_id = gravityFormId;
    } else {
        form_id = get_link_text(form);
    }

    form.find('textarea,input[type="email"],input[type="text"],select').each(function(index, element){
        var input = $(this);
        var input_id = input.attr("id") ? input.attr("id") : input.attr("name");
        input.data("formId", form_id);

        if(!input.hasClass("gae-event")){
            input.change(function(){
                let input = $(this);
                let input_id = input.attr("id") ? input.attr("id") : input.attr("name");
                let form_id = input.data("formId");
                let gravityFormId= get_gravity_form_id(form_id);

                var category = input.data("gaCategory");
                var action = input.data("gaAction");
                var label = input.data("gaLabel");
                var value = input.data("gaValue");

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
                if (gravityFormId){
                    label = "Gravity form used "+gravityFormId;
                }


                if (!formBeenUsed(form_id)){
                    send_event(category, action, label, value);
                    formsUsed.push({"formId":form_id,"fieldId":input_id});
                } else {
                    debug_message("Already sent event about this form use, not sending second time! Category:"+category+", Action:"+action+", Lable:"+label+", Value:"+value);
                }



            });
            input.addClass("gae-event");
            input.addClass("gae-event-form-field-change");
        }

    });
});