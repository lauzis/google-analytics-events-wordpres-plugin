const GAE_SECTIONS = [
    {
        id: 'gae-event-contact-links',
        name: 'Contact Links',
        enabled: [gae-event-contact-links]
    },
    {
        id: 'gae-event-custom-element-tracking',
        name: 'Custom elements by selector',
        enabled: [gae-event-custom-element-tracking]
    },
    {
        id: 'gae-event-custom-links',
        name: 'Custom links by special attributes',
        enabled: [gae-event-custom-links]
    },
    {
        id: 'gae-event-file-downloads',
        name: 'File downloads',
        enabled: [gae-event-file-downloads]
    },
    {
        id: 'gae-event-form-submission-tracking',
        name: 'Form submission',
        enabled: [gae-event-form-submission-tracking]
    },
    {
        id: 'gae-event-form-tracking-field-change',
        name: 'On field change',
        enabled: [gae-event-form-tracking-field-change]
    },
    {
        id: 'gae-event-form-tracking-gravity-success',
        name: 'Gravity form tracking',
        enabled: [gae-event-form-tracking-gravity-success]
    },
    {
        id: 'gae-event-mailchimp',
        name: 'Mailchimp success',
        enabled: [gae-event-mailchimp]
    },
    {
        id: 'gae-event-outgoing-links',
        name: 'Outgoing links',
        enabled: [gae-event-outgoing-links]
    },
    {
        id: 'gae-event-search',
        name: 'Search submit',
        enabled: [gae-event-search]
    },
    {
        id: 'gae-event-social-links',
        name: 'Social links',
        enabled: [gae-event-social-links]
    },
    {
        id: 'gae-event-links-to-specific-urls',
        name: 'Specific urls',
        enabled: [gae-event-track-links-to-specific-urls]
    }
];

if (typeof GAE_DEBUG_LEVEL === "undefined"){
    var GAE_DEBUG_LEVEL = parseInt('[gae-debug-level]') ? parseInt('[gae-debug-level]') : 0;
}

//no need for this as we are checkin in frontend the GAE_DEBUG_LEVEL, does not matter if it by ip or by user role
// if (typeof GAE_DEBUG_ADMIN_LEVEL === "undefined"){
//     var GAE_DEBUG_ADMIN_LEVEL = parseInt('[gae-debug-admin-level]') ? parseInt('[gae-debug-admin-level]') : 0;
// }

if (typeof GAE_SCRIPT_TYPE === "undefined"){
    var GAE_SCRIPT_TYPE = [gae-script-type];

    if (GAE_SCRIPT_TYPE===-1){
        debug_message("Will try to detect if analytics is included or not!");
        function_name="";
        if (typeof ga === "function"){
            GAE_SCRIPT_TYPE = 1;
            function_name="ga";
        }
        if (typeof gtag === "function"){
            GAE_SCRIPT_TYPE = 0;
            function_name="gtag";
        }
        //if still unknow test failed
        if (GAE_SCRIPT_TYPE===-1){
            debug_message("We could not find the gtag/ga, must be that google analytics script is not included!");
        } else {
            debug_message("We found what we, need. Analytics "+function_name+"() detected!");
        }
    }
}

if (typeof(GAE_TIME_TRIGGER_THRESHOLD)==="undefined"){
    var GAE_TIME_TRIGGER_THRESHOLD = [gae-time-trigger-threshold];
}

var tracked_form_values = [];

//gravity forms class for tracking value and sending it to when form is succesfull
var value_tracking_selector = '.ga-track-value select, .ga-track-value input, select.ga-track-value, input.ga-track-value';

var HOST = document.location.hostname;
