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

        const sections = [
            {
                id: 'gae-event-contact-links',
                name: 'Contact Links'
            },
            {
                id: 'gae-event-custom-element-tracking',
                name: 'Custom elements by selector'
            },
            {
                id: 'gae-event-custom-links',
                name: 'Custom links by special attributes'
            },
            {
                id: 'gae-event-file-downloads',
                name: 'File downloads'
            },
            {
                id: 'gae-event-form-submission-tracking',
                name: 'Form submission'
            },
            {
                id: 'gae-event-form-tracking-field-change',
                name: 'On field change'
            },
            {
                id: 'gae-event-form-tracking-gravity-success',
                name: 'Gravity form tracking'
            },
            {
                id: 'gae-event-mailchimp',
                name: 'Mailchimp success'
            },
            {
                id: 'gae-event-outgoing-links',
                name: 'Outgoing links'
            },
            {
                id: 'gae-event-search',
                name: 'Search submit'
            },
            {
                id: 'gae-event-social-links',
                name: 'Social links'
            },
            {
                id: 'gae-event-links-to-specific-urls',
                name: 'Specific urls'
            }
        ];

         let html='<div class="gae-colors show"><a class="gae-info-close" onclick="GAE_DEBUG.closeInfo(this);" href="#close">Close</a><div class="gae-info-content"><ul>';

         let x=null;
         for (x in sections){
             html+='<li onclick="GAE_DEBUG.showHideColors(\''+sections[x].id+'\');" id="'+sections[x].id+'" class="gae-event-switch gae-event '+sections[x].id+'">'+sections[x].name+'</li>';
         }
         html+='</ul>'+
             '<p>' +
             'If you "switch off" some or all items, it does not switch off element tracking! This is just visual debug tool! To Find what elements ar tracked!!' +
             'If you want to switch some element trakcing of, you have to do it via administration, plugin settings.'+
             '</p>'+
             '</div></div>';
        return html;
    },
    getInfoTemplate: function(message){
        return '<div class="gae-info show gae-info-'+this.messageNr+'"><a class="gae-info-close" onclick="GAE_DEBUG.closeInfo(this);" href="#close">Close</a><span class="gae-info-text">'+message+'</span></div>';
    },
    closeInfo : function(obj){
        obj.parentElement.remove();
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
        console.log("adding element to html");
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