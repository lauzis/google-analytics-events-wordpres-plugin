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
            return this.getDefaultValue(id);
        }
    },
    set: function (id, value){
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
            return false;
        } else {
            return this.defaultValues[id];
        }
    }
}


jQuery(document).ready(function(){
    jQuery('.section-title').click(function(){

        var self =  jQuery(this);
        var parent =  jQuery(this).parent().parent();
        var id = parent.parent().attr("id");


        if (parent.hasClass("closed")){
            parent.removeClass("closed");
            GAE_STORAGE.set(id+"-closed",false);
        } else {
            parent.addClass("closed");
            GAE_STORAGE.set(id+"-closed",true);
        }
    });

    jQuery('.section-title').each(function(){
        var self = jQuery(this);

        var parent =  jQuery(this).parent().parent();
        var id = parent.parent().attr("id");

        if (GAE_STORAGE.get(id+"-closed")==="true"){
            parent.addClass("closed");
        } else {
            parent.removeClass("closed");
        }
    })
});