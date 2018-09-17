if (!self.hasClass("gae-event")){
    if (is_file(url)){
        self.click(function(){
            var text = get_link_text(self);
            send_event("File download",'File download clicked', text);
        });
        self.addClass("gae-event");
        self.addClass("gae-event-file-downloads");
    };
}

