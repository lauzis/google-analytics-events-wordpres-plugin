var GAE_STORAGE = {
    defaultValues:{

    },
    isEnabled: function(){
        let storage = window.sessionStorage;
        if (typeof(storage) !== "undefined") {
            return true;
        }
        return false;
    },
    get:function (id) {
        let local_id = "gae-"+id;
        let storage = window.sessionStorage;
        if (typeof(storage) !== "undefined") {
            if (typeof window.sessionStorage[local_id]==="undefined"){
                return this.getDefaultValue(id)
            } else {
                return window.sessionStorage[local_id];
            }
        } else {
            this.getDefaultValue(id);
        }
    },
    set: function (id, value){
        console.log("setting vaue:",id,":",value);
        let local_id = "gae-"+id;
        let storage = window.sessionStorage;
        if (typeof(storage) !== "undefined") {
            // Code for localStorage/sessionStorage.
            window.sessionStorage[local_id]=value;
            return true;
        } else {
            // Sorry! No Web Storage support..
            return false;
        }
    },
    getDefaultValue(id){
        let local_id = "gae-"+id;
        if (typeof this.defaultValues[id]==="undefined"){
            console.log("no default value for :",id);
            return null;
        } else {
            return this.defaultValues[id];
        }
    }
}


var GAE_DEBUG = {

    messageNr:1,

    addClass: function(elemnt_id,class_name){
        var el = document.getElementById(elemnt_id);
        el.classList.add(class_name);
    },
    removeClass: function(elemnt_id,class_name){
        var el = document.getElementById(elemnt_id);
        el.classList.remove(class_name);
    },
    showMessage : function(message){
        this.addInfoElement(this.messageNr+": "+message);
        this.messageNr++;
    },
    appendHtml: function(el, str) {
        var div = document.createElement('div');
        div.innerHTML = str;
        while (div.children.length > 0) {
            el.appendChild(div.children[0]);
        }
    },
    getColorInfoTemplate: function(){
         let show = "";

         if (GAE_STORAGE.get("showColorBox")===1){
             show=" show";
         }

         var sections = GAE_SECTIONS;
         let html='<div class="gae-colors'+show+'">' +
             '<a class="gae-info-close" onclick="GAE_DEBUG.hideColorBox(this);" href="#close">Close Color Sheet</a>' +
             '<a class="gae-info-open" onclick="GAE_DEBUG.showColorBox(this);" href="#open">Open Color Sheet</a>' +
             '<div class="gae-info-content"><ul>';

         let x=null;
         for (x in sections) {
             if (sections[x].enabled){
                 html+='<li onclick="GAE_DEBUG.showHideColors(\''+sections[x].id+'\');" id="'+sections[x].id+'" class="gae-event-switch gae-event '+sections[x].id+'">'+sections[x].name+'</li>';
             }
         }
         html+='</ul>'+
             '<p>' +
             'Note, that If you "switch off" some or all trackers, it does not switch off element tracking! ' +
             'This is just visual debug tool! To Find what elements are tracked in page! ' +
             'Also not all tracked elements can be displayed (example is time triggered event). ' +
             'If you want to switch some element tracking off, you have to do it via administration, plugin settings, at least in current version of plugin.' +
             ''+
             '</p>'+
             '</div></div>';
        return html;
    },
    getInfoTemplate: function(message){
            let closeForEverButton = "";

            if (GAE_STORAGE.isEnabled()){
                if (GAE_STORAGE.get(message)){
                    return null;
                }

                closeForEverButton='<a class="gae-info-close gae-info-close-forever" onclick="GAE_DEBUG.closeInfoForEver(this,\''+message+'\');" href="#close-for-ever">Close for ever</a>';
            }
            return '<div class="gae-info show gae-info-'+this.messageNr+'">' +
                        '<span class="gae-info-text">'+message+'</span>' +
                        '<a class="gae-info-close" onclick="GAE_DEBUG.closeInfo(this);" href="#close">Close</a>' +
                        closeForEverButton +
                    '</div>';
    },
    closeInfo : function(obj){
        obj.parentElement.remove();
    },
    closeInfoForEver : function(obj,message){

        console.log("------------");
        console.log("close info for ever!");
        console.log(message);
        console.log("------------");

        GAE_STORAGE.set(message,1);
        obj.parentElement.remove();
    },
    showColorBox : function(obj){
        GAE_STORAGE.set("showColorBox",1);
        var self = jQuery(obj.parentElement);
        self.addClass("show");
    },
    hideColorBox : function(obj){
        GAE_STORAGE.set("showColorBox",0);
        var self = jQuery(obj.parentElement);
        self.removeClass("show");
    },
    showHideColors : function(eventType){
        jQuery('.'+eventType).each( function(){
            var self = jQuery(this);
            if (self.hasClass("gae-hide-color")){
                self.removeClass("gae-hide-color");
            } else {
                self.addClass("gae-hide-color");
            }
        });
    },
    addInfoElement: function(message){
        this.appendHtml(document.body,this.getInfoTemplate(message));
    },
    addColorElement: function(){
        this.appendHtml(document.body,this.getColorInfoTemplate());
    },
    init : function(){
        this.addInfoElement("We are in debug mode");
        this.addColorElement();
    }

}


GAE_DEBUG.init();