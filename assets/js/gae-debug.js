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
        document.getElementById("gae-info-text").innerHTML=message;
        GAE_DEBUG.addClass("gae-info","show");
    },
    hideMessage : function(timeout){
        if (timeout>0){
            setTimeout(function(){
                GAE_DEBUG.removeClass("gae-info","show")
            }, 3000);
        } else {
            GAE_DEBUG.removeClass("gae-info","show")
        }
    },
    appendHtml: function(el, str) {
        console.log(el);
        var div = document.createElement('div');
        div.innerHTML = str;
        while (div.children.length > 0) {
            el.appendChild(div.children[0]);
        }
    },
    getInfoTemplate: function(){
        return '<div id="gae-info" class="gae-info show"><a id="gae-info-close" href="">Close</a><span id="gae-info-text"></span></div>';
    },
    addInfoElement: function(){
        console.log(document.body);
        this.appendHtml(document.body,this.getInfoTemplate());
        //this.assignEvents();
    },
    assignEvents: function(){
        document.getElementById("gae-info-close").onclick = function() {
            GAE_DEBUG.hideMessage(0);
        }

    },
    init : function(){
        this.addInfoElement();
        this.assignEvents();

        this.showMessage("We are in debug mode");
        this.hideMessage(3000);
    }

}



GAE_DEBUG.init();