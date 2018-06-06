if (typeof DEBUG_MODE === "undefined"){
    var DEBUG_MODE = true;
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


var IS_GA = false;
