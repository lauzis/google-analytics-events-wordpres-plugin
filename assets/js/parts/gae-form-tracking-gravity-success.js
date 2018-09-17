jQuery(document).bind('gform_confirmation_loaded', function(event, formId){
    // code to be trigger when confirmation page is loaded

    let category = "Form";
    let action = "Form Submitted Successfully";
    let label = "Gravity form "+formId;
    let value = null;
    send_event(category, action, label, value)

});