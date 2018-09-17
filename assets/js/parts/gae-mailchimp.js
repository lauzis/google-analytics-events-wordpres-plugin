
//Newsletter - add event for successfully subscribing to the newsletter
if(jQuery('.mc4wp-success').length>0){

    let mailchimFormId = get_mail_chimp_id(jQuery('.mc4wp-success').first().closest("form").attr("id"));
    let category = "Form";
    let action = "Form Submitted Successfully";
    let label = "Mailchimp form";
    if (mailchimFormId){
        label = "Mailchimp form "+mailchimFormId;
    }
    let value = null;
    send_event(category, action, label, value)
}