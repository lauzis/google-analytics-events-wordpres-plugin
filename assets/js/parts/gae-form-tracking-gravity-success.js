// Gravity Forms announces an AJAX confirmation only as a jQuery event, so this
// works where Gravity Forms itself has loaded jQuery, and stays quiet elsewhere.
if (typeof window.jQuery === "function"){
    window.jQuery(document).on('gform_confirmation_loaded', function(event, formId){
        send_event("Form", "Form Submitted Successfully", "Gravity form "+formId, null)
    });
}
