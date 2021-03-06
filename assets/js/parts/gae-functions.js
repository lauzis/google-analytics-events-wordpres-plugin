/*
 that could be possible to determine
 if top or bottom element clicked
 getting the position of the element
 */
function get_element_position(jq_object){

    var position = "";
    position = jq_object.data("gaPosition");
    if (typeof(position)!=="undefined" && position.length>0){
        return position;
    }

    // fallback function if data-ga-position not defined
    jq_object.parentsUntil('body').each(function(){
        var self = this;
        switch(self.nodeName){
            case "HEADER":
            case "header":
                position="Header";
                return position;

            case "FOOTER":
            case "footer":
                position="Footer";
                return position;

            case "ASIDE":
            case "aside":
                position="Sidebar";
                return position;
        }
    });

    return position;

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


//helper function (php in_array)
function contains(a, obj) {
    var i = a.length;
    while (i--) {
        if (a[i] === obj) {
            return true;
        }
    }
    return false;
}

//the list of downloadable files
function get_valid_file_extensions(){
    return ['.pdf','.doc','.docx','.zip','.xls','.xslx','.odt','.ods','.ppt','.pptx'];
}


//helper function that check if the link is downlodable file
function is_file(url){
    var file_extension = url.split('.').pop();
    file_extension="."+file_extension;
    if (file_extension.length<5){
        return contains(get_valid_file_extensions(),file_extension);
    }
    return false;
}




//function that gets title of the sectiom/page
function get_title($){

    $ = jQuery;
    var title = "";
    if ($("h1").length>0){
        title  = $("h1").first().text();
    }
    if (title.length==0){
        title = document.title;
        title = title.split("-");
        title = title.shift();
    }

    if (title.length==0){
        if ($("h2").length>0){
            title  = $("h2").first().text();
        }
    }

    if (title.length==0){
        title = document.location.href;
    }

    title = title.trim();
    return title;
}

//
function remove_params_from_url(oldURL) {
    var index = 0;
    var newURL = oldURL;
    index = oldURL.indexOf('?');
    if(index == -1){
        index = oldURL.indexOf('#');
    }
    if(index != -1){
        newURL = oldURL.substring(0, index);
    }
    return newURL;
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
function get_link_text(jquery_obj){

    var text=jquery_obj.text();

    //fallback / overwrite
    if(jquery_obj.data("gaLabel")){
        text=jquery_obj.data("gaLabel");
        return text.trim();
    }

    if (jquery_obj.attr("title")){
        text = jquery_obj.attr("title");
        return text.trim();
    }

    if(jquery_obj.attr("alt")){
        text = jquery_obj.attr("alt");
        return text.trim();
    }

    if (jquery_obj.prop("tagName")==="form" || jquery_obj.prop("tagName")==="FORM"){

        let h1 = jquery_obj.find("h1");
        if (h1.length>0){
            return h1.text();
        }
        let h2 = jquery_obj.find("h2");
        if (h2.length>0){
            return h2.text();
        }
        let h3 = jquery_obj.find("h3");
        if (h3.length>0){
            return h3.text();
        }
        let formName = jquery_obj.attr("name");
        if (formName){
            return formName;
        }

        let formID = jquery_obj.attr("id");
        if (formID){
            return formID;
        }

        let formRole = jquery_obj.attr("role");
        if (formRole){
            return formRole;
        }

        let submitBtn = jquery_obj.find('input[type=submit]');
        if (submitBtn.length>0){
            return submitBtn.first().text();
        }
        return "unknown form"

    }

    if(text){
        return text;
    }

    if(jquery_obj.attr("value")){
        text = jquery_obj.attr("value");
        return text.trim();
    }



    return "unknow";
}


//cookie function to track event history
// for example, we want to se trough wich page
//was converted (filled form)
function setCookie(cname, cvalue, exdays) {
    exdays = exdays || 1;
    var d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    var expires = "expires="+d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}


function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}


function json2array(json){
    var result = [];
    var keys = Object.keys(json);
    keys.forEach(function(key){
        result.push(json[key]);
    });
    return result;
}


function push_history(title)
{

    // storring last 5 urls
    var allowed_lenght=3;
    title = title || document.location.href;
    var h_titles =getCookie("history");
    if (h_titles.length>0){
        try {
            var tmp = JSON.parse(h_titles)
            h_titles = json2array(tmp);
            if (title==h_titles[history_urls.length-1]){
                //the last url in history is the same url
                // probabbly user refreshed page
                return;
            }
        } catch(e) {
            return;
        }
    } else {
        h_titles = [];
    }

    //removing if more history than expo
    if (h_titles.length>allowed_lenght){
        h_titles.shift();
    }

    h_titles.push(title);
    setCookie("history",JSON.stringify(h_titles));
}


function pop_history(){

    var history_urls = json2array(JSON.parse(getCookie("history")));
    var url="";
    if (history_urls.length>0){
        url = history_urls.pop();
    }
    setCookie("history",JSON.stringify(history_urls));
    return url;
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

    if (typeof(formId)==="undefined"){
        return null;
    }

    if (formId.indexOf("gform_")>-1){
        return formId.replace("gform_","");
    }
    return null;
}


function get_mail_chimp_id(formId){
    //mc4wp-form-1

    if (typeof(formId)==="undefined"){
        return null;
    }

    if (formId.indexOf("mc4wp-")>-1){
        return formId.replace("mc4wp-","").replace("form-","");
    }
    return null;

}