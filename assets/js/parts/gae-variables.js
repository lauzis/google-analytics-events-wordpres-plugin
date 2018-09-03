if (typeof GAE_DEBUG_LEVEL === "undefined"){
    var GAE_DEBUG_LEVEL = [gae-debug-level];
}

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
            debug_message("We found whatm we, need. Analytics "+function_name+"() detected!");
        }
    }
}

if (typeof(GAE_TIME_TRIGGER_TRESHOLD)==="undefined"){
    var GAE_TIME_TRIGGER_TRESHOLD = [gae-time-trigger-treshold];
}

if (typeof contact_page_link === "undefined"){
    var contact_page_link="";
}

//TODO if not defined have to read body class?
// fallback to body class
if (typeof lang === "undefined"){
    var lang="en";
}

var tracked_form_values = [];

//gravity forms class for tracking value and sending it to when form is succesfull
var value_tracking_selector = '.ga-track-value select, .ga-track-value input, select.ga-track-value, input.ga-track-value';

var click_tracking_elements = '.kad-btn, .ga-track-click, .yop_poll_vote_button, .btn-cta, .cta-btn';

var HOST = document.location.hostname;
