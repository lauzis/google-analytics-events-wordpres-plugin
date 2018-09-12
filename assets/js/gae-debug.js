var GAE_DEBUG = {

    addClass: function(elemnt_id,class_name){
        var el = document.getElementById(elemnt_id);
        el.classList.add(class_name);
    },
    removeClass: function(elemnt_id,class_name){
        var el = document.getElementById(elemnt_id);
        el.classList.remove(class_name);
    },
    showMessage : function(message){
        this.addInfoElement(message);
    },
    appendHtml: function(el, str) {
        var div = document.createElement('div');
        div.innerHTML = str;
        while (div.children.length > 0) {
            el.appendChild(div.children[0]);
        }
    },
    getInfoTemplate: function(message){
        return '<div class="gae-info show"><a class="gae-info-close" onclick="GAE_DEBUG.closeInfo(this);" href="#close">Close</a><span id="gae-info-text">'+message+'</span></div>';
    },
    closeInfo : function(obj){
        obj.parentElement.remove();
    },
    addInfoElement: function(message){
        this.appendHtml(document.body,this.getInfoTemplate(message));
    },
    init : function(){
        this.addInfoElement("We are in debug mode");
    }

}



GAE_DEBUG.init();