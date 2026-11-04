
//Newsletter - add event for successfully subscribing to the newsletter
var mailchimp_success = document.querySelector('.mc4wp-success');
if(mailchimp_success){

    var mailchimp_form = mailchimp_success.closest("form");
    var mailchimFormId = get_mail_chimp_id(mailchimp_form ? mailchimp_form.getAttribute("id") : null);
    var label = "Mailchimp form";
    if (mailchimFormId){
        label = "Mailchimp form "+mailchimFormId;
    }
    send_event("Form", "Form Submitted Successfully", label, null)
}
