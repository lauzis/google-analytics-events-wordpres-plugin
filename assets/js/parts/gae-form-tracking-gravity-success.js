// Gravity Forms shows a confirmation by putting #gform_confirmation_wrapper_<id>
// on the page: in place of the form after an AJAX submit, or in the reloaded
// page after a normal one. Watching for it needs no jQuery. The "save and
// continue" notice uses the same wrapper with form_saved_message_sent, so skip it.
var gravity_success_sent = {};

function gravity_success_check(element){
    if (!element.id || element.id.indexOf("gform_confirmation_wrapper_") !== 0){
        return;
    }
    if (element.classList.contains("form_saved_message_sent")){
        return;
    }
    var formId = element.id.replace("gform_confirmation_wrapper_", "");
    if (gravity_success_sent[formId]){
        return;
    }
    gravity_success_sent[formId] = true;
    send_event("Form", "Form Submitted Successfully", "Gravity form "+formId, null);
}

document.querySelectorAll('[id^="gform_confirmation_wrapper_"]').forEach(gravity_success_check);

new MutationObserver(function(mutations){
    mutations.forEach(function(mutation){
        mutation.addedNodes.forEach(function(node){
            if (node.nodeType !== 1){
                return;
            }
            gravity_success_check(node);
            node.querySelectorAll('[id^="gform_confirmation_wrapper_"]').forEach(gravity_success_check);
        });
    });
}).observe(document.body, {childList: true, subtree: true});
