//runs fn once the DOM is there (right away if it already is)
function gae_ready(fn){
    if (document.readyState !== "loading") {
        fn();
    } else {
        document.addEventListener("DOMContentLoaded", fn);
    }
}

/*
 that could be possible to determine
 if top or bottom element clicked
 getting the position of the element
 */
function get_element_position(element){

    var position = element.dataset.gaPosition;
    if (typeof(position)!=="undefined" && position.length>0){
        return position;
    }

    // fallback if data-ga-position not defined: the nearest header, footer or aside
    var area = element.closest("header, footer, aside");
    if (!area){
        return "";
    }
    switch(area.nodeName){
        case "HEADER":
            return "Header";
        case "FOOTER":
            return "Footer";
        case "ASIDE":
            return "Sidebar";
    }
    return "";
}


//helper function to check if link is outgoing link
function is_outgoing_url(url){

    if (url.indexOf(HOST)!==-1){
        return false;
    } else {
        if (url.length>4){
            if (url.substring(0, 7)!=="http://" && url.substring(0, 8)!=="https://"){
                return false;
            }
        }
        if (url.indexOf("?")==0 || url.length==0 || url.indexOf("/")==0 || url.indexOf("#")==0){
            return false;
        } else {
            return true;
        }
    }
}


//the list of downloadable files
function get_valid_file_extensions(){
    return ['.pdf','.doc','.docx','.zip','.xls','.xslx','.odt','.ods','.ppt','.pptx'];
}


//helper function that check if the link is downlodable file
function is_file(url){
    var file_extension = "." + url.split('.').pop();
    if (file_extension.length<5){
        return get_valid_file_extensions().indexOf(file_extension) !== -1;
    }
    return false;
}


//function that gets title of the sectiom/page
function get_title(){

    var title = "";
    var h1 = document.querySelector("h1");
    if (h1){
        title = h1.textContent;
    }
    if (title.trim().length==0){
        title = document.title.split("-").shift();
    }

    if (title.trim().length==0){
        var h2 = document.querySelector("h2");
        if (h2){
            title = h2.textContent;
        }
    }

    if (title.trim().length==0){
        title = document.location.href;
    }

    return title.trim();
}


//social profile links defined
function get_social_profile_links()
{
    var social_links = [];
    social_links.push({"url":"facebook.com","title":"Facebook"});
    social_links.push({"url":"twitter.com","title":"Twitter"});
    social_links.push({"url":"linkedin.com","title":"LinkedIn"});
    social_links.push({"url":"youtube.com/user/","title":"Youtube User"});
    social_links.push({"url":"youtube.com/channel/","title":"Youtube Channel"});
    social_links.push({"url":"draugiem.lv","title":"Draugiem Lv"});
    social_links.push({"url":"instagram.com","title":"Instagram"});
    social_links.push({"url":"pinterest.com","title":"Pinterest"});
    social_links.push({"url":"plus.google.com","title":"Google +"});
    return social_links;

}


//geting the link text / label for the ga event
function get_link_text(element){

    var text = element.textContent.trim();

    //fallback / overwrite
    if(element.dataset.gaLabel){
        return element.dataset.gaLabel.trim();
    }

    if (element.getAttribute("title")){
        return element.getAttribute("title").trim();
    }

    if(element.getAttribute("alt")){
        return element.getAttribute("alt").trim();
    }

    if (element.nodeName === "FORM"){

        var headings = ["h1", "h2", "h3"];
        for (var i = 0; i < headings.length; i++){
            var heading = element.querySelector(headings[i]);
            if (heading){
                return heading.textContent.trim();
            }
        }

        var attributes = ["name", "id", "role"];
        for (var j = 0; j < attributes.length; j++){
            if (element.getAttribute(attributes[j])){
                return element.getAttribute(attributes[j]);
            }
        }

        var submitBtn = element.querySelector('input[type=submit]');
        if (submitBtn && submitBtn.value){
            return submitBtn.value;
        }
        return "unknown form"

    }

    if(text){
        return text;
    }

    if(element.getAttribute("value")){
        return element.getAttribute("value").trim();
    }

    return "unknow";
}


function send_event(category, action, label, value){

    if(GAE_SCRIPT_TYPE===1 || GAE_SCRIPT_TYPE===3){

        if (typeof ga === "function"){
            ga('send', 'event',category, action, label, value );
            debug_message('ga called: category='+category+' action='+action+' label='+label+' value='+value);
        } else {
            debug_message("We could not find ga function. Is Google analytics loaded?");
        }

    }

    if (GAE_SCRIPT_TYPE===0 || GAE_SCRIPT_TYPE===2){

        if (typeof gtag === "function"){
            gtag('event', action, {
                'event_category': category,
                'event_label': label,
                'value': value
            });
            debug_message('gtag called: category='+category+' action='+action+' label='+label+' value='+value);
        } else {
            debug_message("We could not find gtag function. Is Google analytics loaded?");
        }
    }
    if (GAE_SCRIPT_TYPE===-1){
        debug_message("We could not find gtag / ga function. Is Google analytics loaded?");
    }
}


function debug_message(message){

    if (GAE_DEBUG_LEVEL>1) {

        if (typeof GAE_DEBUG === "object" && typeof GAE_DEBUG.showMessage==="function"){
            GAE_DEBUG.showMessage(message);
            console.log(message);
        }
    }

};


function get_gravity_form_id(formId){

    if (!formId){
        return null;
    }

    if (formId.indexOf("gform_")>-1){
        return formId.replace("gform_","");
    }
    return null;
}


function get_mail_chimp_id(formId){
    //mc4wp-form-1

    if (!formId){
        return null;
    }

    if (formId.indexOf("mc4wp-")>-1){
        return formId.replace("mc4wp-","").replace("form-","");
    }
    return null;

}
