jQuery(document).bind('gform_confirmation_loaded', function(event, formId){
    // code to be trigger when confirmation page is loaded

    category = "Form";
    action = "Form Submitted";
    label = get_link_text("Gravity form "+formId);

    send_event(category, action, label, value)

});