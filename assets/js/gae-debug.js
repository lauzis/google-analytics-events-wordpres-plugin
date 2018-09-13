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
        this.addInfoElement("  ".this.messageNr+": "+message);
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
                id: 'gae-event-track-links-to-specific-urls',
                name: 'Specific urls'
            },
            {
                id: 'gae-event-custom-links',
                name: 'Custom coded links'
            },
            {
                id: 'gae-event-social-links',
                name: 'Social links'
            },
            {
                id: 'gae-event-file-downloads',
                name: 'File downloads'
            },
            {
                id: 'gae-event-outgoing-links',
                name: 'Outgoing links'
            },
            {
                id: 'gae-event-custom-element-tracking',
                name: 'Custom element click tracking'
            },
            {
                id: 'gae-event-search',
                name: 'Search submit tracking'
            },
            {
                id: 'gae-event-mailchimp',
                name: 'Mailchimp tracking'
            },
            {
                id: 'gae-event-form-tracking-gravity-success',
                name: 'Gravity form tracking'
            },
            {
                id: 'gae-event-form-tracking-field-change',
                name: 'Form use tracking'
            },
            {
                id: 'gae-event-form-submission-tracking',
                name: 'Form use tracking'
            }
        ];

         let html='<div class="gae-colors show "><a class="gae-info-close" onclick="GAE_DEBUG.closeInfo(this);" href="#close">Close</a><span id="gae-info-content"><ul>';

         let x=null;
         for (x in sections){
             html+='<li class="gae-event '+sections[x].id+'">'+sections[x].name+'</li>';
         }
         html+='</ul>'+
             '</span></div>';
        return html;
    },
    getInfoTemplate: function(message){
        return '<div class="gae-info show gae-info-'+this.messageNr+'"><a class="gae-info-close" onclick="GAE_DEBUG.closeInfo(this);" href="#close">Close</a><span id="gae-info-text">'+message+'</span></div>';
    },
    closeInfo : function(obj){
        obj.parentElement.remove();
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